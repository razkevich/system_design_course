# ACID vs BASE: Beyond the Database Buzzwords

ACID and BASE are two acronyms that offer a convenient but somewhat reductionist categorization of systems (e.g., databases) and their guarantees. They **reflect** broader **design philosophies** governing how systems handle **consistency, availability, and reliability**.

Why would I write about such a seemingly simple topic? The problem I want to tackle here is the common superficial usage of these terms, which stems from a lack of understanding of distributed systems fundamentals. Instead of using these as buzzwords, I invite you to join me in analyzing the underlying ideas, patterns, and problems that underpin this dichotomy.

- Is it true that ACID databases don't scale well?
- What's the difference between eventual consistency and weak consistency?
- Can we have ACID transactions in NoSQL DBs? Can RDBMSs expose relaxed (BASE) consistency properties?

If these questions make you scratch your head, let's dive into the topic!

## What Are ACID and BASE?

**ACID** is fundamentally about transactions in the database. It was coined in 1983 in an effort to define the terminology for fault-tolerance mechanisms. It stands for:

- **Atomic** – All transactions are all-or-nothing (either fully complete or fully fail—no partial updates).
- **Consistent** – The database guarantees that transactions preserve **all defined invariants**—both explicit (schema constraints) and implicit (application logic). The database enforces explicit rules automatically; implicit rules require careful transaction design.
- **Isolation** – Transactions run as if they're sequential, even when parallel. Levels (e.g., Read Committed, Serializable) tune trade-offs between correctness and performance.
- **Durable** – Committed data is permanently stored (even after power loss).

Systems that do not meet these criteria are referred to as _BASE_: _Basically Available_, _Soft state_, and _Eventual consistency_.

- **B**asically **A**vailable – The system remains operational most of the time. While some parts might fail, the overall system continues to function and serve requests.
- **S**oft state – The state of the system may change over time, even without new input. This happens because of eventual consistency—data might be in flux as it propagates across nodes.
- **E**ventual consistency – The system will become consistent over time, but it doesn't guarantee immediate consistency across all nodes. All nodes will eventually converge to the same state, but there may be temporary inconsistencies.

**BASE systems may relax any ACID property:**

- **Atomicity** → Best-effort operations (e.g., "write these 10 records, get 8 successes")
- **Consistency** → Temporary invariant violations (e.g., sum of balances might briefly be wrong)
- **Isolation** → Concurrent operations may interfere
- **Durability** → Accepted data loss for performance (e.g., in-memory caches)

## Breaking the ACID = RDBMS Myth

Here's where many get it wrong: **ACID is not exclusive to relational databases, and RDBMSs aren't always strictly ACID**.

### NoSQL Can Be ACID Too

Several modern NoSQL databases provide ACID guarantees:

- **MongoDB** (4.0+) supports multi-document ACID transactions
- **CockroachDB** and **YugabyteDB** offer distributed SQL with full ACID compliance
- **Neo4j** (graph database) provides ACID transactions for graph operations

### When RDBMS Goes BASE

Traditional relational databases can exhibit BASE properties when configured for scale:

- **PostgreSQL / MySQL with read replicas and async replication**: Replicas can lag behind the primary, providing eventual consistency for read operations
- **Sharded RDBMS**: Cross-shard transactions often sacrifice strict consistency for performance
- **Read-heavy optimizations**: Many RDBMS deployments use caching layers (Redis, Memcached) that serve stale data

## Why BASE Emerged: The Scalability Wall

ACID sounds like a great deal, so why did the industry care to coin the new term BASE? The answer is that as data volume and velocity grow, single-node RDBs start to experience performance problems and at some point fail to cope with the load:

- Performance issues often emerge when database sizes exceed 100 GB to 1 TB
- RDBs typically handle 1,000–10,000 RPS efficiently on moderate hardware; beyond 10,000 RPS, performance degradation is common
- Tables with 10–100 million rows often start showing performance issues
- Most RDBs handle 100–1,000 concurrent connections effectively
- Vertical scaling costs explode: for example, going from 32 cores to 64 cores might double the costs (to around $10,000 per month) but only provide 1.4x performance

That's the point where engineers will have to consider database alternatives to traditional RDBs that support horizontal scalability, which often go under the umbrella of BASE.

## BASE: A Pragmatic Philosophy

BASE is not a strict standard; some argue it's more of a marketing buzzword. As Martin Kleppmann half-jokingly claimed, the best definition of BASE is that it's not ACID. BASE emerged around 2008 as a catchy counterpoint to ACID, primarily from the experiences of companies like Amazon and eBay who were hitting the limits of traditional relational databases.

What BASE really describes is this: when you have a system distributed across multiple machines (perhaps across datacenters), the CAP theorem tells us you cannot have both perfect availability and perfect consistency during network partitions. So these systems choose availability—they'd rather give you a slightly stale answer than no answer at all.

The real insight is that many applications don't actually need strict consistency. Your Twitter timeline being 2 seconds out of date? Fine. Your shopping cart having slight inconsistencies that resolve in 100ms? Usually acceptable. Your bank balance? Perhaps we want stronger guarantees there.

So BASE isn't really a consistency model—it's more of a design philosophy that says: "Let's be pragmatic about consistency requirements and optimize for availability and partition tolerance instead."

## The Distributed Consistency Spectrum: It's Not Binary

> When database folks say 'consistency,' they might mean two different things. ACID's 'C' is about maintaining invariants—your account balance never goes negative. Distributed consistency is about when changes propagate across nodes - that's what we consider here.

Rather than viewing ACID and BASE representing two opposites: strong consistency and eventual consistency, we need to admit that this notion is more like a spectrum rather then a binary category.

### 1. Distributed Consistency Models

**Strong Consistency** ← → **Eventual Consistency**

- **Linearizability**: Makes a distributed system appear as though there's only a single copy of the data, and all operations happen atomically at a single point in time. Once a client completes a write, all clients reading from the database must be able to see the value just written. It's a _recency guarantee_ combined with atomic ordering.
- **Sequential Consistency**: All nodes see operations in the same order, and operations from each individual process appear in the order they were issued. However, there's no real-time constraint—nodes might see operations with significant delays, as long as the ordering is preserved.
- **Causal Consistency**: If operation A _happens-before_ operation B (A causally influences B), then every node that sees B must have previously seen A. Operations that are not causally related are concurrent and may be seen in different orders by different nodes. Captures the notion that causes come before effects.
- **Eventual Consistency**: If no new updates are made to a data item, eventually all accesses to that item will return the last updated value. Extremely weak—doesn't say when convergence will happen or what values you might read in the meantime. May return any value that was ever written.

Modern distributed databases increasingly offer tunable consistency—letting you choose consistency levels per operation. Amazon DynamoDB lets you request strongly consistent reads when needed. This flexibility represents the future: not ACID vs BASE, but ACID when you need it, BASE when you don't. Or Google Spanner - it provides global consistency with reasonable performance.

## Choosing Your Consistency Model

The choice between ACID and BASE depends on the use case:

**Choose stronger consistency when:**

- Financial transactions and payments
- Inventory management with limited stock
- User authentication and authorization
- Any scenario where inconsistency = business risk

**Choose weaker consistency when:**

- Social media feeds and timelines
- Product recommendations
- Analytics and reporting
- Content delivery
- Any scenario where slight staleness is acceptable

## Conclusion

The key takeaway? ACID and BASE aren't about database types—they're about trade-offs. Understanding these trade-offs, rather than treating them as buzzwords, is what enables us to build systems that balance consistency, availability, and scalability for our specific needs.