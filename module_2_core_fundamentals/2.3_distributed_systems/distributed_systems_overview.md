After consuming numerous books, videos, courses and solving real production problems all related to distributed systems, I think I've come to a conclusion how to better present the fundamental ideas of distributed computing, so that it clicks in one's mind and starts to make sense. What we want is to have a mental model of these ideas that can be applied to various problems, from choosing the right DB for a problem at hand, to distributed caches, designing rate limiting system or anything that seem unrelated, but in fact rely on the same fundamental principles and ideas from the perspective of designing these components for reliability, scalability and availability.

So below we'll progress from a system that has no replication or sharding whatsoever where all data and processing happens inside a single instance. We'll modify it by adding replication, more instances to handle writes and sharding - to see what we get from different perspectives, what are the tradeoffs and what systems actually implement those configurations.

## Single instance system

![[distributed_systems_overview_1.png]]

This represents the simplest setup where everything happens within a single node. While it offers no horizontal scalability, it provides strong consistency guarantees and simple reasoning about the system state. Examples include single-instance PostgreSQL, Redis without clustering, or standalone application servers. The only way to handle increased load is through vertical scaling (adding more CPU, memory, or storage to the same machine), which has physical and cost limitations. Eventually, you'll hit hardware constraints that make further scaling impossible or economically unfeasible.
## Replication with Single Leader

![[distributed_systems_overview_2.png]]

The simplest form of introducing scaling to such system is adding more follower replicas. These replicas can be either read replicas to serve clients their read requests, or just sit there as a hot standby so that it can replace the leader (which is also called master or write replica) in case it goes offline or breaks. All replicas have access to the complete set of data (in databases, usually the data is fully replicated), so there's no need to introduce any traffic routing or sharding strategies (besides routing writes to the leader always).

In both cases, the leader has to replicate its data to those replicas, and there are various approaches to do that (e.g. in databases - send the write ahead log, WAL, or logical commands). But we still have only one leader to handle requests that mutate data or state. 

So, the clients should only connect to the leader to perform write requests, but read requests can be served by any read replica. This mitigates the use cases with high read to write ratio, but doesn't help much when we have many writes. In fact, for some high write scenarios this might be not the best configuration because
* if we choose synchronous replication mode, then our system might become slow or even become unavailable in case it can't reach some read replicas
* if we choose asynchronous replication mode, then readers might see stale data if they go to read replicas, which might not be acceptable (e.g. think of using stale/inconsistent bank account data)

Another question is what happens if the leader dies. There are generally two approaches
* manual switch - the administrator has to come and set one of the read replicas as the new leader. Some traditional database setups still use this approach for critical systems where administrators want full control over failover decisions. The system becomes unavailable until the admin intervenes, but the benefit is that you avoid split-brain scenarios and ensure the most qualified replica becomes the new leader based on human judgment.
* automatic leader assignment - systems use a distributed consensus algorithm such as Paxos or Raft or others to elect a new leader. The benefit is faster recovery and reduced human intervention, but the downside is complexity and the potential for split-brain scenarios if the consensus algorithm fails or network partitions occur.

One prominent example that supports this approach is PostgreSQL with streaming replication. You can configure hot standby replicas and read replicas, choosing between synchronous and asynchronous replication modes. Other examples include MySQL with master-slave replication, MongoDB replica sets (before sharding), and Redis Sentinel for high availability.

Besides some limits to scalability that we discussed, there's actually one important benefit to this approach: natural linearizability. If all writes go through the same leader, it's easy to ensure global order, also it's easy to reason about it. 

## Replication with Multiple Leaders

![[distributed_systems_overview_3.png]]

Some situations, such as geo-distributed deployments, collaborative editing (your mobile device that can go offline for days and a server is also a distributed system!) or high availability requirements, require setting up multiple replicas, and assigning more then one of them as write replicas (i.e. leaders). So in other words, we have multiple instances that can accept writes simultaneously. 

