# Руководство по иерархии ресурсов AWS

Подробное руководство по концепциям Amazon Web Services, организованное по функциональным категориям с использованием современных диаграмм Mermaid.

## 🏗️ Базовая инфраструктура

Основные организационные и сетевые компоненты, лежащие в основе всех служб AWS.

Перед изучением услуг более высокого уровня необходимо понять базовую инфраструктуру AWS. Все в AWS работает в контексте учетных записей, регионов и зон доступности, образуя иерархическую структуру, которая обеспечивает как организационные границы, так и высокую доступность.

### Организационная иерархия

AWS Organizations обеспечивает основу для управления несколькими учетными записями и управления. Учетные записи AWS служат основной границей для выставления счетов и обеспечения безопасности, а Organizations позволяет осуществлять иерархическое управление с консолидированным выставлением счетов и наследованием политик. Организационные подразделения (OU) группируют учетные записи для целей управления, а политики контроля служб (SCP) обеспечивают ограничения, которые не могут быть превышены даже администраторами учетных записей.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "🏢 Организационная иерархия"
        Organization["🏢 AWS Organization&lt;br/>Управление несколькими учетными записями"]
        OU["📁 Организационная единица&lt;br/>Группировка учетных записей"]
        Account["🔑 Учетная запись AWS&lt;br/>Границы биллинга и безопасности"]
        SCP["📜 Политика контроля служб&lt;br/>Ограждающие механизмы на уровне учетной записи"]
        
        Organization -->|"содержит"| OU
        OU -->|"содержит"| Account
        SCP -.->|"применяет политики к"| Account
    end
    
    style Account fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style Organization fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style OU fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style SCP fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
```

### Региональная и сетевая инфраструктура

Региональная структура и структура зон доступности составляют основу архитектур с высокой доступностью. Регионы — это географически распределенные местоположения, содержащие несколько зон доступности (AZ), которые представляют собой изолированные центры обработки данных в пределах региона. Виртуальные частные облака (VPC) создают изолированные сетевые среды в пределах регионов, а подсети обеспечивают дальнейшее разделение между зонами доступности.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "🌍 Региональная и сетевая основа"
        
        subgraph "Глобальная инфраструктура"
            Region["🌍 Регион AWS&lt;br/>Географическое положение"]
            AZ1["🏢 Зона доступности A&lt;br/>Изолированный центр обработки данных"]
            AZ2["🏢 Зона доступности B&lt;br/>Изолированный центр обработки данных"]
            AZ3["🏢 Зона доступности C&lt;br/>Изолированный центр обработки данных"]
        end
        
        subgraph "Сетевая основа"
            VPC["🏠 VPC&lt;br/>Виртуальное частное облако"]
            PublicSubnet["🌐 Публичная подсеть&lt;br/>Доступ к Интернету"]
            PrivateSubnet["🔒 Частная подсеть&lt;br/>Только внутренний доступ"]
            IGW["🌉 Шлюз Интернета&lt;br/>Подключение VPC к Интернету"]
            RouteTable["🗺️ Таблица маршрутов&lt;br/>Правила маршрутизации трафика"]
        end
        
        Region -->|"содержит"| AZ1
        Region -->|"содержит"| AZ2
        Region -->|"содержит"| AZ3
        VPC -->|"охватывает"| Region
        PublicSubnet -->|"развернуто в"| AZ1
        PrivateSubnet -->|"развернуто в"| AZ2
        IGW -->|"подключено к"| VPC
        RouteTable -->|"управляет трафиком для"| PublicSubnet
        RouteTable -->|"управляет трафиком для"| PrivateSubnet
    end
    
    style Region fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style VPC fill:#e1f5fe,stroke:#0277bd,stroke-width:2px,color:#000
    style PublicSubnet fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
    style PrivateSubnet fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
    style IGW fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style AZ1 fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style AZ2 fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style AZ3 fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style RouteTable fill:#e0f7fa,stroke:#0097a7,stroke-width:2px,color:#000
```

## 🔐 Основы безопасности и идентификации

