# System Design Cloud-Native SaaS Systems - Interview Curriculum

## Module 1: Core System Design Fundamentals

### 1.1 Architecture and System Design basics

- What is architecture and system design
- Architectural views
- Models for documentation
- Integration, disintegration drivers, cohesion and coupling (from clean architecture; hard parts)

### 1.2 Modern architectural styles, patterns and design

* Requirements gathering (see `Hands-On Software Architecture with Java`, Design it!)
* [Domain Driven Design](module_1_core_fundamentals/1.2_architectural_patterns/DDD.md)
* Modern architectural styles
* Modular monoliths
* Microservices and its cousins (SOA, macroservices and miniservices)
* Microservices Decomposition (see Microservices patterns by Richardson)
* Choreography and orchestration
* Event driven architectures, CQRS and Sagas
* Reactive programming
* Big Data Systems
* Serverless
* Testing cloud based applications

### 1.5 Networking & Communication

- Protocols and OSI model
- [Key network components](module_1_core_fundamentals/1.5_network_and_communication/network_components.md)
- Service Meshes
- API architecture (see Mastering API Architecture)
- [Network in AWS](module_1_core_fundamentals/1.5_network_and_communication/network_aws.md)
- [Kubernetes Networking](module_1_core_fundamentals/1.5_network_and_communication/kubernetes_networking.md)

### 1.3 Distributed Systems Essentials

- Distributed systems overview
- Concurrent programming essentials
- [Sharding and replication](module_1_core_fundamentals/1.3_distributed_systems/sharding_replication.md)
- [CAP theorem and its practical implications](module_1_core_fundamentals/1.3_distributed_systems/cap.md)
- Consistency models: strong, eventual, causal
- [Partitioning and replication strategies](module_1_core_fundamentals/1.3_distributed_systems/DBs.md)
- Consensus basics (see Database Internals by Alex Petrov)
- [Distributed coordination and locking](module_1_core_fundamentals/1.3_distributed_systems/Locks.md)
- Kubernetes deep dive
- Apache Spark deep dive
### 1.4 Data Storage and Processing

- Types of databases and data modeling
- [Scalability in databases](module_1_core_fundamentals/1.4_data_storage/scalability_db.md)
- [ACID vs BASE trade-offs](module_1_core_fundamentals/1.4_data_storage/acid_base.md)
- [Transaction isolation levels: Understanding anomalies and guarantees](module_1_core_fundamentals/1.4_data_storage/isolation_levels.md)
- Distributed search
- Message patterns
- [Message Queue systems](module_1_core_fundamentals/1.4_data_storage/message_brokers.md)
- [Exactly-once semantics](module_1_core_fundamentals/1.4_data_storage/exactly_once.md)
- Batch vs Stream Processing
- Big Data and MapReduce
- Data pipelines and ETL architectures
- Kafka deep dive
### 2.3 Fault Tolerance and scalability

- Redundancy
- [Rate limiting](module_2_scalability_performance/2.3_fault_tolerance/rate_limiting.md)
- Circuit breakers, Bulkheads, Retry strategies
- [Distributed locks: Coordination patterns and pitfalls](module_1_core_fundamentals/1.3_distributed_systems/Locks.md)
- Caching

### 1.6 Security and data protection

- [Authentication and authorization protocols](module_1_core_fundamentals/1.6_security_and_data_protection/auth.md)
- Zero-trust architecture principles
- Encryption at rest and in transit
- Multi-tenancy
### 2.4 Observability

- Metrics, logs, and traces
- SRE: SLIs, SLOs, and error budgets