In this setup, each leader acts as a follower to other leaders. Also, each leader typically manages its own set of followers. Leaders can have different topologies for propagating changes: all-to-all (every leader replicates to every other leader, used in small clusters), circular (changes flow in a ring, more bandwidth-efficient but higher latency), and star (one central leader coordinates with others, simpler but creates a bottleneck).

Unlike single-leader systems, multi-leader setups sacrifice the natural ordering of writes, making conflict resolution necessary. However, they inherit the benefits of read scaling from single-leader systems while adding write scaling capabilities. The trade-off is increased complexity in maintaining consistency across multiple write nodes.

### Resolving conflicts
if writes to one data point arrives to different replicas and they all try to replicate that change, we will get a conflict because we have two conflicting values for the same data point. There is a set of known approaches to resolving the conflicts: 
* LWW - last write wins - the most brutal one, it just takes the version it thinks is the latest. This approach is problematic because of clock skew between different machines - even with NTP synchronization, clocks can drift, leading to incorrect ordering decisions and potential data loss when the "wrong" write is considered more recent.
* Version vectors: Track causality between updates
* Application-specific resolution: Let application code handle conflicts
* CRDTs: Conflict-free replicated data types that merge automatically
#### Inferring global order

Multi-leader systems generally cannot provide linearizability reliably due to the fundamental challenge of establishing global ordering across concurrent writes to different leaders. Even with precise synchronized clocks, network delays and clock drift make it practically impossible to guarantee linearizable ordering. Some systems like Google's Spanner attempt this using atomic clocks and GPS for tight time synchronization, but this requires specialized hardware and comes with significant operational complexity.

Consistency guarantees depend on how replication between write->write and write->read replicas is configured. It can range from the fastest and most highly available one where everything is replicated asynchronously to highly consistent where we wait for all replicas to respond, and everything in between.

Read scaling benefits from single-leader systems apply here as well, since followers can still serve read requests. However, the complexity of conflict resolution and the loss of natural write ordering are unique challenges. Additionally, the replication lag between leaders can create temporary inconsistencies that readers might observe.

Multi-leader replication is preferred over leaderless when you need geographic distribution (each region has its own leader), when you have natural partitioning of writes (different leaders handle different types of data), or when you want more structured conflict resolution than what leaderless systems typically provide.
## Leaderless replication

![[distributed_systems_overview_4.png.png]]

Leaderless replication is a configuration where each replica can serve serve both read and write requests, so it's actually multi leader replication taken to extreme (each replica is a leader).

Leaderless systems eliminate the single point of failure that leaders represent, but they require more sophisticated client logic to handle quorum reads and writes. They inherit the conflict resolution challenges from multi-leader systems but handle them differently through techniques like read repair and anti-entropy processes. Unlike leader-based systems, there's no special role for any node, making the system more symmetric and potentially simpler to operate.

### Quorum consistency

One important fact is that Leaderless replication, unlike Multi leader replication, takes ownership of Consistency by introducing Quorum Consistency. For example, if we have 3 replicas, we can wait for only 2 replicas to respond on reads, and 2 replicas to respond on writes, and that would give us consistency guarantees (because at least one read replica that we query has the latest value). 

Read repair is a technique to detect stale values (which are possible with quorums) and update them when reading from multiple nodes. Anti-entropy is a background process that compares replicas and fixes differences.

When dealing with node failures, leaderless systems employ two key techniques. Sloppy quorum allows writes to continue even when some target nodes are unavailable by temporarily writing to different accessible nodes. Hinted handoff ensures that when the original nodes recover, they receive the writes that were temporarily stored elsewhere, maintaining consistency without blocking operations during failures.

### Resolving conflicts

Conflict resolution in leaderless systems uses similar approaches to multi-leader systems (LWW, version vectors, CRDTs), but the resolution often happens during read operations rather than write operations. Since there's no leader to coordinate conflicts, clients or the system must detect and resolve conflicts when reading from multiple replicas, making read operations potentially more complex.

