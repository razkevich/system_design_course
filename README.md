# System Design Interview Curriculum

## Module 1: Interview Foundation & Framework

### 1.1 Interview Reality Check

- System design interview expectations by level
- Company-specific patterns
- Evaluation criteria breakdown
- Common failure points and how to avoid them
- The 7-Step Interview Framework

### 1.3 Communication Excellence

- Structured problem-solving approach
- Collaborative design techniques
- Handling ambiguity and pushback
- Time management strategies

## Module 2: Core System Design Fundamentals

### 2.1 Architecture and System Design basics

- What is architecture and system design
- Architectural views
- Models for documentation
- Trade-off analysis and decision-making frameworks

### 2.2 Modern architectural styles, patterns and design

* [Domain Driven Design](DDD.md)
* Modern architectural styles
* Modular monoliths
* Microservices architecture deep dive
* Event driven architectures
* Real time systems
### 2.3 Distributed Systems Essentials

- Distributed systems overview
- Sharding and replication
- [CAP theorem and its practical implications](cap.md)
- Consistency models: strong, eventual, causal
- [Partitioning and replication strategies](DBs.md)
- Consensus basics
- [Distributed coordination and locking](Locks.md)
- Clock synchronization and ordering

### 2.4 Data Storage and Processing

- Relational databases
- NoSQL databases
- Data modeling
- Partitioning and replication
- [ACID vs BASE trade-offs](acid_base.md)
- [Transaction isolation levels: Understanding anomalies and guarantees](isolation_levels.md)
- Enabling distributed search
- [Message Queue systems](message_brokers.md)
- Batch vs Stream Processing
- Big Data and MapReduce
- Data pipelines and ETL architectures

### 2.5 Networking & Communication

- Key network components
- Protocols: HTTP/2, WebSockets, gRPC
- API paradigms: REST, GraphQL, RPC
- Message patterns: Request-response, pub-sub, streaming
- Load balancing: L4 vs L7, algorithms, health checks

### 2.6 Security and data protection

- Authentication and authorization
- Zero-trust architecture principles
- Encryption at rest and in transit
- Multi-tenancy isolation strategies

## Module 3: Scalability & Performance Patterns

### 3.1 Scaling

- Horizontal vs vertical scaling decision points
- Cache levels: Browser, CDN, reverse proxy, application, database
- Cache patterns: Cache-aside, write-through, write-behind
- Distributed caching
### 3.3 Fault Tolerance Patterns

- Redundancy: Active-active vs active-passive
- [Rate limiting](rate_limiting.md)
- Circuit breakers: Implementation and tuning
- Bulkheads: Isolating failures
- Retry strategies: Exponential backoff, jitter
- [Distributed locks: Coordination patterns and pitfalls](Locks.md)
## Module 4: Cloud-Native & DevOps

### 4.1 Cloud Patterns

- Containerization and orchestration essentials
- Serverless architecture trade-offs
- Multi-cloud considerations
- Cost optimization strategies
### 4.2 Kubernetes

### 4.3 Observability

- Metrics, logs, and traces
- SRE: SLIs, SLOs, and error budgets
- Alerting strategies