Основные функции безопасности и контроля доступа, которые регулируют все взаимодействия с ресурсами AWS.

Безопасность в AWS начинается с управления идентификацией и доступом (IAM), которое обеспечивает основу для аутентификации и авторизации всех служб AWS. Принцип минимальных прав реализуется с помощью иерархической системы разрешений, которая сочетает в себе политики на основе идентификации и ресурсов.

### Основы IAM

Пользователи IAM представляют собой отдельные идентичности с долгосрочными учетными данными, а роли IAM предоставляют временные идентичности, которые можно принимать на себя и которые предпочтительны для связи между службами. Группы упрощают управление разрешениями, позволяя привязывать политики к группам пользователей. Политики определяют разрешения с помощью документов JSON, которые можно привязывать к пользователям, группам или ролям.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "🔐 IAM Core"
        
        subgraph "Источники идентификации"
            Root["👑 Root User&lt;br/>Владелец учетной записи"]
            IAMUser["👤 Пользователь IAM&lt;br/>Индивидуальная идентичность"]
            IAMGroup["👥 Группа IAM&lt;br/>Коллекция пользователей"]
            IAMRole["🎭 Роль IAM&lt;br/>Принимаемая идентичность"]
        end
        
        subgraph "Определения разрешений"
            ManagedPolicy["📋 Управляемая политика&lt;br/>Повторно используемые разрешения"]
            InlinePolicy["📄 Встроенная политика&lt;br/>Прямое присоединение"]
            ResourcePolicy["🏷️ Политика ресурсов&lt;br/>Разрешения на основе ресурсов"]
        end
        
        subgraph "Защищенные ресурсы"
            S3Bucket["🪣 Корзина S3&lt;br/>Хранилище объектов"]
            EC2Instance["🖥️ Инстанс EC2&lt;br/>Вычислительный ресурс"]
        end
        
        Root -.->|"создает"| IAMUser
        IAMUser -->|"член"| IAMGroup
        ManagedPolicy -->|"присоединен к"| IAMUser
        ManagedPolicy -->|"присоединен к"| IAMGroup
        ManagedPolicy -->|"присоединен к"| IAMRole
        InlinePolicy -.->|"встроен в"| IAMRole
        ResourcePolicy -.->|"присоединен к"| S3Bucket
        IAMRole -.->|"предоставляет доступ к"| EC2Instance
        ResourcePolicy -.->|"контролирует доступ к"| S3Bucket
    end
    
    style IAMRole fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style ManagedPolicy fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style IAMUser fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
    style Root fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style S3Bucket fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style IAMGroup fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
    style InlinePolicy fill:#e0f7fa,stroke:#0097a7,stroke-width:2px,color:#000
    style ResourcePolicy fill:#fff8e1,stroke:#f57f17,stroke-width:2px,color:#000
    style EC2Instance fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
```

### Безопасность между учетными записями

Шаблоны доступа между учетными записями используют роли IAM для обеспечения безопасного доступа между разными учетными записями AWS без совместного использования долгосрочных учетных данных. Эта возможность необходима для архитектур с несколькими учетными записями и интеграции сторонних приложений при сохранении границ безопасности.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "🔗 Безопасность между учетными записями"
        
        subgraph "Учетная запись A"
            AccountA["🔑 Учетная запись AWS A&lt;br/>Источник учетной записи"]
            UserA["👤 Пользователь IAM A&lt;br/>Пользователь между учетными записями"]
        end
        
        subgraph "Учетная запись B"
            AccountB["🔑 AWS Account B&lt;br/>Целевая учетная запись"]
            CrossAccountRole["🎭 Межучетная роль&lt;br/>Может быть принята от учетной записи A"]
            TargetResource["🗄️ Целевой ресурс&lt;br/>Защищенный ресурс"]
        end
        
        subgraph "Механизм доступа"
            AssumeRole["🔄 Принять роль&lt;br/>Временные учетные данные"]
            TrustPolicy["🤝 Политика доверия&lt;br/>Кто может принимать роль"]
        end
        
        UserA -->|"принимает"| CrossAccountRole
        AssumeRole -.->|"позволяет"| CrossAccountRole
        TrustPolicy -.->|"определяет доверие для"| CrossAccountRole
        CrossAccountRole -->|"предоставляет доступ к"| TargetResource
        AccountA -.->|"доверяет"| AccountB
    end
    
    style UserA fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
    style CrossAccountRole fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style AssumeRole fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
    style TargetResource fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style AccountA fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style AccountB fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style TrustPolicy fill:#fff8e1,stroke:#f57f17,stroke-width:2px,color:#000
```

