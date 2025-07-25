After consuming numerous books, videos, courses and solving real production problems all related to distributed systems, I think I've come to a conclusion how to better present the fundamental ideas of distributed computing, so that it clicks in one's mind and starts to make sense. What we want is to have a mental model of these ideas that can be applied to various problems, from choosing the right DB for a problem at hand, to distributed caches, designing rate limiting system or anything that seem unrelated, but in fact rely on the same fundamental principles and ideas from the perspective of designing these components for reliability, scalability and (todo).

So below we'll progress from a system that has no replication or sharding whatsoever where all data and processing happens inside a single instance. We'll modify it by adding replication, more instances to handle writes and sharding - to see what we get from different perspectives, what are the tradeoffs and what systems actually implement those configurations.

## Single instance system

![[distributed_systems_overview_1.png]]

(todo - just say it's some simple setup, offers no scalability but these are the benefits, and give some examples of well known systems that use that setup.mention that the only way to handle load is vertical scaling and maybe mention the limits of that)
## Replication with Single Leader

![[distributed_systems_overview_2.png]]

The simplest form of introducing scaling to such system is adding more follower replicas. These replicas can be either read replicas to serve clients their read requests, or just sit there as a hot standby so that it can replace the leader (which is also called master or write replica) in case it goes offline or breaks. All replicas have access to the complete set of data (in databases, usually the data is fully replicated), so there's no need to introduce any traffic routing or sharding strategies (besides routing writes to the leader always).

In both cases, the leader has to replicate its data to those replicas, and there are various approaches to do that (e.g. in databases - send the write ahead log, WAL, or logical commands). But we still have only one leader to handle requests that mutate data or state. 

So, the clients should only connect to the leader to perform write requests, but read requests can be served by any read replica. This mitigates the use cases with high read to write ratio, but doesn't help much when we have many writes. In fact, for some high write scenarios this might be not the best configuration because
* if we choose synchronous replication mode, then our system might become slow or even become unavailable in case it can't reach some read replicas
* if we choose asynchronous replication mode, then readers might see stale data if they go to read replicas, which might not be acceptable (e.g. think of using stale/inconsistent bank account data)

One mitigation strategy to keep updating replicas synchronously is to use quorums (todo is this true?).

Another question is what happens if the leader dies. There are generally two approaches
* manual switch - the administrator has to come and set one of the read replicas as the new leader (todo - is it true? do some modern systems use that and why?). The system becomes unavailable until the admin comes to push the switch but (todo but the benefit is that...)
* automatic leader assignment - systems use a distributed consensus algorithm such as Paxos or Raft or others to elect a new leader. (todo benefits and downsides of this)

One prominent example that supports this approach is traditional PostgreSQL distribution. You can configure hot standby as well as extra read replicas and also configure sync or async replication for every write query (todo verify this and add other important details) . (todo give more examples that follow this configuration)

Besides some limits to scalability that we discussed, there's actually one important benefit to this approach: natural linearizability. If all writes go through the same leader, it's easy to ensure global order, also it's easy to reason about it. 

## Replication with Multiple Leaders

![[distributed_systems_overview_3.png]]

Some situations, such as geo-distributed deployments, collaborative editing (your mobile device that can go offline for days and a server is also a distributed system!) or high availability requirements, require setting up multiple replicas, and assigning more then one of them as write replicas (i.e. leaders). So in other words, we have multiple instances that can accept writes simultaneously. 

In this setup, each leader acts as a follower to other leader. Also, each leader typically manages its own set of followers. And leaders can have a different topology how they propagate changes between each other: all-to-all, circular, star (todo verify this and give examples when this is the case and not the case).

(todo write what else is important that doesn't match to single, and/or mention that some things from there apply here too)

### Resolving conflicts
if writes to one data point arrives to different replicas and they all try to replicate that change, we will get a conflict because we have two conflicting values for the same data point. There is a set of known approaches to resolving the conflicts: 
* LWW - last write wins - the most brutal one, it just takes the version it thinks is the latest (todo briefly write about clock skew and its implications)
* Version vectors: Track causality between updates
* Application-specific resolution: Let application code handle conflicts
* CRDTs: Conflict-free replicated data types that merge automatically
#### Inferring global order

(todo the same question is if it supports linearizability. i think it's not possible to do reliably, am i right? write some brief analysis based on kleppmann's book, but i also heard that there are some systems that rely on very precise clocks and confidence intervals that offer that)

Consistency guarantees depend on how replication between write->write and write->read replicas is configured. It can range from the fastest and most highly available one where everything is replicated asynchronously to highly consistent where we wait for all replicas to respond, and everything in between.

(todo analyze what facts from the Read replication  apply here too and what don't ,and maybe there's something else i missed)

(todo when is this more preferred than leaderless)
## Leaderless replication

![[distributed_systems_overview_4.png.png]]

Leaderless replication is a configuration where each replica can serve serve both read and write requests, so it's actually multi leader replication taken to extreme (each replica is a leader).

(todo write what else is important that doesn't match to single or multi leader, and/or mention that some things from there apply here too)

### Quorum consistency

One important fact is that Leaderless replication, unlike Multi leader replication, takes ownership of Consistency by introducing Quorum Consistency. For example, if we have 3 replicas, we can wait for only 2 replicas to respond on reads, and 2 replicas to respond on writes, and that would give us consistency guarantees (because at least one read replica that we query has the latest value). 

Read repair is a technique to detect stale values (which are possible with quorums) and update them when reading from multiple nodes. Anti-entropy is a background process that compares replicas and fixes differences.

(todo rephrase this to match the style of the article: **Handling Node Failures:**- **Sloppy quorum**: If target nodes are down, write to accessible nodes temporarily; **Hinted handoff**: When original nodes recover, forward the temporary writes)

### Resolving conflicts

(todo write that mostly the approaches from the multi leader apply, but i guess there's some changes)

## Sharding

![[distributed_systems_overview_5.png.png]]

How do we scale our system if there's too much data that doesn't fit into one machine, or there's too many requests per second (todo there's a better term for this metric, like velocity?) for a single instance to handle? The approach is called sharding, where we distribute the load across multiple instances where each instance handles a configured subset of requests (and/or data). 
(todo explain that sharding is orthogonal to replication)

But if we do that there's some questions that arise naturally:

* How do we split the data and/or load and how we add/remove shards? 
* How does the client know which shard should handle the request (e.g. because it owns the data)?
* What if one shard will get disproportional share of load?
* What if a shard becomes dysfunctional (e.g. gets disconnected)

Let's address all of these questions

### Splitting the data and/or load

There are several approaches how to split the load across instances. All of them start with the engineer choosing the key to map requests to instances, but the algorithms of actually mapping them vary:
* Specifying key ranges that map to instances (todo agree? anything to add to that?) (todo tradeoffs, and systems that do that)
* Calculating key hash and mapping it to instances (e.g. by calculating hash mod number of instances or (todo other algorithms briefly if any)) (todo tradeoffs, and systems that do that)
* (todo i think there's other algorithms but i forgot please fill in) (todo tradeoffs, and systems that do that)
* Consistent hashing. For the sake of brevity we won't get deep into that but I just want to say that it's a well-known technique that assigns segments of key hashes to instances, and its extension called virtual nodes (or VNodes) ensures that adding/removing instances don't leave instances with disproportional load. (todo tradeoffs, and systems that do that)
(todo explain how to add/remove nodes in different cases. either augment the above bulletpoints or explain separately here, whatever makes more sense)
### Routing requests to their replicas

Our system can be either leader based or leaderless.

We can have some central component responsible for routing. So clients have to contact it to exchange the sharding key for the ID of the instance (todo an example with sticky sessions and example with mongo and its mongos component, and i think there's smth like this in either k8s or hadoop/spark, and sharded postgresql with citus - explain briefly in bulletpoints to this paragraph). 

Such central component is not always needed, there's two options to map requests to instances without it:
* Clients can infer which instance they want to contact based on the key (todo i think it's possible when this mapping is static and deterministic e.g. with hashing, explain that if i'm right and/or give other cases when it's possible and preferred, also give examples of systems).
* Our system implements some smart leaderless protocol (todo not sure if it's the right term but explain briefly and give examples). So clients can have a list of all replica IPs to contact any random one, and  the routing logic is handled by replicas. That's possible for reads, and sometimes for writes (todo give examples, including "hints" if appropriate shards)


### Disproportional load and dysfunctional instances

(todo explain when disproportional load is possible and how to mitigate that in line with above paragraphs)
(todo explain how to deal with dysfunctional instances in line with above paragraphs)

## Replication meets Sharding

Replication and sharding are orthogonal concepts but they can complement each other. In this section let's discuss how to combine them to deliver best qualities from both approaches (e.g. fault tolerance from replication and load distribution from sharding [double check this and add more examples if there's anything compelling, feel free to put in bulletpoints]).

(todo a good example is mongodb, explain it , and maybe give other examples)
(todo write about tradeoffs and provide other useful analysis of this setup)

