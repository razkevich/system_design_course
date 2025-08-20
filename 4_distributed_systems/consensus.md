# Distributed Consensus: The Heart of Cloud-Native Systems

Distributed consensus is the fundamental mechanism that enables multiple servers to agree on shared state despite failures, network partitions, and timing uncertainties. It's the foundation for critical features in cloud-native systems: leader election, configuration management, distributed transactions, and replicated state machines.

## Setting the Foundation: Broadcast and Consensus

Understanding consensus requires first grasping the building blocks: broadcast primitives, synchrony models, and the core properties that consensus algorithms must guarantee. These are just conceptual ideas, not implementations; think of these as properties that we would expect from systems before we implement them.

### The Broadcast Spectrum

Distributed systems rely on different broadcast primitives, each providing increasingly stronger guarantees. 

**Best-effort broadcast** represents the simplest form—the sender attempts to deliver messages to all recipients without guarantees. If the sender fails mid-transmission, some nodes receive the message while others don't, potentially leaving the system in an inconsistent state.

**Reliable broadcast** ensures that if any correct node delivers a message, all correct nodes eventually deliver it. Even if the sender crashes after reaching a single node, the protocol ensures complete propagation through flooding or gossip mechanisms. This prevents partial delivery scenarios but doesn't guarantee ordering.

**Atomic broadcast** (total order broadcast) provides the strongest guarantees: all correct nodes deliver the same set of messages in identical order. This property is essential for maintaining consistency across replicas—without it, different replicas might apply operations in different sequences, leading to divergent states.

Atomic broadcast and distributed consensus are fundamentally equivalent: each can be implemented using the other. Atomic broadcast ensures all processes receive messages in the same order, while consensus ensures all processes agree on a value. In practice, consensus algorithms like Paxos and Raft are used to implement atomic broadcast for consistent state replication.
### Why Consensus Matters

Consensus algorithms solve critical coordination problems in distributed systems:

- **Leader election**: Ensuring a single active leader for cluster coordination
- **Replicated logs**: Maintaining consistent operation order across replicas
- **Configuration management**: Agreeing on cluster membership and configuration changes
- **Distributed locking**: Providing mutual exclusion across distributed processes
- **Transaction commit**: Coordinating distributed transaction outcomes

Without consensus, systems face split-brain scenarios where different components make conflicting decisions, leading to data inconsistency, duplicate processing, or service unavailability.

## The Big Three: ZAB, Paxos, and Raft

### ZAB (Zookeeper Atomic Broadcast)

ZooKeeper's Zab protocol provides atomic broadcast by ensuring that all updates are delivered reliably, in the same total order, and are durable once committed. This is achieved through a leader that assigns order to updates, quorum-based acknowledgments to ensure consistency, and recovery mechanisms to maintain correctness after failures (e.g. leader election when a leader fails).

ZAB powers Apache ZooKeeper, which provides coordination services for systems like (older versions of) Kafka, HBase, and Solr. The protocol ensures total message ordering across all replicas.

ZAB operates through epochs, with each epoch having a unique leader. The protocol guarantees that all messages from previous epochs are delivered before any messages from the current epoch, maintaining strict ordering even across leader changes.

The protocol consists of three phases:

1. **Discovery**: The prospective leader learns the latest epoch and transactions from other processes
2. **Synchronization**: The leader ensures followers have consistent history before accepting new operations
3. **Broadcast**: The leader processes client requests and replicates them to followers

![[zab.png]]
ZAB's key optimization is recovery efficiency. During synchronization, the new leader can recover state from the single most up-to-date follower rather than reconciling differences across multiple nodes. This design choice significantly reduces recovery time and complexity.

The protocol is particularly well-suited for coordination services where total order is critical and write throughput is moderate. ZooKeeper's implementation demonstrates ZAB's effectiveness in production environments, handling millions of coordination operations daily in large-scale deployments.

### Paxos: The Academic Heavyweight

Paxos, introduced by Leslie Lamport, established the theoretical foundation for consensus algorithms. Despite its complexity, Paxos remains influential, with variants deployed in systems like Google's Chubby, Azure Storage, and Amazon's DynamoDB. Basic Paxos (also called Single-Decree Paxos) ensures agreement on a single value among a set of nodes.

Basic Paxos operates in two phases:

1. **Prepare/Promise**: Proposers request promises from acceptors not to accept older proposals
2. **Accept/Accepted**: Proposers send values for acceptance once promises are secured

![[paxos.png]]
The algorithm guarantees safety under all conditions—no two different values can be chosen for the same instance. Liveness requires a majority of nodes to be responsive and eventually stable communication.

**Multi-Paxos**. In practical systems, such as replicated state machines, nodes often need to agree on a sequence of values (e.g., a log of commands). Running Basic Paxos for each value is inefficient due to repeated rounds of communication. Multi-Paxos optimizes this process by streamlining the consensus process for a sequence of values. It extends the basic algorithm by establishing a distinguished proposer (leader) that can skip the prepare phase for multiple consecutive instances, significantly reducing message complexity for steady-state operations.

Both Basic Paxos and Multi-Paxos can achieve consensus on a sequence of values (e.g., a log of commands) in a distributed system by conceptually running separate instances of Paxos for each item in the sequence, but Multi-Paxos is more performant due to its use of a stable leader to streamline the consensus process.

**Fast Paxos** reduces latency by allowing clients to bypass the leader for uncontested operations, requiring larger quorums (3f+1 nodes total, 2f+1 for fast operations) to maintain safety.

**Flexible Paxos** relaxes quorum requirements, showing that prepare and accept phases need only intersecting quorums rather than majorities, enabling asymmetric configurations optimized for common-case operations.

