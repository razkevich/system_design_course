# Проектирование систем для облачных SaaS-систем
  
> *Полное руководство по архитектуре, созданию и масштабированию современных распределенных систем*
  
Добро пожаловать в увлекательное путешествие по сложному миру системного проектирования! Этот курс познакомит вас с базовыми концепциями и передовыми шаблонами, используемыми в самых масштабируемых SaaS-платформах мира. Независимо от того, готовитесь ли вы к собеседованию по системному проектированию или создаете облачные приложения нового поколения, это руководство предоставит вам необходимые знания и шаблоны.
  
---
  
## 1 Основы архитектуры и системного проектирования
  
**Основные концепции**
- [Что такое архитектура и системное проектирование?](1_architecture_basics/what_is_architecture_system_design_ru.md)
- [Архитектурные представления](1_architecture_basics/architectural_views_ru.md)
  
**Основные принципы**
- [Декомпозиция и границы](1_architecture_basics/decomposition_boundaries_ru.md)
- [Компромиссы в архитектуре программного обеспечения](1_architecture_basics/architecture_tradeoffs_ru.md)
- [Управление эволюцией и изменениями](1_architecture_basics/evolution_change_management_ru.md)
- [Сбор требований](1_architecture_basics/requirements_ru.md)
- [Качественные атрибуты и ограничения](1_architecture_basics/quality_attributes_constraints_ru.md)
- [Шаблоны коммуникации](1_architecture_basics/communication_patterns_ru.md)
  
## 2 Современные архитектурные стили и шаблоны
  
**Предметно-ориентированное проектирование**
- [Предметно-ориентированное проектирование](2_architectural_patterns/domain_driven_design_ru.md)
- [Тактическое DDD](2_architectural_patterns/tactical_ddd_ru.md)
- [Стратегическое DDD](2_architectural_patterns/strategic_ddd_ru.md)
  
**Архитектурные стили**
- [Обзор современных архитектурных стилей](2_architectural_patterns/modern_architectural_styles_ru.md)
- [Модульные монолиты](2_architectural_patterns/modular_monoliths_ru.md)
- [Микросервисы](2_architectural_patterns/microservices_ru.md)
- [Событийно-ориентированная архитектура, CQRS и саги](2_architectural_patterns/eda_ru.md)
- [Реактивное программирование](2_architectural_patterns/reactive_ru.md)
- [Serverless](2_architectural_patterns/serverless_ru.md)
- [Multi-tenancy](2_architectural_patterns/multitenancy_ru.md)
  
## 3 Сети и коммуникации
  
- [Протоколы и модель OSI](3_network_and_communication/protocols_osi_model_ru.md)
- [Ключевые компоненты сети](3_network_and_communication/network_components_ru.md)
- [Service Meshes](3_network_and_communication/service_meshes_ru.md)
- [Сеть в AWS](3_network_and_communication/network_aws_ru.md)
  
## 4 Основы распределенных систем
  
**Основные концепции**
- [Обзор распределенных систем](4_distributed_systems/overview_ru.md)
- [Шардинг и репликация](4_distributed_systems/sharding_replication_ru.md)
- [Теорема CAP и практические последствия](4_distributed_systems/cap_ru.md)
- [Стратегии разбиения и репликации](4_distributed_systems/DBs_ru.md)
  
**Координация и инфраструктура**
- [Распределенный консенсус](4_distributed_systems/consensus_ru.md)
- [Иерархия ресурсов AWS](4_distributed_systems/aws_resource_hierarchy_guide_ru.md)
- [Архитектура данных, конвейеры и ETL](5_data_storage/data_architecture_ru.md)
  
**Kubernetes и оркестрация контейнеров**
- [Подробное описание Kubernetes](4_distributed_systems/kubernetes_architecture_ru.md)
- [Иерархия ресурсов Kubernetes](4_distributed_systems/kubernetes_resource_hierarchy_guide_ru.md)
- [Сети Kubernetes](4_distributed_systems/kubernetes_networking_ru.md)
  
## 5 Хранение и обработка данных
  
**Проектирование баз данных**
- [Масштабируемость и моделирование данных в базах данных](5_data_storage/scalability_db_ru.md)
- [ACID vs BASE: компромиссы](5_data_storage/acid_base_ru.md)
- [Уровни изоляции транзакций](5_data_storage/isolation_levels_ru.md)
  
**Обмен сообщениями и обработка**
- [Распределенный поиск](5_data_storage/distributed_search_ru.md)
- [Системы очередей сообщений](5_data_storage/message_brokers_ru.md)
- [Семантика «точно один раз»](5_data_storage/exactly_once_ru.md)
- [Обработка больших данных](5_data_storage/big_data_ru.md)
- [Подробное описание Kafka](5_data_storage/kafka_deep_dive_ru.md)
  
## 6 Отказоустойчивость, масштабируемость и observability
  
**Шаблоны отказоустойчивости**
- [Избыточность](6_fault_tolerance/redundancy_ru.md)
- [Ограничение скорости](6_fault_tolerance/rate_limiting_ru.md)
- [Circuit Breakers](6_fault_tolerance/circuit_breakers_ru.md)
- [Bulkheads](6_fault_tolerance/bulkheads_ru.md)
- [Шаблон Outbox](6_fault_tolerance/outbox_pattern_ru.md)
- [Оптимизация затрат](6_fault_tolerance/cost_optimization_ru.md)
  
**Мониторинг и эксплуатация**
- [Observability и SRE](6_fault_tolerance/observability_and_sre_ru.md)
  
## 7 Безопасность и защита данных
  
- [Аутентификация и авторизация](7_security_and_data_protection/auth_ru.md)
- [Защита облачных приложений](7_security_and_data_protection/securing_ru.md)
- [Защита данных в покое и при передаче](7_security_and_data_protection/securing_rest_transit_ru.md)
- [Комплаенс, аудиты и стандарты соответствия](7_security_and_data_protection/compliance_ru.md)
  
---
  
**English version:** [/en/intro](/en/intro)