## 🖥️ Вычислительные и контейнерные сервисы

Основная вычислительная инфраструктура и развертывание контейнерных приложений.

Вычислительные услуги AWS образуют спектр от управления инфраструктурой до бессерверной абстракции. В основе лежит EC2, предоставляющий виртуальные машины с полным контролем над операционной системой и конфигурацией, а Lambda представляет противоположный край с событийно-ориентированным бессерверным выполнением. Между этими крайностями контейнерные службы, такие как ECS и Fargate, предлагают скоординированное развертывание без управления базовой инфраструктурой.

Иерархия вычислений демонстрирует многоуровневый подход AWS к абстракции. Инстансы EC2 могут размещать несколько контейнеров через ECS, или вы можете полностью исключить управление серверами с помощью Fargate. Группы автомасштабирования обеспечивают уровень надежности и масштабируемости, автоматически заменяя неисправные инстансы и регулируя мощность в зависимости от спроса. Балансировщики нагрузки приложений распределяют трафик между исправными инстансами, обеспечивая точку входа для ваших приложений.

Понимание этой иерархии помогает принимать архитектурные решения: используйте EC2, когда вам нужен полный контроль, ECS, когда вам нужна оркестрация контейнеров с видимостью инфраструктуры, Fargate, когда вы предпочитаете бессерверные контейнеры, и Lambda для событийных рабочих нагрузок. Каждый уровень обменивает контроль на простоту эксплуатации.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "🖥️ Вычислительные и контейнерные службы"
        
        subgraph "Балансировка нагрузки"
            ALB["⚖️ Application Load Balancer&lt;br/>Распределение HTTP/HTTPS трафика"]
            NLB["🌐 Network Load Balancer&lt;br/>Распределение TCP/UDP трафика"]
        end
        
        subgraph "Оркестрация контейнеров"
            ECSCluster["🐳 Кластер ECS&lt;br/>Оркестрация контейнеров"]
            ECSService["📋 Служба ECS&lt;br/>Управление определениями задач"]
            ECSTask["📦 Задача ECS&lt;br/>Единица выполнения контейнера"]
        end
        
        subgraph "Вычислительная инфраструктура"
            EC2["🖥️ Инстанс EC2&lt;br/>Виртуальная машина"]
            ASG["📈 Группа автомасштабирования&lt;br/>Масштабирование и работоспособность инстансов"]
            Fargate["☁️ Fargate&lt;br/>Бессерверные контейнеры"]
        end
        
        subgraph "Бессерверные вычисления"
            Lambda["⚡ Функция Lambda&lt;br/>Выполнение по событию"]
        end
        
        ALB -->|"направляет трафик на"| ECSService
        NLB -->|"направляет трафик на"| EC2
        ECSCluster -->|"управляет"| ECSService  
        ECSService -->|"запускает"| ECSTask
        ECSTask -->|"запускается на"| EC2
        ECSTask -->|"запускается на"| Fargate
        ASG -->|"управляет жизненным циклом"| EC2
        ALB -->|"может запускать"| Lambda
    end
    
    style EC2 fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style ECSTask fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style ECSService fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style ECSCluster fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
    style ALB fill:#e3f2fd,stroke:#1565c0,stroke-width:2px,color:#000
    style ASG fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
    style Fargate fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style Lambda fill:#fff8e1,stroke:#f57f17,stroke-width:2px,color:#000
