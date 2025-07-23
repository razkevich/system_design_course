## Introduction

- Who needs system design. Roles in modern development. What is expected from a Senior/Staff position candidate.
- Standard interview flow
- Interview specifics at FAANG
- Framework for successful completion
- **Communication strategies for system design discussions**
- **How to effectively present and defend design decisions**

### Architecture and System Design

- What is architecture and system design
- Architectural views
- Models for documentation
- **Trade-off analysis and decision-making frameworks**

### Requirements Gathering

- Types of requirements
- Functional requirements
- Effective techniques for gathering functional requirements
- Non-functional requirements
- Gathering non-functional requirements
- Architectural constraints
- **Security requirements and compliance considerations**

### Architectural Styles, Patterns, and Tactics

- What are architectural styles, patterns, and tactics
- Overview of architectural styles (layered, pipes and filters, pipeline, microkernel, service based, event driven, space based, orchestration driven, microservices)
- Detailed on layered architecture
- Detailed on event driven
- Detailed on microservices
- Tactics for scaling:
  - Outbox pattern
  - [Rate limiting](rate_limiting.md)
  - [Distributed locks](Locks.md)
  - Circuit breaker pattern
  - Bulkhead pattern
  - Throttling and backpressure
  - Connection pooling
  - Database connection management
  - Graceful degradation
  - Retry patterns with exponential backoff
  - Dead letter queues
  - Health checks and heartbeats
- **Caching strategies and CDN architecture**
- **Load balancing patterns and techniques**

### High-Level Design

- **Component identification and responsibility assignment**
-  [**Domain Driven Design**](DDD.md)
- **System boundaries and interfaces**
- **Practice exercise: Design a URL shortener**

### API Design

- **RESTful principles and best practices**
- **GraphQL vs REST trade-offs**
- **API versioning and evolution**
- **Practice exercise: Design API for a social media platform**

### Data Design and Storage

- **Data modeling fundamentals**
- **SQL vs NoSQL decision criteria**
- **Schema design patterns**
- **Data consistency patterns: CAP theorem, eventual consistency, strong consistency**
- **Sharding strategies and partitioning**
- **Practice exercise: Design data model for an e-commerce platform**

### Databases and Messaging Systems

- [**ACID properties and BASE**](acid_base.md)
- [**Database isolation levels**](isolation_levels.md)
- [**Database fundamentals**](DBs.md)
- **Message queues vs event streaming**
- **Kafka, RabbitMQ, and other messaging patterns**
- **Database replication and failover**

### Distributed Systems

- **Consensus algorithms (Raft, Paxos basics)**
- **Distributed transactions and saga pattern**
- **Service discovery and coordination**
- **Practice exercise: Design a distributed task scheduler**

### Performance and Optimization

- **Performance metrics and SLAs**
- **Caching layers: application, database, CDN**
- **Query optimization and indexing strategies**
- **Asynchronous processing patterns**
- **Performance testing and capacity planning**

### Security Architecture

- **Authentication and authorization patterns (OAuth, JWT, SSO)**
- **API security best practices**
- **Data encryption at rest and in transit**
- **Security in microservices: service mesh, mTLS**
- **Common security vulnerabilities and mitigation**

### Cloud Technologies and Microservices

- **Cloud-native design principles**
- **Container orchestration (Kubernetes concepts)**
- **Serverless architecture patterns**
- **Multi-region deployment strategies**
- **Practice exercise: Migrate monolith to microservices**

### Reliability and Observability

- **SRE principles and error budgets**
- **Monitoring, logging, and tracing (the three pillars)**
- **Incident response and postmortems**
- **Chaos engineering basics**
- **Practice exercise: Design monitoring for a payment system**

### Use Case Analysis

- **Full system design walkthroughs**
- **Common interview questions: Design WhatsApp/Uber/Netflix**
- **Mock interviews with feedback**
- **Time management during system design interviews**

### Capstone Project

- **End-to-end design of a complex system**
- **Peer review and presentation**
- **Interview simulation with industry professionals**