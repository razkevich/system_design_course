# Kubernetes Developer Guide

A comprehensive guide to Kubernetes concepts organized by functional categories with modern Mermaid diagrams.

## 🔴 Workloads & Scheduling

Core application deployment and job execution components.

```mermaid
flowchart TD
    subgraph "🔴 Workloads & Scheduling"
        
        subgraph "Core Workload Hierarchy"
            Deployment["🔄 Deployment<br/>Stateless apps"]
            StatefulSet["📊 StatefulSet<br/>Stateful apps"]
            DaemonSet["🌐 DaemonSet<br/>Node-level services"]
            
            ReplicaSet["📋 ReplicaSet<br/>Replica management"]
            Pod["📦 Pod<br/>Basic execution unit"]
            
            Deployment --> ReplicaSet
            StatefulSet --> Pod
            DaemonSet --> Pod
            ReplicaSet --> Pod
        end
        
        subgraph "Batch Processing Hierarchy"
            CronJob["⏰ CronJob<br/>Scheduled tasks"]
            Job["🔧 Job<br/>Run-to-completion"]
            BatchPod["📦 Pod<br/>Task execution"]
            
            CronJob --> Job
            Job --> BatchPod
        end
        
        subgraph "Auto-scaling Controllers"
            HPA["📈 HorizontalPodAutoscaler<br/>Scale replicas"]
            VPA["📊 VerticalPodAutoscaler<br/>Scale resources"]
            
            HPA -.->|"scales"| Deployment
            HPA -.->|"scales"| StatefulSet
            VPA -.->|"adjusts"| Pod
        end
    end
    
    style Pod fill:#ff9999
    style ReplicaSet fill:#ffb3b3
    style Deployment fill:#ffcccc
    style StatefulSet fill:#ffcccc
    style DaemonSet fill:#ffcccc
```

## 🔵 Networking & Service Mesh

Service discovery, connectivity, and traffic management.

```mermaid
flowchart TD
    subgraph "🔵 Networking & Service Mesh"
        
        subgraph "Traffic Flow Hierarchy"
            Ingress["🌐 Ingress<br/>HTTP/HTTPS routing"]
            IngressController["🎛️ Ingress Controller<br/>Traffic management"]
            Service["⚖️ Service<br/>Load balancing"]
            EndpointSlice["📋 EndpointSlice<br/>Scalable endpoints"]
            NetworkPod["📦 Pod<br/>Target workload"]
            
            IngressController -.->|"implements"| Ingress
            Ingress --> Service
            Service --> EndpointSlice
            EndpointSlice --> NetworkPod
        end
        
        subgraph "Service Mesh Hierarchy"
            ServiceMesh["🕸️ Service Mesh<br/>Istio/Linkerd"]
            VirtualService["🔀 VirtualService<br/>Traffic rules"]
            DestinationRule["🎯 DestinationRule<br/>Load balancing"]
            MeshService["⚖️ Service<br/>Mesh endpoint"]
            
            ServiceMesh --> VirtualService
            ServiceMesh --> DestinationRule
            VirtualService --> MeshService
            DestinationRule --> MeshService
        end
        
        subgraph "Network Security"
            NetworkPolicy["🛡️ NetworkPolicy<br/>Traffic filtering"]
            NetworkPolicy -.->|"controls"| NetworkPod
        end
    end
    
    style NetworkPod fill:#cce5ff
    style Service fill:#99ccff
    style Ingress fill:#66b3ff
```

## 🟠 Storage & Data

Persistent data and volume management.

```mermaid
flowchart TD
    subgraph "🟠 Storage & Data"
        
        subgraph "Volume Provisioning Hierarchy"
            StorageClass["🏷️ StorageClass<br/>Dynamic provisioning"]
            CSI["🔌 CSI Driver<br/>Storage plugin"]
            PV["💾 PersistentVolume<br/>Cluster storage"]
            PVC["📝 PersistentVolumeClaim<br/>Storage request"]
            StoragePod["📦 Pod<br/>Volume consumer"]
            
            StorageClass -.->|"provisions"| PV
            CSI -.->|"implements"| StorageClass
            PVC -->|"binds to"| PV
            StoragePod -->|"mounts"| PVC
        end
        
        subgraph "Data Protection Hierarchy"
            VolumeSnapshotClass["📷 VolumeSnapshotClass<br/>Snapshot policy"]
            VolumeSnapshot["📸 VolumeSnapshot<br/>Point-in-time copy"]
            
            VolumeSnapshotClass -.->|"creates"| VolumeSnapshot
            VolumeSnapshot -->|"snapshots"| PVC
        end
    end
    
    style PV fill:#ffcc99
    style PVC fill:#ff9966
    style StorageClass fill:#ffb366
```

## 🟡 Configuration & Secrets

Application settings and sensitive data management.

```mermaid
flowchart TD
    subgraph "🟡 Configuration & Secrets"
        
        subgraph "Configuration Sources"
            ConfigMap["📋 ConfigMap<br/>Non-sensitive config"]
            Secret["🔐 Secret<br/>Sensitive data"]
        end
        
        subgraph "Consumption Hierarchy"
            EnvVar["🌐 Environment Variables<br/>Process environment"]
            VolumeMount["📁 Volume Mounts<br/>File system"]
            ConfigPod["📦 Pod<br/>Consumes config"]
            
            ConfigMap --> EnvVar
            ConfigMap --> VolumeMount
            Secret --> EnvVar
            Secret --> VolumeMount
            EnvVar --> ConfigPod
            VolumeMount --> ConfigPod
        end
    end
    
    style ConfigMap fill:#fff2cc
    style Secret fill:#ffe066
    style ConfigPod fill:#ffeb99
```

## 🟣 Security & Access Control

