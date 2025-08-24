# Transaction Isolation Levels: A Systematic Approach

Transaction isolation levels represent one of the most fundamental concepts in database systems, appearing in virtually every database and architecture resource. However, superficial memorization of isolation level tables without understanding underlying mechanisms can lead to production issues in concurrent systems.

## Building Understanding from Fundamentals

This analysis takes a ground-up approach to understanding transaction isolation. Rather than memorizing isolation levels and their properties, this systematic method examines how transactions operate in modern RDBMSs, explores the resulting concurrency anomalies, and derives the guarantees provided by each isolation level.

This approach proves effective because understanding the underlying causes of each anomaly naturally reveals why specific isolation levels prevent certain problems. Comprehensive understanding eliminates the need to memorize abstract comparison tables.

## The Central Tension: Serial Execution vs Performance

### Transaction Guarantees

Transactions provide ACID guarantees (Atomicity, Consistency, Isolation, Durability) for groups of database operations. In the context of isolation levels, the critical expectation is serial execution semantics: developers expect transactions to behave as if they execute sequentially, without interference from concurrent transactions.

True serial execution would enforce strict ordering: no transaction overlap would be permitted, with each transaction completing entirely before the next begins.

### The Reality: Performance Demands Compromise

While some databases implement true SERIALIZABLE isolation (PostgreSQL, SQL Server, CockroachDB), others compromise by implementing weaker guarantees under the same name (Oracle uses Snapshot Isolation rather than true Serializability). Serial execution proves too restrictive for performance requirements, particularly with long-running transactions.

Modern databases enable parallel transaction execution to achieve acceptable performance, accepting occasional consistency anomalies as a trade-off. This performance-correctness tension creates the isolation level spectrum, where each level represents a specific balance between consistency guarantees and execution efficiency.

## Quick Reference: Isolation Levels and Anomaly Prevention

Before we dive into each level, here's a reference table you can refer back to as we go through the details:

| Isolation Level  | Dirty Read | Non-repeatable Read | Phantom Read | Lost Update* | Write Skew |
| ---------------- | ---------- | ------------------- | ------------ | ------------ | ---------- |
| Read Uncommitted | ❌          | ❌                   | ❌            | ❌            | ❌          |
| Read Committed   | ✅          | ❌                   | ❌            | ❌            | ❌          |
| Repeatable Read  | ✅          | ✅                   | ❌**          | varies***    | ❌          |
| Serializable     | ✅          | ✅                   | ✅****        | ✅****        | ✅****      |

\* Lost Update prevention varies by database implementation  
\** Some databases like PostgreSQL prevent phantom reads even at Repeatable Read  
\*** PostgreSQL allows Lost Updates at Repeatable Read, MySQL prevents them  
\**** Oracle's "SERIALIZABLE" doesn't prevent Write Skew; some NoSQL databases don't offer true SERIALIZABLE at all

## The Progressive Journey Through Isolation Levels

### Read Uncommitted: Maximum Speed, Minimum Safety

**The Goal:** Get maximum performance by ditching any isolation guarantees.

**The Solution:** Obviously, if we ditch any isolation, then we'll have zero transaction overhead. Transactions will always see any changes made by other transactions regardless if they were committed or rolled back, and the order of seeing values is not guaranteed.

**The Trade-off:** **Dirty Reads** - reading data that might be rolled back. This means you might base business decisions on data that never actually existed in a committed state.

**Real Example:** In reality, there are many use cases where it's acceptable: for example, some metrics that are expected to be approximate or fluid, such as likes count in social networks, or real time visitor count, etc.

**Implementation Notes:** Not all DBs even support this; PostgreSQL officially supports it but treats it the same as Read Committed in practice.

### Read Committed: Hide Uncommitted Changes

**The Goal:** Solve the dirty read problem while maintaining good performance.