## Sharding

![[distributed_systems_overview_5.png.png]]

How do we scale our system if there's too much data that doesn't fit into one machine, or there's too much throughput (requests per second) for a single instance to handle? The approach is called sharding, where we distribute the load across multiple instances where each instance handles a configured subset of requests (and/or data). 
Sharding is orthogonal to replication - you can have sharded systems without replication (each shard is a single instance) or combine sharding with any replication strategy (each shard can be replicated using single-leader, multi-leader, or leaderless approaches).

But if we do that there's some questions that arise naturally:

* How do we split the data and/or load and how we add/remove shards? 
* How does the client know which shard should handle the request (e.g. because it owns the data)?
* What if one shard will get disproportional share of load?
* What if a shard becomes dysfunctional (e.g. gets disconnected)

Let's address all of these questions

### Splitting the data and/or load

There are several approaches how to split the load across instances. All of them start with the engineer choosing the key to map requests to instances, but the algorithms of actually mapping them vary:
* Specifying key ranges that map to instances (e.g., A-M goes to shard 1, N-Z goes to shard 2). This works well when keys are uniformly distributed but can create hotspots if certain ranges are accessed more frequently. Examples include HBase and some MongoDB configurations.
* Calculating key hash and mapping it to instances (e.g., hash(key) % num_shards). This provides good distribution but makes range queries impossible since related keys are scattered across shards. Adding or removing shards requires significant data movement. Examples include Redis Cluster and some Cassandra deployments.
* Directory-based sharding where a separate lookup service maps keys to shards. This provides flexibility in data placement and makes rebalancing easier, but introduces an additional component that can become a bottleneck. Examples include some distributed file systems and early versions of Google's Bigtable.
* Consistent hashing. For the sake of brevity we won't get deep into that but I just want to say that it's a well-known technique that assigns segments of key hashes to instances, and its extension called virtual nodes (or VNodes) ensures that adding/removing instances don't leave instances with disproportional load. The tradeoff is increased complexity in the hashing algorithm, but it provides excellent load distribution and minimal data movement during rebalancing. Examples include Amazon DynamoDB, Apache Cassandra, and Riak.
Adding or removing nodes varies by sharding strategy: range-based sharding requires splitting or merging ranges and moving data accordingly; hash-based sharding typically requires rehashing and moving a significant portion of data; consistent hashing minimizes data movement by only affecting adjacent nodes; while directory-based approaches can update mappings without immediate data movement, allowing for gradual rebalancing.
### Routing requests to their replicas

We can have some central component responsible for routing (we previously mentioned directory based sharding). So clients have to contact it to exchange the sharding key for the ID of the instance. Examples include:
• MongoDB's mongos router that directs queries to appropriate shards
• Citus extension for PostgreSQL that provides query routing
• Load balancers with sticky sessions that route based on session keys
• Kubernetes services that route to specific pods based on request attributes 

Such central component is not always needed, there's two options to map requests to instances without it:
* Clients can infer which instance they want to contact based on the key. This works when the sharding algorithm is deterministic and known to clients, such as with simple hash-based sharding or known range partitions. It's preferred when you want to minimize routing overhead and have smart clients. Examples include Redis Cluster clients and some Cassandra client libraries that implement the consistent hashing algorithm locally.
* Our system implements smart peer-to-peer coordination where clients can contact any node, and that node handles routing internally. Clients maintain a list of all node IPs and can contact any random one. The contacted node either serves the request (if it owns the data) or forwards it to the appropriate shard. This works well for reads and can work for writes through techniques like hinted handoff, where nodes temporarily store writes for unavailable shards. Examples include Cassandra's coordinator nodes and Riak's request coordination.


### Disproportional load and dysfunctional instances

