import type {SidebarsConfig} from '@docusaurus/plugin-content-docs';

const sidebars: SidebarsConfig = {
  tutorialSidebar: [
    'intro',
    {
      type: 'category',
      label: '1. Architecture Basics',
      items: [
        {
          type: 'category',
          label: 'Core Concepts',
          items: [
            'architecture_basics/what_is_architecture_system_design',
            'architecture_basics/architectural_views',
          ],
        },
        {
          type: 'category',
          label: 'Fundamental Principles',
          items: [
            'architecture_basics/decomposition_boundaries',
            'architecture_basics/architecture_tradeoffs',
            'architecture_basics/evolution_change_management',
            'architecture_basics/requirements',
            'architecture_basics/quality_attributes_constraints',
            'architecture_basics/communication_patterns',
          ],
        },
        // No quiz in EN yet
      ],
    },
    {
      type: 'category',
      label: '2. Architectural Patterns',
      items: [
        {
          type: 'category',
          label: 'Domain-Driven Design',
          items: [
            'architectural_patterns/domain_driven_design',
            'architectural_patterns/tactical_ddd',
            'architectural_patterns/strategic_ddd',
          ],
        },
        {
          type: 'category',
          label: 'Styles',
          items: [
            'architectural_patterns/modern_architectural_styles',
            'architectural_patterns/modular_monoliths',
            'architectural_patterns/microservices',
            'architectural_patterns/eda',
            'architectural_patterns/reactive',
            'architectural_patterns/serverless',
            'architectural_patterns/multitenancy',
          ],
        },
      ],
    },
    {
      type: 'category',
      label: '3. Networks & Communication',
      items: [
        'network_and_communication/api_architecture',
        'network_and_communication/protocols_osi_model',
        'network_and_communication/network_components',
        'network_and_communication/service_meshes',
        'network_and_communication/network_aws',
      ],
    },
    {
      type: 'category',
      label: '4. Distributed Systems',
      items: [
        {
          type: 'category',
          label: 'Core Concepts',
          items: [
            'distributed_systems/overview',
            'distributed_systems/sharding_replication',
            'distributed_systems/cap',
            'distributed_systems/DBs',
          ],
        },
        {
          type: 'category',
          label: 'Coordination & Infrastructure',
          items: [
            'distributed_systems/consensus',
            'distributed_systems/Locks',
            'distributed_systems/aws_resource_hierarchy_guide',
            'data_storage/data_architecture',
          ],
        },
        {
          type: 'category',
          label: 'Kubernetes & Orchestration',
          items: [
            'distributed_systems/kubernetes_architecture',
            'distributed_systems/kubernetes_resource_hierarchy_guide',
            'distributed_systems/kubernetes_networking',
          ],
        },
      ],
    },
    {
      type: 'category',
      label: '5. Data Storage & Processing',
      items: [
        {
          type: 'category',
          label: 'Database Design',
          items: [
            'data_storage/scalability_db',
            'data_storage/acid_base',
            'data_storage/isolation_levels',
          ],
        },
        {
          type: 'category',
          label: 'Messaging & Processing',
          items: [
            'data_storage/distributed_search',
            'data_storage/message_brokers',
            'data_storage/exactly_once',
            'data_storage/big_data',
            'data_storage/kafka_deep_dive',
          ],
        },
      ],
    },
    {
      type: 'category',
      label: '6. Resilience, Scale & Observability',
      items: [
        {
          type: 'category',
          label: 'Resilience Patterns',
          items: [
            'fault_tolerance/redundancy',
            'fault_tolerance/rate_limiting',
            'fault_tolerance/circuit_breakers',
            'fault_tolerance/bulkheads',
            'fault_tolerance/outbox_pattern',
            'fault_tolerance/cache',
            // 'fault_tolerance/cost_optimization',
          ],
        },
        {
          type: 'category',
          label: 'Operations & Monitoring',
          items: [
            'fault_tolerance/observability_and_sre',
          ],
        },
      ],
    },
    {
      type: 'category',
      label: '7. Security & Data Protection',
      items: [
        'security_and_data_protection/auth',
        'security_and_data_protection/securing',
        'security_and_data_protection/securing_rest_transit',
        'security_and_data_protection/compliance',
      ],
    },
  ],
};

export default sidebars;
