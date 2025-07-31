Distributed locks allow multiple processes to coordinate access to shared resources by ensuring mutual exclusion (only one holder at a time). They are essential for consistency and coordination in distributed systems. For example, locks prevent two services from writing the same database row simultaneously or ensure only one node becomes leader. However, building locks across machines is difficult: nodes can fail or be partitioned without warning, message delays and unsynchronized clocks make ordering uncertain, and algorithms must handle asynchrony and partial failures. This guide surveys why distributed coordination is hard, common lock pitfalls, and major locking solutions.

# The Challenge of Distributed Coordination

Distributed systems confront inherent uncertainties. **Partial failures** mean a node or network link may crash while others keep running, making it hard to know if a lock holder is alive. **Clock skew and asynchrony** further complicate things: without a global clock, machines cannot reliably timestamp events or determine the order of operations. **Network partitions** and variable latencies can isolate nodes or delay messages arbitrarily. In such environments, achieving consensus or strict ordering is fundamentally impossible without trade-offs. In practice, we must design locks that tolerate crashes and delays: for example, using timeouts or leases to drop failed holders, and avoiding any reliance on perfectly synchronized clocks.

# Common Pitfalls in Distributed Locking

Here are some examples of naive and incorrect lock implementations for distributed systems:

- **Local locks** — The most naive mistake is to acquire the lock locally (e.g. via a OS-level file locking or thread synchonization primitives). Many junior engineers fail to pay attention to the distributed nature of the services, for example, if we have multiple replicas of the service, other replicas won’t be advised about the local lock.
- **Single point of failure lock server** — Implementing a single centralized lock server without replication or failover. When the server crashes, all locks become inaccessible and the entire system halts.
- **No expiration/TTL on locks** — Allowing locks to be held indefinitely without timeouts. If a client crashes while holding a lock, it remains locked forever, causing deadlock.
- **Simple timestamp ordering** — Using wall clock time for lock ordering without considering clock skew between machines. While some use cases might tolerate that, it is not acceptable for critical ones (like ones involving financial transactions).
- **No fencing tokens** — Failing to use monotonically increasing tokens to prevent delayed operations from old lock holders from being applied after a new holder acquires the lock. Again, it might be acceptable in some scenarios.
- **Non-atomic check-and-set** — Implementing lock acquisition as separate “check if available” and “acquire” operations instead of an atomic compare-and-swap, creating race conditions.
- **Forgetting about GC pauses and network delays** — Not accounting for long garbage collection pauses and network delays that might cause a lock holder to appear dead when it’s actually just paused, leading to two active lock holders.

By being aware of these pitfalls, we can use safer patterns that we explore below.

# Correct and Safe Implementation Approaches

Several tools and algorithms implement distributed locks, each with different guarantees. Below we examine common ones.

# RDBMS Locks

**SQL row-level locking:** Many relational databases (e.g. PostgreSQL) support row/table locks. A common trick is to create a special “lock” table and do e.g. `INSERT ... ON CONFLICT DO NOTHING` followed by `SELECT ... FOR UPDATE` within a transaction. The `SELECT FOR UPDATE` blocks other transactions on that row. This leverages the database’s own transactional locks, though it only works within the scope of that one database and incurs SQL overhead.

Another way is **advisory locks** that RDBMSs such as PostgreSQL or MySQL offer as a lightweight coordination mechanism. These are not tied to specific rows — instead they are user-defined integer keys. In PostgreSQL, a session can call `pg_advisory_lock(key)` to acquire the lock, and `pg_advisory_unlock(key)` to release it. We can also set a timeouts for them. There are session-level and transaction-level advisory locks. A **session-level** lock is held until explicitly released or until the session ends. For example, once a client does `SELECT pg_advisory_lock(42);`, no other session can acquire that same key until the first does `pg_advisory_unlock` or disconnects.

Advisory locks are _application-controlled_: PostgreSQL does not enforce any meaning, it simply ensures mutual exclusion on the key. They are fast (in shared memory) and automatically cleaned up at session end. Limitations include: all clients must use the same database cluster (no cross-database or cross-language unless all connect to the same DB), and there is no fencing token — a lock’s release does not produce a token that clients can use to detect staleness. If a session holding the lock crashes, the lock is released on disconnect, but a newly acquiring session has no easy way to know how long to consider the lock safe. Advisory locks are best when all parties use PostgreSQL and need a simple mutex (e.g. guarding a scheduled job), but not for very high-performance scenarios or cases requiring inter-data-center coordination.

# Redis Simple Lock

Redis supports atomic commands that make a basic lock straightforward. The canonical approach is to use:

`SET resource_name my_random_value NX PX 30000`

This command creates the key only if it doesn’t exist (`NX`) and sets a 30-second TTL (`PX 30000`). The `my_random_value` is a unique token chosen by the client. If the `SET` returns “OK”, the lock is held; otherwise, another client has it.

