# System Design for Cloud-Native SaaS Systems

## Module 1: Core System Design Fundamentals

### 1.1 Architecture and System Design basics

- [What is architecture and system design](1.1_architecture_basics/what_is_architecture_system_design.md)
- [Architectural views](1.1_architecture_basics/architectural_views.md) <---tbd
- System design fundamentals
	- [Decomposition and boundaries](1.1_architecture_basics/decomposition_boundaries.md)
	- [Trade-offs in software architecture](1.1_architecture_basics/architecture_tradeoffs.md)
	- [Evolution and change management](1.1_architecture_basics/evolution_change_management.md)
	- [Requirements gathering](1.1_architecture_basics/requirements.md)
	- [Quality attributes and constraints](1.1_architecture_basics/quality_attributes_constraints.md)
	- [Communication patterns](1.1_architecture_basics/communication_patterns.md)

### 1.2 Modern architectural styles, patterns and design

* [Domain Driven Design](1.2_architectural_patterns/DDD.md)
* [Tactical DDD](1.2_architectural_patterns/tactical_ddd.md)
* [Strategic DDD](1.2_architectural_patterns/strategic_ddd.md) <--- check it
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

### 1.3 Networking & Communication

- [Protocols and OSI model](1.3_network_and_communication/protocols_osi_model.md)
- [Key network components](1.3_network_and_communication/network_components.md)
- Service Meshes
- API architecture (see Mastering API Architecture)
- [Network in AWS](1.3_network_and_communication/network_aws.md)
- [Kubernetes Networking](1.3_network_and_communication/kubernetes_networking.md)

### 1.4 Distributed Systems Essentials

- Distributed systems overview
- Concurrent programming essentials
- [Sharding and replication](1.4_distributed_systems/sharding_replication.md)
- [CAP theorem and its practical implications](1.4_distributed_systems/cap.md)
- Consistency models: strong, eventual, causal
- [Partitioning and replication strategies](1.4_distributed_systems/DBs.md)
- Consensus basics (see Database Internals by Alex Petrov)
- [Distributed coordination and locking](1.4_distributed_systems/Locks.md)
- [Kubernetes deep dive](1.4_distributed_systems/kubernetes_architecture.md)
- [Kubernetes Resource Hierarchy Guide](1.4_distributed_systems/kubernetes_resource_hierarchy_guide.md)
- [AWS Resource Hierarchy Guide](1.4_distributed_systems/aws_resource_hierarchy_guide.md)
- Apache Spark deep dive
### 1.5 Data Storage and Processing

- Types of databases and data modeling
- [Scalability in databases](1.5_data_storage/scalability_db.md)
- [ACID vs BASE trade-offs](1.5_data_storage/acid_base.md)
- [Transaction isolation levels: Understanding anomalies and guarantees](1.5_data_storage/isolation_levels.md)
- Distributed search
- Message patterns
- [Message Queue systems](1.5_data_storage/message_brokers.md)
- [Exactly-once semantics](1.5_data_storage/exactly_once.md)
- Batch vs Stream Processing
- Big Data and MapReduce
- Data pipelines and ETL architectures
- Kafka deep dive
### 1.6 Fault Tolerance and scalability

- Redundancy
- [Rate limiting](1.6_fault_tolerance/rate_limiting.md)
- Circuit breakers, Bulkheads, Retry strategies
- [Distributed locks: Coordination patterns and pitfalls](1.4_distributed_systems/Locks.md)
- Caching

### 1.7 Security and data protection

- [Authentication and authorization protocols](1.7_security_and_data_protection/auth.md)
- Zero-trust architecture principles
- Encryption at rest and in transit
- Multi-tenancy
### 1.8 Observability

- Metrics, logs, and traces
- SRE: SLIs, SLOs, and error budgets