**The Solution:** Hide any changes made by a transaction before it's committed. This avoids Dirty Reads, i.e. changes that potentially might be rolled back are not visible to other transactions until these changes are committed.

There are two ways to implement this guarantee:
* Historically (like in older versions of PostgreSQL or some current configurations of MySQL/MariaDB) it was achieved by putting and releasing read and write locks on rows. Write locks are put on rows for the duration of the transaction, and read locks are put only for the duration of a read operation (to ensure it locks if a write lock is in place)
* Most modern systems use MVCC (multi version concurrency control). Each transaction starts with the snapshot of the database as of its start time, but for each operation the snapshot is refreshed: it uses the snapshot from the latest committed transaction.

**The Trade-off:** **Non-repeatable Reads** - the same query can return different values within a single transaction.

**Example:** Hotel booking scenario: Transaction A reads room_price = $100 and displays this to the customer. During form completion, Transaction B updates the price to $150 and commits. When Transaction A completes the booking, it reads the updated price of $150. The customer receives a charge of $150 for a room quoted at $100, creating a business logic violation.

**Implementation Notes:** This is way better than Read Uncommitted, and in fact, it's the default isolation level in PostgreSQL. There are many use cases where Dirty Reads mentioned above are not acceptable but Non-repeatable Reads are OK. For example, in e-commerce we would want customers to see only products that were committed, or we don't want to send an email to an address that is being changed by another transaction but might still be rolled back.

### Repeatable Read: Consistent Snapshots Within Transactions

**The Goal:** Ensure row values would return the same value regardless of what other transactions might be committing at the same time.

**The Solution:** In that case, the problem of non-repeatable reads is mitigated because for the whole duration of the transaction, the same value of room price would be used. Quite logically, such isolation level is called **Repeatable Read**.

Again, it can be implemented in two ways:
* again, the legacy way is using locks: putting read or write locks for the duration of the transaction. This ensures that if a value is being modified, then it will be seen by other transactions only when it commits/rolls back.
* using MVCC: transactions maintain the same snapshot during the whole transaction, but they stay fixed and don't update it for every operation like in Read Committed.

**The Trade-offs:** While Repeatable Read prevents dirty reads and non-repeatable reads, it still allows several anomalies:

**Lost Updates:** An interesting note is that PostgreSQL uses pure MVCC for this isolation level, while MySQL uses a combination of MVCC and locks. That's why PostgreSQL allows **Lost Updates** (thus violating the standard), but MySQL doesn't. That's one example where the line between transaction isolation levels gets blurry and implementations differ from the standard.

**Lost Update Example:** Two concurrent transactions read a shared bank account balance of $1000. Transaction A calculates a deposit: $1000 + $200 = $1200. Transaction B performs the same calculation: $1000 + $200 = $1200. The last committed transaction overwrites the first, resulting in a final balance of $1200 instead of the correct $1400. One deposit is effectively lost.

Note: that wouldn't happen if the account is updated in one statement because all operations are atomic in most databases (e.g. `UPDATE accounts SET balance = balance + 200 WHERE id = 1;`), but if balance is read and then updated in two operations then it would be an issue.

**Phantom Reads:** This problem is related to range queries. If we run a query like `SELECT * FROM accounts WHERE balance > 0` multiple times during the transaction, there's neither locks nor MVCC that could help us get the same result because rows satisfying that criteria can be added or deleted by other transactions.

**Write Skew:** This occurs when two transactions read overlapping data sets, make decisions based on what they read, and then write to disjoint data sets, but the writes violate a constraint that should be maintained across both sets.

**Write Skew Example:** An on-call scheduling system requires at least one doctor on call at all times. Two concurrent transactions each read the current state (2 doctors on call). Based on this information, each transaction allows its respective doctor to go off-call. The result: 0 doctors remain on call, violating the business constraint.