Because `SET NX PX` is atomic, it safely sets the key and expiration in one step. To release the lock, the client must ensure it is still the owner: it uses a Lua script that checks the value and deletes only if it matches. For example:

`if redis.call("get",KEYS[1]) == ARGV[1] then return redis.call("del",KEYS[1]) else return 0 end`

This script deletes the key only if its value equals `my_random_value`, preventing one client from deleting another’s lock.

**Pros:** Very fast and simple to implement. The lock automatically expires if the client crashes (after the TTL).  
**Cons:** This is a single-instance lock (a single Redis node). If that Redis instance fails or partitions, safety breaks (Redis replication is asynchronous, so a failover can lead to two masters both thinking they hold the lock). There is no fencing token or ordering — if a client pauses past the TTL it may continue to think it holds the lock. In short, this works for relatively trusted networks and transient locking needs, but it is a single point of failure and provides no extra safety beyond the timeout.

# Redlock

Redlock is Redis’s multi-master locking algorithm proposed by Salvatore Sanfilippo, the creator of Redis. It assumes _N_ independent Redis nodes (typically 5). To acquire the lock, the client attempts to set the lock key (with the same `my_random_value`) in each Redis master with `SET NX PX`, timing these operations. The client records how long this took. If it successfully sets the lock in a _majority_ of nodes (e.g. 3 out of 5) **and** the total time is still less than the TTL, the lock is considered acquired. The effective validity is the original TTL minus the elapsed time. If it fails to get majority, it deletes any partial locks and retries later. Releasing is simply deleting the key (with the same Lua script) on each node.

**Assumptions:** Redlock has the same fundamental problem as the simple redis lock above: it relies on roughly synchronized clocks. It assumes that clock drift between clients and Redis is small relative to the TTL so that the validity window can be computed, as well as short network delays. It also assumes independent failures: it requires _majority_ nodes available. Liveness is sacrificed during partitions (you may have to wait for TTL expiry).

**Criticisms and Safety:** Martin Kleppmann and others have pointed out that Redlock does not produce fencing tokens — the random value does not guarantee monotonic order. In other words, if a client is paused or its lock expires, another client might take the lock with no way to prevent the first from later acting. Redlock’s safety relies on many timing assumptions, and in truly asynchronous conditions it can violate mutual exclusion. The official Redis documentation even links to critiques of Redlock (e.g. Martin’s analysis).

**When to use:** Redlock may be acceptable if you need a highly available lock and can tolerate rare safety anomalies (e.g. if eventual consistency is okay). It is _not_ recommended for correctness-critical locks unless you can enforce the needed assumptions (tight clock sync, low network jitter).

# ZooKeeper Lock

Apache ZooKeeper is a coordination service with a filesystem-like namespace of znodes. A **znode** is ZooKeeper’s basic data unit — a node in a hierarchical tree structure that can store small amounts of data and offers atomic operations. ZooKeeper offers a recipe for locks using **ephemeral sequential nodes**. It’s a special znode that automatically gets deleted when its creator disconnects and has a unique increasing number appended to its name, making it perfect for implementing distributed locks.

Clients agree on a lock path (e.g. `/locks/mylock`). To acquire the lock, a client creates a child znode with both EPHEMERAL and SEQUENTIAL flags under that path – for example, `/locks/mylock/lock-0000000003`. Because of the sequential flag, each new node gets a monotonically increasing suffix.

After creating its znode, the client lists all children of `/locks/mylock` and checks if its node has the lowest sequence number. If it is the lowest, it has acquired the lock. If not, it identifies the next-lowest node (the immediate predecessor) and sets a watch on that node. When that predecessor znode is deleted (upon that holder releasing the lock or crashing), ZooKeeper notifies this client, which then repeats the check and obtains the lock. To release the lock, the client simply deletes its znode (or it is auto-deleted when the session ends).

This mechanism ensures **fairness** and avoids the thundering herd: each waiting client only wakes up when the one immediately before it releases the lock. Only one client is notified per release, and there is no polling or global notification. Because znodes are ephemeral, a crashed client’s lock is automatically cleaned up by ZooKeeper. The result is a strongly ordered, self-cleaning lock. The main drawback is the need to run and maintain a ZooKeeper ensemble.

# etcd Lock

etcd is a Raft-based key-value store with built-in concurrency primitives. It offers a `Lock` API which under the hood uses a **lease** (TTL) and a compare-and-swap. A typical usage is: first grant a lease with a TTL, then do a transaction to create a lock key only if it doesn’t exist. For example (in Go):

`// Pseudocode for etcd lock acquire Lease lease = etcd.leaseGrant(ctx, 10); // 10-second TTL TxnResponse txn = etcd.txn(ctx) .If(etcd.compare(CreateRevision(key), "=", 0)) .Then(etcd.put(key, "locked", WithLease(lease.ID))) .Commit(); // If txn.succeeded, we have the lock on key.`

This atomically creates the key under the lease if it did not exist. The lock is held until `Unlock` is called or the lease expires (auto-releasing the key). The transaction ensures only one client can create the key at a time.