### Raft: Designed for Understandability

Raft prioritizes understandability while maintaining Paxos's safety guarantees. It ensures multiple servers agree on a sequence of commands by electing a leader that coordinates all changes. It's designed for log replication from the get go but it can also be used to achieve consensus on one value (in which case it would effectively be a sequence with the size of one)

Both Raft and ZAB are similar to some extent. They leader-based protocols where the leader receives all writes and replicates them to followers. From an implementation perspective, both protocols share similar phases, log replication with majority quorums for commitment, and recovery mechanisms.

**Leader Election**: At any given time, one server acts as the leader while others are followers. The leader handles all client requests and coordinates log replication.

**Log Replication**: The leader receives client commands, appends them to its log, and replicates these entries to follower servers before committing them.

**Safety**: Raft ensures that if any server has committed a particular log entry at a given index, no other server can commit a different entry for that same index.

Each server can be in one of three states:

- **Leader**: Handles client requests and manages log replication
- **Follower**: Passively receives and responds to requests from leaders and candidates
- **Candidate**: Used during leader election when a follower believes the leader has failed

When the system starts or a leader fails, followers transition to candidates and begin an election:

1. A follower increments its term number and votes for itself
2. It sends RequestVote messages to other servers
3. If it receives votes from a majority of servers, it becomes the leader
4. If another server becomes leader first, it reverts to follower
5. If no majority is reached, a new election begins after a timeout

#### Log Replication Process

Once a leader is established:

1. Client sends a command to the leader
2. Leader appends the command to its local log
3. Leader sends AppendEntries messages to all followers containing the new entry
4. Followers append the entry to their logs and respond with success/failure
5. Once the leader receives confirmation from a majority, it commits the entry
6. Leader notifies followers to commit the entry in subsequent messages
7. The committed entry is applied to the state machine

#### Key Safety Properties

**Election Safety**: At most one leader can be elected in a given term.

**Leader Append-Only**: Leaders never overwrite or delete entries in their logs.

**Log Matching**: If two logs contain an entry with the same index and term, the logs are identical in all preceding entries.

**Leader Completeness**: If an entry is committed in a given term, it will be present in the logs of leaders for all higher-numbered terms.

#### Handling Failures

Raft handles various failure scenarios:

- **Leader failure**: Followers detect missing heartbeats and start a new election
- **Follower failure**: Leader continues operating with remaining followers
- **Network partitions**: The partition with a majority can continue operating
- **Message loss**: Retry mechanisms and idempotency ensure consistency

The algorithm's strength lies in its simplicity and understandability compared to alternatives

Raft's adoption in systems like etcd (Kubernetes), Consul, CockroachDB, and TiKV demonstrates its practical success. The algorithm's clarity reduces implementation errors and simplifies debugging, critical advantages for production systems.
## Byzantine Consensus: When Nodes Can't Be Trusted

Byzantine consensus addresses scenarios where nodes may exhibit arbitrary behavior—sending conflicting messages, corrupting data, or deliberately attempting to violate protocol rules. These failures arise from:

- Hardware faults causing message or state corruption
- Software bugs producing incorrect outputs
- Network errors introducing message corruption
- Malicious actors in multi-organization or permissionless systems

Byzantine fault tolerance requires fundamentally different approaches than crash-fault tolerance, with higher message complexity and stronger cryptographic guarantees.

### PBFT: Making Byzantine Consensus Practical

PBFT (Practical Byzantine Fault Tolerance) made Byzantine consensus feasible for real systems. The protocol tolerates f Byzantine failures with 3f+1 total nodes, ensuring honest nodes always outnumber Byzantine ones in any decision quorum.

The protocol operates in three phases:

1. **Pre-prepare**: The primary assigns sequence numbers to client requests and broadcasts to backups
2. **Prepare**: Backups broadcast prepare messages, collecting 2f matching messages before proceeding
3. **Commit**: Nodes broadcast commit messages, executing after receiving 2f+1 matching commits

Cross-validation is central to PBFT's design. Nodes verify each other's messages, ensuring Byzantine nodes cannot unilaterally corrupt the protocol. The quadratic message complexity (O(n²) per operation) reflects this verification overhead—each node must hear from enough others to guarantee non-Byzantine majority agreement.

Optimizations reduce common-case overhead:

- Tentative execution allows clients to proceed after 2f+1 matching responses
- Read-only operations bypass the agreement protocol using state signatures
- Checkpointing periodically garbage-collects message logs

Byzantine consensus remains primarily relevant for:

- Blockchain and distributed ledger systems
- Multi-organization deployments without mutual trust
- Critical infrastructure requiring extreme fault tolerance
- Systems where hardware corruption is a significant concern

## Wrapping Up

Distributed consensus forms the backbone of reliable distributed systems. These algorithms solve fundamental coordination problems, enabling features from leader election to distributed transactions. While implementation complexity varies significantly—from Raft's deliberate simplicity to PBFT's Byzantine fault tolerance—all consensus algorithms share core challenges: maintaining safety despite asynchrony, achieving liveness under partial failures, and providing clear consistency guarantees.

Understanding these algorithms' properties, trade-offs, and appropriate use cases is essential for designing and operating distributed systems. Whether selecting a coordination service, debugging replication issues, or designing new distributed protocols, consensus algorithms provide the theoretical foundation and practical tools for building reliable cloud-native systems.

The evolution from Paxos's theoretical elegance to Raft's pragmatic clarity, and from crash-fault tolerance to Byzantine consensus, reflects the distributed systems community's ongoing effort to balance theoretical rigor with practical deployability. As cloud-native architectures continue evolving, consensus algorithms remain critical for managing distributed state reliably at scale.