```

## 🌐 Сеть и доставка контента

Виртуальная частная облачная инфраструктура и глобальная доставка контента.

Сеть AWS работает как на глобальном, так и на региональном уровне, предоставляя комплексные решения для подключения и доставки контента. Понимание разницы между глобальными службами и инфраструктурой VPC имеет решающее значение для разработки масштабируемых и безопасных приложений.

### Глобальные сети

Route 53 предоставляет службы DNS с функциями проверки работоспособности и маршрутизации трафика, а CloudFront — глобальную доставку контента с кэшированием на границе сети. Вместе они обеспечивают низкую задержку и высокую доступность приложений, которые могут эффективно обслуживать глобальную аудиторию.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "🌍 Глобальная сеть"
        
        subgraph "DNS и управление трафиком"
            Route53["🌍 Route 53&lt;br/>DNS и маршрутизация трафика"]
            HealthChecks["❤️ Проверка работоспособности&lt;br/>Мониторинг конечных точек"]
        end
        
        subgraph "Распределение контента"
            CloudFront["🚀 CloudFront&lt;br/>Глобальная CDN"]
            EdgeLocations["🌐 Расположение пограничных устройств&lt;br/>Кэшированный контент"]
        end
        
        subgraph "Источники происхождения"
            S3Origin["🪣 S3 Bucket&lt;br/>Источник статического контента"]
            ALBOrigin["⚖️ Application Load Balancer&lt;br/>Источник динамического контента"]
        end
        
        Route53 -->|"разрешает в"| CloudFront
        HealthChecks -.->|"мониторит"| ALBOrigin
        Route53 -->|"использует"| HealthChecks
        CloudFront -->|"кэширует в"| EdgeLocations
        CloudFront -->|"получает контент из"| S3Origin
        CloudFront -->|"получает контент из"| ALBOrigin
    end
    
    style Route53 fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style CloudFront fill:#fff8e1,stroke:#f57f17,stroke-width:2px,color:#000
    style EdgeLocations fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
    style S3Origin fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style ALBOrigin fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style HealthChecks fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
```

### Сеть VPC

Сеть AWS основана на виртуальном частном облаке (VPC), которое обеспечивает изолированные сетевые среды в регионах AWS. Безопасность обеспечивается многоуровневым контролем, а подключение к Интернету осуществляется по определенным схемам для общедоступных и частных ресурсов.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "🏠 Сеть VPC"
        
        subgraph "Инфраструктура VPC"
            VPC["🏢 VPC&lt;br/>Виртуальное частное облако"]
            PublicSubnet["🌐 Общедоступная подсеть&lt;br/>Доступ к Интернету"]
            PrivateSubnet["🔒 Частная подсеть&lt;br/>Только для внутреннего использования"]
        end
        
        subgraph "Подключение к Интернету"
            IGW["🌉 Шлюз Интернета&lt;br/>Доступ к Интернету VPC"]
            NAT["🔄 Шлюз NAT&lt;br/>Исходящий доступ к Интернету"]
        end
        
        subgraph "Средства контроля безопасности"
            NACL["🛡️ Сетевой ACL&lt;br/>Брандмауэр на уровне подсети"]
            SecurityGroup["🔥 Группа безопасности&lt;br/>Брандмауэр на уровне экземпляра"]
        end
        
        subgraph "Вычислительные ресурсы"
            EC2Instance["🖥️ Инстанс EC2&lt;br/>Ресурс общедоступной подсети"]
            RDSInstance["🗄️ Инстанс RDS&lt;br/>Ресурс частной подсети"]
        end
        
        VPC -->|"содержит"| PublicSubnet
        VPC -->|"содержит"| PrivateSubnet
        IGW -->|"подключено к"| VPC
        IGW -->|"обеспечивает доступ к Интернету"| PublicSubnet
        NAT -->|"развернуто в"| PublicSubnet
        NAT -->|"позволяет исходящий доступ из"| PrivateSubnet
        NACL -.->|"контролирует трафик подсети для"| PublicSubnet
        NACL -.->|"контролирует трафик подсети для"| PrivateSubnet
        SecurityGroup -.->|"контролирует трафик экземпляра для"| EC2Instance
        SecurityGroup -.->|"контролирует трафик экземпляра для"| RDSInstance
        PublicSubnet -->|"хостит"| EC2Instance
        PrivateSubnet -->|"хостит"| RDSInstance
    end
    
    style VPC fill:#e1f5fe,stroke:#0277bd,stroke-width:2px,color:#000
    style PublicSubnet fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
    style PrivateSubnet fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
    style SecurityGroup fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style EC2Instance fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style IGW fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style NAT fill:#fff8e1,stroke:#f57f17,stroke-width:2px,color:#000
    style NACL fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style RDSInstance fill:#e0f7fa,stroke:#0097a7,stroke-width:2px,color:#000