Because etcd uses Raft consensus, its locks are **linearizable** (with a majority of nodes). etcd also automatically provides a monotonic **fencing token**: the creation revision number of the lock key serves as a globally-ordered token. In practice, when a client acquires the lock, it can read the key’s revision and use it when accessing the protected resource. The resource checks this token and rejects any operation with an older token, preventing stale-lock interference (more on fencing below). Overall, etcd’s locks are robust (surviving crashes as long as quorum remains) and integrate well with its transactions, though using them for strict mutual exclusion requires care (see Fencing below).

# Fencing Tokens: Ensuring Correctness

A **fencing token** is a strictly increasing stamp given out on each lock acquisition. It prevents a stale lock-holder from making changes after losing the lock. The idea is illustrated below.

Each time a client acquires the lock, it receives a new token (e.g. 1, then 2, etc.). The client must include this token in any operation on the protected resource. The resource keeps track of the highest token it has seen. If it later receives an operation bearing a lower token (indicating an old lock-holder), it rejects it. Pseudocode on the resource side might be:

`long lastToken = 0; void accessResource(long fencingToken, Data data) { if (fencingToken <= lastToken) { throw new IllegalStateException("Stale lock holder"); } // perform operation with data... lastToken = fencingToken; }`

This ensures **sequential execution** of lock holders’ effects: once a higher token is used, any old token (< last) is stale and dropped.

Fencing tokens are critical whenever locks have timeouts. For example, if a lock expires while a client is paused (e.g. GC pause), another client may acquire the lock. Without fencing, when the first client resumes it may unknowingly continue and corrupt shared state. By contrast, with tokens the resource will reject the first client’s actions (older token) in favor of the new holder. etcd naturally provides fencing tokens via its revision numbers: the creation revision of the lock key increases on each acquire. As Jepsen’s analysis recommends, clients should use this revision as a token and ensure the resource rejects any operation with a lower revision. ZooKeeper similarly offers the znode’s `zxid` or version number as a fencing token. In practice, any system using TTL-based locks should incorporate fencing tokens to avoid stale updates.

# Other Methods

Beyond the above, many systems offer locking primitives:

- **DynamoDB conditional writes:** You can implement locks by using a DynamoDB item as a lock and performing a conditional `PutItem` (or `UpdateItem`) only when an attribute (e.g. a version number) meets a condition. DynamoDB’s “Optimistic Locking” uses a version attribute and a conditional write: if the version matches, the write succeeds; otherwise it fails (throwing `ConditionalCheckFailedException`). In effect, this can serialize access. AWS even provides a client-side DynamoDB Lock Library that uses this pattern plus TTL attributes.
- **Consul sessions:** HashiCorp Consul supports distributed locks via its KV store and _sessions_. A client creates a session (with TTL and optional health checks) and does a KV PUT with the session (an “Acquire” operation). The lock is tied to the session’s liveness. Consul’s KV API maintains a **LockIndex** that increments on every acquire. One can think of `(Key, LockIndex, SessionID)` as a sequencer: on each new acquire, `LockIndex` goes up. Consul releases or deletes keys when sessions expire. In this way, Consul provides both an expiry mechanism (via TTL or health checks) and a token (`LockIndex`) to detect stale holders.
- **Hazelcast/Infinispan:** These Java in-memory data grids include distributed lock data structures. For example, Hazelcast’s _FencedLock_ (in its CP subsystem) yields a monotonic fencing token on each lock acquisition. This token can be sent to external resources similarly to etcd’s revision, ensuring old holders cannot interfere. (Hazelcast’s regular `IMap.lock()` also provides locking, but without fence tokens.)
- **Firestore/Cloud Spanner transactions:** Cloud Firestore (the server SDK) and Google Cloud Spanner support strong, serializable transactions. In Firestore server-side libraries, a transaction **locks** documents on reads: other writes to those docs wait until commit. Cloud Spanner uses shared/exclusive locks at the cell (row+column) level for read-write transactions. One can treat a small transaction (e.g. writing a “lock” row) as a mutex. These guarantees come from the database’s implementation, not a separate lock service.

Each mechanism has trade-offs in consistency, performance, and complexity. The choice depends on the system’s scale and required guarantees.

# Conclusion

Distributed locking is powerful but complex. **Match lock type to guarantees**: use consensus-backed tools (ZooKeeper, etcd, Hazelcast CP) when you need strict safety, and simpler locks (Redis, advisory locks) when you can tolerate relaxed semantics. **Use fencing tokens** whenever locks expire, so stale clients cannot corrupt state. Always incorporate **timeouts and TTLs** on locks and retries, and plan for failures (e.g. auto-release on crash, cleanup of orphaned locks). Consider lock granularity and **reentrancy** as needed. Design for the worst (net splits, slow clocks) and remember that if a lock will break your system on failure, you may need to re-think the design. Wherever possible, prefer idempotent operations or higher-level coordination (leader election, sequencers) to reduce reliance on distributed mutexes.