Disproportional load occurs when certain shards receive significantly more requests than others, often due to hotspots in the data (celebrity users, popular content) or poorly chosen shard keys. Mitigation strategies include choosing better shard keys that distribute load evenly, using consistent hashing with virtual nodes to spread hotspots across multiple physical nodes, implementing application-level load balancing, or creating additional replicas for hot shards.
When dealing with dysfunctional instances, the approach depends on your replication strategy. In systems with replication, other replicas can take over the failed shard's responsibilities. Without replication, the affected data becomes unavailable until the instance recovers. Preventive measures include health checks, automatic failover to replica shards, and maintaining multiple replicas per shard. Some systems implement circuit breakers to detect failing instances quickly and route traffic away from them.

## Replication meets Sharding


Replication and sharding are orthogonal concepts but they can complement each other. In this section let's discuss how to combine them to deliver best qualities from both approaches:
• Fault tolerance from replication ensures data availability even when nodes fail
• Load distribution from sharding handles datasets larger than single machines
• Read scaling through replica distribution across shards
• Geographic distribution where each region has replicated shards

MongoDB exemplifies this combination well: it uses replica sets (typically 3 nodes with one primary and two secondaries) for each shard, providing both fault tolerance and load distribution. Queries are distributed across shards based on the shard key, while reads can be served by secondary replicas within each shard. 

Apache Kafka provides another excellent example: topics are divided into partitions (sharding) where each partition can have multiple replicas across different brokers (replication). One replica serves as the leader handling reads and writes, while followers provide fault tolerance. This design allows Kafka to scale horizontally by adding more partitions and maintain high availability through replication.

Other examples include Elasticsearch clusters (shards with replicas), Cassandra (consistent hashing with replication factor), and distributed SQL databases like CockroachDB.
The main tradeoffs of combining replication and sharding include increased operational complexity (managing both shard distribution and replica consistency), higher resource requirements (multiple copies of data across multiple shards), and more complex failure scenarios (you need to handle both shard failures and replica failures). However, the benefits often outweigh these costs for large-scale systems that need both high availability and horizontal scalability. The key is choosing the right replication factor and sharding strategy for your specific use case and operational capabilities.

## Conclusions

Understanding distributed systems fundamentally comes down to grasping the tradeoffs between consistency, availability, and partition tolerance - though we can extend this to include scalability and operational complexity. Each architecture pattern we've explored represents different points on these tradeoff curves:

**Single instance systems** offer the strongest consistency guarantees and simplest operations, but sacrifice scalability and availability. They're perfect for small-scale applications or when strong consistency is paramount.

**Single-leader replication** provides a sweet spot for read-heavy workloads, offering natural linearizability while adding read scalability and basic fault tolerance. The tradeoff is limited write scalability and potential single points of failure.

**Multi-leader replication** enables geographic distribution and write scalability but introduces the complexity of conflict resolution and gives up strong consistency guarantees. It's ideal when you need to handle writes across different regions or have naturally partitioned write patterns.

**Leaderless replication** maximizes availability and eliminates single points of failure through symmetric architecture, but requires sophisticated client logic and careful tuning of quorum parameters to balance consistency and performance.

**Sharding** becomes necessary when data or throughput exceeds single-machine capabilities, but introduces the complexity of data distribution, routing, and rebalancing. The choice of sharding strategy (range, hash, consistent hashing, or directory-based) depends on your access patterns and operational requirements.

**Combined replication and sharding** represents the architecture of most large-scale distributed systems, offering both horizontal scalability and fault tolerance at the cost of significant operational complexity.

The key insight is that there's no universally "best" approach - the right choice depends on your specific requirements for consistency, availability, scalability, and operational simplicity. Modern distributed systems often employ different patterns for different components: a strongly consistent metadata store might use single-leader replication, while user data might be sharded with leaderless replication for maximum availability.

By understanding these fundamental patterns and their tradeoffs, you can make informed architectural decisions and better reason about the behavior of complex distributed systems in production.

