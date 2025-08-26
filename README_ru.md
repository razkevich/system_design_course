# Системное Проектирование для Cloud-Native SaaS Систем

> *Полное руководство по проектированию, созданию и масштабированию современных распределенных систем*

Добро пожаловать в ваше путешествие через сложный мир системного дизайна! Этот курс проведет вас от основополагающих концепций до продвинутых паттернов, используемых самыми масштабируемыми SaaS платформами мира. Независимо от того, готовитесь ли вы к собеседованиям по системному дизайну или создаете следующее поколение cloud-native приложений, это руководство предоставляет знания и паттерны, которые вам необходимы.

---

## 1 Основы Архитектуры и Системного Проектирования

**Основополагающие Концепции**
- [Что такое Архитектура и Системное Проектирование?](1_architecture_basics/what_is_architecture_system_design_ru.md)
- [Архитектурные Представления](1_architecture_basics/architectural_views_ru.md)

**Основные Принципы**
- [Декомпозиция и Границы](1_architecture_basics/decomposition_boundaries_ru.md)
- [Компромиссы в Программной Архитектуре](1_architecture_basics/architecture_tradeoffs_ru.md)
- [Эволюция и Управление Изменениями](1_architecture_basics/evolution_change_management_ru.md)
- [Сбор Требований](1_architecture_basics/requirements_ru.md)
- [Атрибуты Качества и Ограничения](1_architecture_basics/quality_attributes_constraints_ru.md)
- [Паттерны Коммуникации](1_architecture_basics/communication_patterns_ru.md)

## 2 Современные Архитектурные Стили и Паттерны

**Domain-Driven Design**
- [DDD (Предметно-ориентированное Проектирование)](2_architectural_patterns/domain_driven_design_ru.md)
- [Тактический DDD](2_architectural_patterns/tactical_ddd_ru.md)
- [Стратегический DDD](2_architectural_patterns/strategic_ddd_ru.md)

**Архитектурные Стили**
- [Обзор Современных Архитектурных Стилей](2_architectural_patterns/modern_architectural_styles_ru.md)
- [Модульные Монолиты](2_architectural_patterns/modular_monoliths_ru.md)
- [Микросервисы](2_architectural_patterns/microservices_ru.md)
- [Event-Driven Архитектура, CQRS и Саги](2_architectural_patterns/eda_ru.md)
- [Реактивное Программирование](2_architectural_patterns/reactive_ru.md)
- [Serverless](2_architectural_patterns/serverless_ru.md)
- [Мультитенантность](2_architectural_patterns/multitenancy_ru.md)

## 3 Сетевое Взаимодействие и Коммуникация

- [Паттерны API Архитектуры](3_network_and_communication/api_architecture_ru.md)
- [Протоколы и Модель OSI](3_network_and_communication/protocols_osi_model_ru.md)
- [Ключевые Сетевые Компоненты](3_network_and_communication/network_components_ru.md)
- [Service Mesh](3_network_and_communication/service_meshes_ru.md)
- [Сетевые Технологии в AWS](3_network_and_communication/network_aws_ru.md)

## 4 Основы Распределенных Систем

**Основные Концепции**
- [Обзор Распределенных Систем](4_distributed_systems/overview_ru.md)
- [Шардинг и Репликация](4_distributed_systems/sharding_replication_ru.md)
- [CAP Теорема](4_distributed_systems/cap_ru.md)
- [Стратегии Партицирования и Репликации](4_distributed_systems/DBs_ru.md)

**Координация и Инфраструктура**
- [Распределенный Консенсус](4_distributed_systems/consensus_ru.md)
- [Распределенная Координация и Блокировки](4_distributed_systems/Locks_ru.md)
- [Иерархия Ресурсов AWS](4_distributed_systems/aws_resource_hierarchy_guide_ru.md)
- [Архитектура Данных, Пайплайны и ETL](5_data_storage/data_architecture_ru.md)

**Kubernetes и Оркестрация Контейнеров**
- [Обзор Kubernetes](4_distributed_systems/kubernetes_architecture_ru.md)
- [Иерархия Ресурсов Kubernetes](4_distributed_systems/kubernetes_resource_hierarchy_guide_ru.md)
- [Сетевые Технологии Kubernetes](4_distributed_systems/kubernetes_networking_ru.md)

## 5 Хранение и Обработка Данных

**Проектирование Баз Данных**
- [Масштабируемость и Моделирование Данных в Базах Данных](5_data_storage/scalability_db_ru.md)
- [Компромиссы ACID vs BASE](5_data_storage/acid_base_ru.md)
- [Уровни Изоляции Транзакций](5_data_storage/isolation_levels_ru.md)

**Обмен Сообщениями и Обработка**
- [Распределенный Поиск](5_data_storage/distributed_search_ru.md)
- [Системы Очередей Сообщений](5_data_storage/message_brokers_ru.md)
- [Семантика Exactly-Once](5_data_storage/exactly_once_ru.md)
- [Обработка Больших Данных](5_data_storage/big_data_ru.md)
- [Глубокое Погружение в Kafka](5_data_storage/kafka_deep_dive_ru.md)

## 6 Отказоустойчивость, Масштабируемость и Наблюдаемость

**Паттерны Устойчивости**
- [Избыточность](6_fault_tolerance/redundancy_ru.md)
- [Ограничение Скорости](6_fault_tolerance/rate_limiting_ru.md)
- [Circuit Breaker](6_fault_tolerance/circuit_breakers_ru.md)
- [Bulkhead](6_fault_tolerance/bulkheads_ru.md)
- [Паттерн Outbox](6_fault_tolerance/outbox_pattern_ru.md)
- [Кэширование](6_fault_tolerance/cache_ru.md)
- [Оптимизация Затрат](6_fault_tolerance/cost_optimization_ru.md)

**Мониторинг и Операции**
- [Наблюдаемость и SRE](6_fault_tolerance/observability_and_sre_ru.md)

## 7 Безопасность и Защита Данных

- [Аутентификация и Авторизация](7_security_and_data_protection/auth_ru.md)
- [Защита cloud-native приложений](7_security_and_data_protection/securing_ru.md)
- [Защита Данных в Покое и в Движении](7_security_and_data_protection/securing_rest_transit_ru.md)
- [Фреймворки Комплаенса, Аудит и Стандарты](7_security_and_data_protection/compliance_ru.md)

---

**English version:** [README.md](README.md)