**Implementation Notes:** So the solution here is to use locks (with something like `SELECT FOR UPDATE` to mitigate Lost Update, or lock on another special lock table or use advisory locks to mitigate **Phantom Reads** and **Write Skew**). Alternatively, we can use the strictest isolation level we'll review below.

### Serializable: The Ultimate Solution

**The Goal:** Ensure transactions execute as if they were run one after another in some serial order.

**The Solution:** As discussed above, the ultimate solution to all these anomalies is to ensure transactions execute as if they were run one after another in some serial order. This is what **Serializable** isolation promises - it prevents all anomalies including phantom reads, write skew, and any other consistency violations that could arise from concurrent execution.

But here's where things get interesting and potentially confusing: not all databases that offer a "SERIALIZABLE" isolation level actually provide true serializable isolation.

**True Serializable Implementations:**

Modern databases implement serializable isolation in clever ways that avoid the performance penalty of actual serial execution:

- **PostgreSQL** (9.1+) uses Serializable Snapshot Isolation (SSI), an optimistic approach that allows transactions to proceed without blocking, but tracks dependencies between transactions. If it detects a pattern that could lead to a serialization anomaly, it aborts one of the transactions. This is remarkably efficient - often only 10-30% slower than Read Committed for typical workloads.
- **SQL Server** and **MySQL InnoDB** take a more traditional approach using range locks and next-key locks respectively. When you run `SELECT * FROM accounts WHERE balance > 1000`, they lock not just existing rows but also the "gaps" between rows to prevent phantoms. This works but can cause significant blocking.
- **CockroachDB** and **FoundationDB** were designed from the ground up with serializable as their primary isolation level, using distributed versions of optimistic concurrency control.

**The Oracle Exception:**

**Critical Implementation Note:** Oracle's SERIALIZABLE isolation level does not provide true serializable guarantees. It implements snapshot isolation, which prevents most anomalies but remains vulnerable to Write Skew scenarios. This implementation variance highlights the importance of understanding database-specific isolation level implementations.

**The Trade-offs:**

##### Serializable makes sense when:

- You have complex business invariants spanning multiple rows (like the on-call doctors example)
- Correctness is more important than performance
- You want to simplify reasoning about concurrent behavior

##### However, it comes with costs:

- Reduced throughput (varies by implementation)
- Increased transaction aborts requiring retry logic
- Potential for false positives where transactions are aborted unnecessarily

## Practical Framework for Understanding Isolation Levels

A systematic mental framework for analyzing isolation levels and their trade-offs:

### Start with the Problems, Not the Levels

1. **Dirty Read**: Reading data that might be rolled back
2. **Non-repeatable Read**: Same query returns different values within a transaction
3. **Phantom Read**: Range queries return different row sets within a transaction
4. **Lost Update**: Concurrent modifications overwrite each other
5. **Write Skew**: Transactions violate constraints when writing to disjoint data sets

### Then Map Problems to Solutions

- **Read Uncommitted**: Allows all problems (use only for approximate data)
- **Read Committed**: Prevents dirty reads (good default for most applications)
- **Repeatable Read**: Prevents dirty + non-repeatable reads (good for reports, calculations)
- **Serializable**: Prevents all problems (use for critical business logic)

### Practical Decision Framework

1. **Start with Read Committed** - it's the sweet spot for most applications
2. **Upgrade to Repeatable Read** when you need consistent calculations within a transaction
3. **Use Serializable** only when business logic requires it and you can handle retries
4. **Never use Read Uncommitted** unless you specifically need dirty reads for performance

### Memory Aids

- Remember the hotel booking example for non-repeatable reads
- Remember the bank account example for lost updates
- Remember the doctor on-call example for write skew
- Think "more isolation = fewer anomalies = slower performance"

**Critical Consideration:** Database-specific implementation details often supersede theoretical standards. PostgreSQL's Repeatable Read permits lost updates while MySQL's implementation prevents them. Oracle's "Serializable" lacks true serializability. These implementation variations have significant production implications beyond theoretical specifications.