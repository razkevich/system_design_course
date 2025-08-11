# 🏗️ System Design for Cloud-Native SaaS Systems

> *A comprehensive guide to architecting, building, and scaling modern distributed systems*

Welcome to your journey through the intricate world of system design! This course takes you from foundational concepts to advanced patterns used by the world's most scalable SaaS platforms. Whether you're preparing for system design interviews or building the next generation of cloud-native applications, this guide provides the knowledge and patterns you need.

---

## 🎯 1 Architecture & System Design Basics

**Foundation Concepts**
- [📖 What is Architecture and System Design?](1_architecture_basics/what_is_architecture_system_design.md)
- [🔍 Architectural Views](1_architecture_basics/architectural_views.md)

**Core Principles**
- [🔧 Decomposition and Boundaries](1_architecture_basics/decomposition_boundaries.md)
- [⚖️ Trade-offs in Software Architecture](1_architecture_basics/architecture_tradeoffs.md)
- [🔄 Evolution and Change Management](1_architecture_basics/evolution_change_management.md)
- [📋 Requirements Gathering](1_architecture_basics/requirements.md)
- [🎯 Quality Attributes and Constraints](1_architecture_basics/quality_attributes_constraints.md)
- [💬 Communication Patterns](1_architecture_basics/communication_patterns.md)

## 🏛️ 2 Modern Architectural Styles & Patterns

**Domain-Driven Design**
- [🎯 Domain Driven Design](2_architectural_patterns/DDD.md)
- [🛠️ Tactical DDD](2_architectural_patterns/tactical_ddd.md)
- [🌐 Strategic DDD](2_architectural_patterns/strategic_ddd.md)

**Architectural Styles**
- [🔄 Modern Architectural Styles Overview](2_architectural_patterns/modern_architectural_styles.md)
- [🏢 Modular Monoliths](2_architectural_patterns/modular_monoliths.md)
- [🔀 Microservices](2_architectural_patterns/microservices.md)
- [⚡ Event-Driven Architecture, CQRS & Sagas](2_architectural_patterns/eda.md)
- 🌊 [Reactive Programming](2_architectural_patterns/reactive.md)
- [⚡ Serverless](2_architectural_patterns/serverless.md)

## 🌐 3 Networking & Communication

- [📡 Protocols and OSI Model](3_network_and_communication/protocols_osi_model.md)
- [🔧 Key Network Components](3_network_and_communication/network_components.md)
- [🕸️ Service Meshes](3_network_and_communication/service_meshes.md)
- 🚀 API Architecture *- Coming soon, See Mastering API Architecture*
- [☁️ Network in AWS](3_network_and_communication/network_aws.md)
- [☸️ Kubernetes Networking](3_network_and_communication/kubernetes_networking.md)

## 🔗 4 Distributed Systems Essentials
- [Distributed Systems Overview](4_distributed_systems/overview.md)
**Data Distribution**
- [📊 Sharding and Replication](4_distributed_systems/sharding_replication.md)
- [⚖️ CAP Theorem and Practical Implications](4_distributed_systems/cap.md)
- [🗂️ Partitioning and Replication Strategies](4_distributed_systems/DBs.md)

**Coordination & Infrastructure**
- 🤝 Consensus Basics *- See Database Internals by Alex Petrov*
- [🔒 Distributed Coordination and Locking](4_distributed_systems/Locks.md)
- [☸️ Kubernetes Deep Dive](4_distributed_systems/kubernetes_architecture.md)
- [📊 Kubernetes Resource Hierarchy](4_distributed_systems/kubernetes_resource_hierarchy_guide.md)
- [☁️ AWS Resource Hierarchy](4_distributed_systems/aws_resource_hierarchy_guide.md)
- ⚡ Apache Spark Deep Dive *- Coming Soon*
- Data architecture (data lakes etc), pipelines and ETL

## 💾 5 Data Storage & Processing

**Database Design**
- 🗄️ Database Types and Data Modeling *- Coming Soon*
- [📈 Scalability in Databases](5_data_storage/scalability_db.md)
- [⚖️ ACID vs BASE Trade-offs](5_data_storage/acid_base.md)
- [🔒 Transaction Isolation Levels](5_data_storage/isolation_levels.md)

**Messaging & Processing**
- 🔍 Distributed Search *- Coming Soon*
- [📨 Message Queue Systems](5_data_storage/message_brokers.md)
- [✅ Exactly-Once Semantics](5_data_storage/exactly_once.md)
- ⚡ Batch and Stream Processing *- Coming Soon*
- 🐘 Big Data and MapReduce *- Coming Soon*
- 📊 Kafka Deep Dive *- Coming Soon*

## 🛡️ 6 Fault Tolerance, Scalability & Observability

**Resilience Patterns**
- [🔄 Redundancy](6_fault_tolerance/redundancy.md)
- [🚦 Rate Limiting](6_fault_tolerance/rate_limiting.md)
- [⚡ Circuit Breakers](6_fault_tolerance/circuit_breakers.md)
- [🚧 Bulkheads](6_fault_tolerance/bulkheads.md)
- [📦 Outbox Pattern](6_fault_tolerance/outbox_pattern.md)
- 💾 Caching *- Coming Soon*
- [Cost optimization](6_fault_tolerance/cost_optimization.md)

**Monitoring & Operations**
- [👁️ Observability and SRE](6_fault_tolerance/observability_and_sre.md)

## 🔐 7 Security & Data Protection

- [🔑 Authentication and Authorization](7_security_and_data_protection/auth.md)
- [🛡️ Securing cloud-native applications](7_security_and_data_protection/securing.md) <-- todo
- [🔒 Securing Data at Rest and in Transit](7_security_and_data_protection/securing_rest_transit.md)
- [Compliance frameworks, audits and standards](7_security_and_data_protection/compliance.md)
- [🏢 Multi-tenancy](7_security_and_data_protection/multitenancy.md)

---

## 🚀 How to Use This Guide

Each section builds upon previous concepts, but you can also jump to specific topics based on your needs:

- **📚 For Learning**: Start with Module 1 and progress sequentially
- **🎯 For Interviews**: Focus on distributed systems, scalability patterns, and trade-offs
- **🛠️ For Implementation**: Jump to specific patterns and architectural styles
- **📖 For Reference**: Use as a quick lookup for concepts and patterns

## 🤝 Contributing

Found an error? Want to suggest improvements? This guide is continuously evolving. Check out our [contribution guidelines](CONTRIBUTING.md) to get involved.

---

*Built with ❤️ for engineers designing the future of scalable systems*