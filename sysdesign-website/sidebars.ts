import type {SidebarsConfig} from '@docusaurus/plugin-content-docs';

// This runs in Node.js - Don't use client-side code here (browser APIs, JSX...)

/**
 * Creating a sidebar enables you to:
 - create an ordered group of docs
 - render a sidebar for each doc of that group
 - provide next/previous navigation

 The sidebars can be generated from the filesystem, or explicitly defined here.

 Create as many sidebars as you want.
 */
const sidebars: SidebarsConfig = {
  tutorialSidebar: [
    'intro',
    {
      type: 'category',
      label: '1. Основы архитектуры и системного проектирования',
      items: [
        {
          type: 'category', 
          label: 'Основные концепции',
          items: [
            'architecture_basics/what_is_architecture_system_design_ru',
            'architecture_basics/architectural_views_ru',
          ],
        },
        {
          type: 'category',
          label: 'Основные принципы', 
          items: [
            'architecture_basics/decomposition_boundaries_ru',
            'architecture_basics/architecture_tradeoffs_ru',
            'architecture_basics/evolution_change_management_ru',
            'architecture_basics/requirements_ru',
            'architecture_basics/quality_attributes_constraints_ru',
            'architecture_basics/communication_patterns_ru',
          ],
        },
        // 'architecture_basics/quiz',
      ],
    },
    {
      type: 'category',
      label: '2. Современные архитектурные стили и шаблоны',
      items: [
        {
          type: 'category',
          label: 'Предметно-ориентированное проектирование',
          items: [
            'architectural_patterns/domain_driven_design_ru',
            'architectural_patterns/tactical_ddd_ru',
            'architectural_patterns/strategic_ddd_ru',
          ],
        },
        {
          type: 'category',
          label: 'Архитектурные стили',
          items: [
            'architectural_patterns/modern_architectural_styles_ru',
            'architectural_patterns/modular_monoliths_ru',
            'architectural_patterns/microservices_ru',
            'architectural_patterns/eda_ru',
            'architectural_patterns/reactive_ru',
            'architectural_patterns/serverless_ru',
            'architectural_patterns/multitenancy_ru',
          ],
        },
        // 'architectural_patterns/quiz',
      ],
    },
    {
      type: 'category',
      label: '3. Сети и коммуникации',
      items: [
        'network_and_communication/api_architecture_ru',
        'network_and_communication/protocols_osi_model_ru',
        'network_and_communication/network_components_ru',
        'network_and_communication/service_meshes_ru',
        'network_and_communication/network_aws_ru',
        // 'network_and_communication/quiz',
      ],
    },
    {
      type: 'category',
      label: '4. Основы распределенных систем',
      items: [
        {
          type: 'category',
          label: 'Основные концепции',
          items: [
            'distributed_systems/overview_ru',
            'distributed_systems/sharding_replication_ru',
            'distributed_systems/cap_ru',
            'distributed_systems/DBs_ru',
          ],
        },
        {
          type: 'category',
          label: 'Координация и инфраструктура',
          items: [
            'distributed_systems/consensus_ru',
            // 'distributed_systems/Locks_ru',
            'distributed_systems/aws_resource_hierarchy_guide_ru',
            'data_storage/data_architecture_ru',
          ],
        },
        {
          type: 'category',
          label: 'Kubernetes и оркестрация контейнеров',
          items: [
            'distributed_systems/kubernetes_architecture_ru',
            'distributed_systems/kubernetes_resource_hierarchy_guide_ru',
            'distributed_systems/kubernetes_networking_ru',
          ],
        },
        // 'distributed_systems/quiz',
      ],
    },
    {
      type: 'category',
      label: '5. Хранение и обработка данных',
      items: [
        {
          type: 'category',
          label: 'Проектирование баз данных',
          items: [
            'data_storage/scalability_db_ru',
            'data_storage/acid_base_ru',
            'data_storage/isolation_levels_ru',
          ],
        },
        {
          type: 'category',
          label: 'Обмен сообщениями и обработка',
          items: [
            'data_storage/distributed_search_ru',
            'data_storage/message_brokers_ru',
            'data_storage/exactly_once_ru',
            'data_storage/big_data_ru',
            'data_storage/kafka_deep_dive_ru',
          ],
        },
        // 'data_storage/quiz',
      ],
    },
    {
      type: 'category',
      label: '6. Отказоустойчивость, масштабируемость и observability',
      items: [
        {
          type: 'category',
          label: 'Шаблоны отказоустойчивости',
          items: [
            'fault_tolerance/redundancy_ru',
            'fault_tolerance/rate_limiting_ru',
            'fault_tolerance/circuit_breakers_ru',
            'fault_tolerance/bulkheads_ru',
            'fault_tolerance/outbox_pattern_ru',
            // 'fault_tolerance/cache_ru',
            'fault_tolerance/cost_optimization_ru',
          ],
        },
        {
          type: 'category',
          label: 'Мониторинг и эксплуатация',
          items: [
            'fault_tolerance/observability_and_sre_ru',
          ],
        },
        // 'fault_tolerance/quiz',
      ],
    },
    {
      type: 'category',
      label: '7. Безопасность и защита данных',
      items: [
        'security_and_data_protection/auth_ru',
        'security_and_data_protection/securing_ru',
        'security_and_data_protection/securing_rest_transit_ru',
        'security_and_data_protection/compliance_ru',
        // 'security_and_data_protection/quiz',
      ],
    },
  ],
};

export default sidebars;