```

## 💾 Хранение и база данных

Решения для постоянного хранения и управляемые службы баз данных.

Службы хранения AWS решают различные задачи с помощью специализированных решений. S3 предоставляет практически неограниченное хранилище объектов с несколькими классами хранения, оптимизированными для различных моделей доступа и требований к стоимости. EBS предлагает блочное хранилище для экземпляров EC2 с различными характеристиками производительности, от универсальных до типов хранилищ с высоким IOPS.

Уровень базы данных охватывает как реляционные, так и NoSQL-решения. RDS предоставляет управляемые реляционные базы данных с автоматизированным резервным копированием, исправлением и возможностью масштабирования. DynamoDB предлагает бессерверную NoSQL с автоматическим масштабированием и возможностью глобального распределения. ElastiCache обеспечивает кэширование в памяти для повышения производительности приложений.

При выборе иерархии хранения необходимо учитывать такие факторы, как долговечность, доступность и производительность. S3 обеспечивает долговечность на уровне 99,99999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "💾 Хранение и базы данных"
        
        subgraph "Объектное хранение"
            S3["🪣 S3 Bucket&lt;br/>Объектное хранение"]
            S3Classes["📊 Классы хранения&lt;br/>Стандартный, IA, Glacier"]
        end
        
        subgraph "Блочное хранение"
            EBS["💾 EBS Volume&lt;br/>Блочное хранение"]
            EBSTypes["⚡ Типы томов&lt;br/>gp3, io2, st1"]
        end
        
        subgraph "Управляемые базы данных"
            RDS["🗄️ Инстанс RDS&lt;br/>Реляционная база данных"]
            DynamoDB["⚡ DynamoDB&lt;br/>NoSQL-база данных"]
            ElastiCache["🚀 ElastiCache&lt;br/>Кэш в памяти"]
        end
        
        subgraph "Вычислительные ресурсы"
            Application["📱 Приложение&lt;br/>Работает на EC2/Fargate"]
        end
        
        S3 -->|"настроен с помощью"| S3Classes
        EBS -->|"настроен с помощью"| EBSTypes
        Application -->|"чтение/запись объектов"| S3
        Application -->|"монтирует тома"| EBS
        Application -->|"запросы"| RDS
        Application -->|"чтение/запись"| DynamoDB
        Application -->|"кэширует данные в"| ElastiCache
        RDS -.->|"автоматическое резервное копирование в"| S3
        ElastiCache -.->|"ускоряет доступ к"| RDS
        ElastiCache -.->|"ускоряет доступ к"| DynamoDB
    end
    
    style S3 fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style EBS fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style RDS fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style DynamoDB fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style ElastiCache fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
    style Application fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
```


## ⚙️ Управление и администрирование

Инфраструктура как код, организация ресурсов и операционное управление.

Службы управления AWS обеспечивают инфраструктуру как код и организационное управление в больших масштабах. CloudFormation обеспечивает декларативное предоставление инфраструктуры с помощью шаблонов, которые определяют ресурсы и их взаимосвязи. Это позволяет осуществлять развертывание инфраструктуры с контролем версий, повторяемостью, возможностью отката и обнаружением изменений.

AWS Organizations обеспечивает иерархическое управление учетными записями с консолидированным биллингом и наследованием политик. Политики контроля служб (SCP) позволяют осуществлять управление на уровне всей организации, устанавливая границы разрешений, которые не могут быть превышены даже администраторами отдельных учетных записей.