Authentication, authorization, and security policies.

```mermaid
flowchart TD
    subgraph "🟣 Security & Access Control"
        
        subgraph "Identity Sources"
            User["👤 User<br/>Human identity"]
            ServiceAccount["🎭 ServiceAccount<br/>Pod identity"]
        end
        
        subgraph "RBAC Hierarchy"
            Role["📋 Role<br/>Namespace permissions"]
            ClusterRole["🌐 ClusterRole<br/>Cluster permissions"]
            RoleBinding["🔗 RoleBinding<br/>Role assignment"]
            ClusterRoleBinding["🌍 ClusterRoleBinding<br/>Cluster role assignment"]
            SecurityPod["📦 Pod<br/>Access granted"]
            
            User --> RoleBinding
            User --> ClusterRoleBinding
            ServiceAccount --> RoleBinding
            ServiceAccount --> ClusterRoleBinding
            Role --> RoleBinding
            ClusterRole --> RoleBinding
            ClusterRole --> ClusterRoleBinding
            RoleBinding --> SecurityPod
            ClusterRoleBinding --> SecurityPod
        end
        
        subgraph "Security Enforcement"
            AdmissionController["🛡️ Admission Controller<br/>Request validation"]
            PodSecurityPolicy["📜 PodSecurityPolicy<br/>Pod security standards"]
            SecurityContext["🔒 SecurityContext<br/>Runtime security"]
            
            AdmissionController -.->|"validates"| SecurityPod
            PodSecurityPolicy -.->|"enforces"| SecurityPod
            SecurityContext -.->|"secures"| SecurityPod
        end
    end
    
    style ServiceAccount fill:#e6ccff
    style Role fill:#d9b3ff
    style ClusterRole fill:#cc99ff
    style PodSecurityPolicy fill:#bf80ff
```

## 🟢 Cluster Infrastructure

Platform management and resource governance.

```mermaid
flowchart TD
    subgraph "🟢 Cluster Infrastructure"
        
        subgraph "Physical Infrastructure"
            ControlPlane["🏢 Control Plane<br/>Cluster management"]
            Node["💻 Node<br/>Worker machine"]
            
            ControlPlane -.->|"manages"| Node
        end
        
        subgraph "Logical Organization"
            Namespace["🏪 Namespace<br/>Virtual clusters"]
            ResourceQuota["📊 ResourceQuota<br/>Namespace limits"]
            LimitRange["📏 LimitRange<br/>Object constraints"]
            
            Namespace --> ResourceQuota
            Namespace --> LimitRange
        end
        
        subgraph "Scheduling Hierarchy"
            PriorityClass["⬆️ PriorityClass<br/>Scheduling priority"]
            RuntimeClass["⚙️ RuntimeClass<br/>Container runtime"]
            InfraPod["📦 Pod<br/>Scheduled workload"]
            
            Node --> InfraPod
            PriorityClass -.->|"prioritizes"| InfraPod
            RuntimeClass -.->|"configures"| InfraPod
            ResourceQuota -.->|"limits"| InfraPod
            LimitRange -.->|"constrains"| InfraPod
        end
    end
    
    style Node fill:#ccffcc
    style ControlPlane fill:#99ff99
    style Namespace fill:#66ff66
    style ResourceQuota fill:#33ff33
```

## 🔵 Observability & Operations

Monitoring, logging, and operational tooling.

```mermaid
flowchart TD
    subgraph "🔵 Observability & Operations"
        
        subgraph "Monitoring Hierarchy"
            MetricsServer["📊 Metrics Server<br/>Resource metrics"]
            Prometheus["🔥 Prometheus<br/>Time-series DB"]
            ServiceMonitor["📝 ServiceMonitor<br/>Scrape config"]
            MonitoredPod["📦 Pod<br/>Metrics source"]
            
            ServiceMonitor --> Prometheus
            MetricsServer --> Prometheus
            MonitoredPod -.->|"scraped by"| ServiceMonitor
            MonitoredPod -.->|"metrics"| MetricsServer
        end
        
        subgraph "Logging Hierarchy"
            LoggingAgent["📜 Logging Agent<br/>Log collection"]
            Fluentd["🌊 Fluentd/Fluent Bit<br/>Log processing"]
            LogPod["📦 Pod<br/>Log source"]
            
            LogPod -.->|"logs"| LoggingAgent
            LoggingAgent --> Fluentd
        end
        
        subgraph "Custom Resource Hierarchy"
            Operator["🤖 Operator<br/>Application management"]
            Controller["🎮 Controller<br/>Reconciliation loop"]
            CRD["🛠️ CustomResourceDefinition<br/>API extensions"]
            CustomResource["📋 Custom Resource<br/>User-defined objects"]
            
            Operator --> Controller
            Operator --> CRD
            CRD --> CustomResource
            Controller -.->|"reconciles"| CustomResource
        end
    end
    
    style MetricsServer fill:#cce5ff
    style CRD fill:#99ccff
    style Operator fill:#66b3ff
    style Controller fill:#3399ff
```

## Key Relationships

The diagrams above show how Kubernetes resources within each category relate to each other. Here are some important cross-category relationships:

- **Workloads** consume **Configuration & Secrets** through environment variables and volume mounts
- **Services** in **Networking** expose **Pods** from **Workloads**
- **Storage** resources are consumed by **StatefulSets** and other workloads requiring persistence
- **Security** policies apply to all **Workloads** and control access to **Storage** and **Configuration**
- **Infrastructure** resources like **Nodes** and **Namespaces** provide the foundation for all other categories
- **Observability** tools monitor and operate on resources across all categories

This categorization helps developers understand the logical groupings of Kubernetes resources and how they work together to build robust, scalable applications.