Systems Manager предлагает возможности операционного управления, включая управление исправлениями, соответствие конфигурации и безопасный доступ к экземплярам через Session Manager. Parameter Store обеспечивает безопасное управление конфигурацией с интеграцией в другие службы AWS.

Иерархия управления проходит от организационной структуры через определение инфраструктуры до операционного управления. Это обеспечивает управление на уровне предприятия при сохранении автономии команды разработчиков в пределах установленных границ.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "⚙️ Управление и администрирование"
        
        subgraph "Организационная структура"
            Organization["🏢 AWS Organization&lt;br/>Управление учетными записями"]
            OU["📁 Организационная единица&lt;br/>Группировка учетных записей"]
            Account["🔑 Учетная запись AWS&lt;br/>Биллинг и границы ресурсов"]
        end
        
        subgraph "Инфраструктура как код"
            CloudFormation["📋 CloudFormation&lt;br/>Шаблоны инфраструктуры"]
            Stack["📚 Стек&lt;br/>Коллекция ресурсов"]
            Template["📄 Шаблон&lt;br/>Определения ресурсов"]
        end
        
        subgraph "Управление конфигурацией"
            SystemsManager["⚙️ Systems Manager&lt;br/>Операционное управление"]
            ParameterStore["🗄️ Хранилище параметров&lt;br/>Хранение конфигурации"]
            SessionManager["🖥️ Session Manager&lt;br/>Безопасный доступ к оболочке"]
        end
        
        subgraph "Политика и соответствие"
            SCP["📜 Политика контроля служб&lt;br/>Границы разрешений"]
            Config["📊 AWS Config&lt;br/>Соответствие конфигурации"]
        end
        
        subgraph "Управляемые ресурсы"
            EC2Managed["🖥️ Инстанс EC2&lt;br/>Управляемый ресурс"]
            S3Managed["🪣 S3 Bucket&lt;br/>Управляемый ресурс"]
        end
        
        Organization -->|"содержит"| OU
        OU -->|"содержит"| Account
        SCP -.->|"применяется к"| Account
        CloudFormation -->|"создает"| Stack
        Template -->|"определяет"| Stack
        Stack -->|"провизионирует"| EC2Managed
        Stack -->|"провизионирует"| S3Managed
        SystemsManager -->|"управляет"| EC2Managed
        ParameterStore -.->|"предоставляет конфигурацию"| EC2Managed
        SessionManager -.->|"предоставляет доступ"| EC2Managed
        Config -.->|"контролирует соответствие"| S3Managed
    end
    
    style Account fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style Stack fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style CloudFormation fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
    style SystemsManager fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style EC2Managed fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style Organization fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
```

## 📊 Наблюдаемость и аналитика

Мониторинг, ведение журналов и аналитика производительности приложений.

Наблюдаемость AWS объединяет native-сервисы со сторонними решениями, такими как DataDog, для комплексного мониторинга приложений и инфраструктуры. CloudWatch служит центральным хранилищем метрик и журналов, собирая данные из сервисов AWS и пользовательских приложений. CloudWatch Logs обеспечивает централизованную агрегацию журналов с возможностью запросов и автоматизированными политиками хранения.

X-Ray предоставляет возможности распределенного трассирования, отслеживая запросы в микросервисных архитектурах для выявления узких мест и ошибок. Интеграция между метриками CloudWatch, журналами и трассировками X-Ray позволяет проводить корреляционный анализ для устранения неполадок в сложных распределенных системах.

DataDog расширяет возможности наблюдаемости AWS за счет расширенных функций аналитики, оповещения и панелей мониторинга. Агент DataDog собирает метрики как из служб AWS, так и из приложений, обеспечивая единую наблюдаемость в гибридных и мультиоблачных средах. Эта интеграция позволяет реализовывать сложные стратегии мониторинга, охватывающие инфраструктуру, приложения и бизнес-метрики.

Иерархия наблюдаемости проходит от сбора данных через обработку до анализа и оповещения. Это позволяет реализовывать проактивные стратегии мониторинга, которые могут предотвратить проблемы до того, как они повлияют на пользователей, одновременно предоставляя информацию, необходимую для непрерывной оптимизации.

``` mermaid
%%{init: {'theme':'base', 'themeVariables': { 'primaryTextColor': '#000', 'fontSize': '11px'}}}%%
flowchart TD
    subgraph "📊 Наблюдаемость и аналитика"
        
        subgraph "Источники приложений"
            EC2App["🖥️ Приложение EC2&lt;br/>Пользовательские метрики и журналы"]
            LambdaApp["⚡ Функция Lambda&lt;br/>Метрики и журналы выполнения"]
            ECSApp["🐳 Задача ECS&lt;br/>Метрики и журналы контейнера"]
        end
        
        subgraph "Нативный мониторинг AWS"
            CloudWatch["☁️ CloudWatch&lt;br/>Метрики и оповещения"]
            CloudWatchLogs["📜 Журналы CloudWatch&lt;br/>Агрегация журналов"]
            XRay["🔍 X-Ray&lt;br/>Распределенное отслеживание"]
        end
        
        subgraph "Наблюдаемость сторонних решений"
            DataDogAgent["🐕 DataDog Agent&lt;br/>Унифицированный сбор метрик"]
            DataDogCloud["☁️ DataDog Cloud&lt;br/>Аналитика и панели мониторинга"]
        end
        
        subgraph "Оповещения и автоматизация"
            SNS["📢 SNS&lt;br/>Доставка уведомлений"]
            Lambda["⚡ Lambda&lt;br/>Автоматический ответ"]
        end
        
        EC2App -.->|"отправляет метрики в"| CloudWatch
        EC2App -.->|"отправляет журналы в"| CloudWatchLogs
        EC2App -.->|"отправляет трассировки в"| XRay
        EC2App -.->|"мониторинг осуществляется"| DataDogAgent
        LambdaApp -.->|"автоматические метрики в"| CloudWatch
        ECSApp -.->|"метрики контейнера в"| CloudWatch
        DataDogAgent -->|"потоки в"| DataDogCloud
        CloudWatch -->|"триггеры"| SNS
        SNS -->|"вызывает"| Lambda
        XRay -.->|"интегрируется с"| DataDogCloud
        CloudWatch -.->|"интегрируется с"| DataDogCloud
    end
    
    style EC2App fill:#e8f4fd,stroke:#1976d2,stroke-width:2px,color:#000
    style CloudWatch fill:#fff3e0,stroke:#f57c00,stroke-width:2px,color:#000
    style DataDogAgent fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px,color:#000
    style DataDogCloud fill:#e0f2f1,stroke:#00796b,stroke-width:2px,color:#000
    style XRay fill:#fce4ec,stroke:#c2185b,stroke-width:2px,color:#000
    style SNS fill:#e8f5e8,stroke:#388e3c,stroke-width:2px,color:#000
```

## Ключевые взаимосвязи

На приведенных выше диаграммах показано, как ресурсы AWS в каждой категории связаны друг с другом. Ниже приведены некоторые важные межкатегорийные взаимосвязи:

- **Вычислительные** службы работают в VPC **сетей** и используют ресурсы **хранения** для обеспечения постоянства
- **Политики и средства контроля безопасности** применяются ко всем категориям служб, а IAM обеспечивает основу для аутентификации
- **Службы управления**, такие как CloudFormation, предоставляют ресурсы во всех категориях с использованием инфраструктуры как кода
- Инструменты **наблюдаемости** отслеживают и собирают данные из ресурсов всех категорий служб.
- Службы **хранения** интегрированы со службами **безопасности** для шифрования и контроля доступа.
- **Сеть** обеспечивает основу для подключения, которая позволяет службам **вычислений** безопасно обмениваться данными.

Эта классификация помогает разработчикам понять, как службы AWS взаимодействуют друг с другом для создания безопасных, масштабируемых и наблюдаемых облачных приложений, сохраняя при этом операционную эффективность за счет автоматизации и управления.
