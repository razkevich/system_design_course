# Requirements Engineering: From Business Vision to Technical Reality

Understanding what to build is often more challenging than building it. Requirements engineering transforms abstract business ideas into concrete specifications that guide development teams toward creating software that truly serves its intended purpose.

Yet requirements gathering remains frustrating for many teams. The pressure to start development before requirements are fully understood often results in systems that fail to meet stakeholder expectations or create long-term technical debt.

Requirements engineering involves discovering and managing three distinct types of requirements: functional requirements (what the system does), non-functional requirements (how well it performs), and constraints (what limits design options). Each requires different discovery techniques and stakeholder engagement strategies.

## Discovering Functional Requirements: What Should the System Do?

Functional requirements describe the specific behaviors, features, and capabilities that deliver business value. While they seem straightforward—"the system should allow users to search for products"—the devil lives in the details. Effective functional requirements discovery goes beyond collecting feature lists to understand the underlying business processes, user workflows, and system interactions that make features meaningful.

### The Feature-Advantage-Benefit Framework

One of the most effective approaches for discovering functional requirements is the Feature-Advantage-Benefit (FAB) framework. This methodology helps bridge the communication gap between business and technical stakeholders by examining requirements from three perspectives:

- **Features** represent what the system can do—the inherent product characteristics
- **Advantages** describe what users achieve when using those features  
- **Benefits** explain why users would want those capabilities

For example, in a mobile payment system, biometric authentication is a feature. The advantage is eliminating the need for PIN entry, while the benefits include faster transactions and improved security. This framework ensures requirements capture both technical capabilities and business value, preventing teams from building features that work perfectly but solve the wrong problems.

### Event Storming for Process Discovery

Event Storming provides an agile, interactive approach to discovering business processes and the functional requirements that support them. This collaborative workshop technique brings together diverse stakeholders—business experts, developers, designers, and domain specialists—to map out complex business flows using simple colored sticky notes.

The process focuses on domain events—things that happen in the business that matter to stakeholders. Starting with an event like "payment completed," participants work backward and forward to understand what triggers events, who initiates them, what systems are involved, and what happens next. This visual mapping reveals not just individual functional requirements but their relationships and dependencies.

The beauty of Event Storming lies in its ability to surface implicit knowledge. Business experts often understand processes intuitively but struggle to articulate them completely. Developers see technical possibilities but may miss business nuances. Event Storming creates a shared language that helps both groups discover functional requirements they didn't know existed.

### The Lean Canvas for Strategic Context

While Event Storming excels at process-level functional requirements, the Lean Canvas provides crucial strategic context that shapes requirement priorities. This one-page business model template addresses nine key aspects: problems solved, customer segments, unique value proposition, solution approach, channels, revenue streams, cost structure, key metrics, and competitive advantages.

The Lean Canvas helps teams understand not just what functional requirements to build, but why they matter and in what order. It reveals which features are essential for the core value proposition versus nice-to-have enhancements. This strategic context prevents teams from treating all functional requirements as equally important, enabling better prioritization and resource allocation.

### Identifying Influential Functional Requirements

Not all functional requirements are created equal from an architectural perspective. While all functional requirements are essential for system success, only some have architectural significance. These "influential functional requirements" or "architecture killers" force fundamental architectural decisions that affect the entire system.

The key is identifying functional requirements that introduce new architectural complexity. A simple user login feature might be straightforward, but "users can review their action history even if they've lost their phone" suddenly introduces requirements for remote storage, data synchronization, offline capabilities, and cross-device security. One seemingly innocent functional requirement can completely reshape system architecture.

When gathering functional requirements, pay special attention to those that:
- Require integration with external systems
- Involve real-time or near-real-time processing
- Handle sensitive data or require special security measures
- Must work across multiple platforms or devices
- Need to scale to significantly higher volumes than other features

### Practical Discovery Techniques

**User Story Mapping** helps teams understand functional requirements in the context of user journeys. By mapping user activities from left to right and breaking them down into specific tasks, teams can identify missing functional requirements and understand how features connect to create complete user experiences.

**Questionnaires and Structured Interviews** work well for capturing detailed functional requirements once the broader scope is understood. The key is asking open-ended questions that reveal not just what users want to do, but why they want to do it and how they currently work around limitations.

**Mockups and Prototypes** make abstract functional requirements concrete. A simple prototype can reveal dozens of implicit functional requirements that stakeholders assumed were obvious but never articulated. Interactive mockups also help validate that proposed functional requirements actually solve the intended problems.

## Uncovering Quality Attributes: How Well Should It Work?

Non-functional requirements—also called quality attributes—define how well the system should perform its functions. Unlike functional requirements that can often be added incrementally, non-functional requirements typically require architectural foundations that must be designed from the beginning. They're often the difference between a system that works in demos and one that works in production.

The challenge with non-functional requirements is that they're often invisible until violated. Users don't think about response times until pages load slowly, don't consider availability until the system is down, don't worry about security until data is breached. This invisibility makes them easy to overlook during requirements gathering, with painful consequences later.

### Quality Attribute Scenarios: Making the Invisible Visible

Quality attribute scenarios provide a structured way to make non-functional requirements explicit and testable. "Scalability" and "performance" are just words until we define specific, measurable scenarios that describe expected system behavior.

A complete quality attribute scenario consists of six parts:
- **Source**: Who or what initiates the scenario
- **Stimulus**: The event requiring system response  
- **Artifact**: The system component being tested
- **Environment**: The operational context
- **Response**: The expected system behavior
- **Response Measure**: Specific, measurable success criteria

For example: "When 1000 concurrent users (source) submit search queries (stimulus) during peak traffic load (environment), the search service (artifact) returns results within 500ms for 95% of requests (response and response measure)."

Good scenarios are specific, measurable, and testable. If you can't write a test for your scenario, it's not specific enough to guide architectural decisions.

### The Quality Attribute Workshop (QAW)

The Quality Attribute Workshop provides a structured method for identifying and prioritizing non-functional requirements early in development. Unlike traditional requirements gathering focused on functional features, QAW specifically targets quality attributes through collaborative scenario-based analysis.

The workshop process includes several key phases:

**Business Presentation** establishes context and goals, helping technical teams understand why quality attributes matter to the business. This isn't just about technical performance—it's about user experience, operational costs, and business success.

**Architecture Presentation** gives stakeholders context about current or proposed system design, helping them understand the technical implications of quality attribute decisions.

**Scenario Brainstorming** generates quality attribute scenarios from all participants. Business stakeholders contribute scenarios based on user expectations and business needs. Technical team members add scenarios based on operational concerns and system constraints.

**Scenario Consolidation** eliminates duplication and groups related scenarios, creating a manageable set of distinct quality concerns.

**Prioritization** reveals which quality attributes matter most to different stakeholders, often surfacing conflicts that need explicit resolution.

**Refinement** develops high-priority scenarios into complete, testable specifications using the six-part scenario format.

The QAW's power lies in making implicit quality expectations explicit before they become architectural constraints. It's much easier to design for specific performance targets than to retrofit performance into an existing system.

### Site Reliability Engineering (SRE) Approaches

Site Reliability Engineering provides practical frameworks for measuring and managing quality attributes in production systems. The SRE approach bridges development and operations by applying engineering principles to reliability challenges.

**Service Level Indicators (SLIs)** are specific, measurable metrics reflecting service health from the user's perspective—95th percentile request latency for performance, ratio of successful requests for availability.

**Service Level Objectives (SLOs)** set specific targets for SLIs over defined time periods, such as "99.9% of requests complete within 500ms over a rolling 28-day window."

**Error Budgets** quantify acceptable unreliability within SLO constraints. A 99.9% availability SLO means a 0.1% error budget—roughly 43 minutes of downtime per month—balancing reliability against feature development velocity.

### Discovery Techniques for Quality Attributes

**Goal-Question-Metric (GQM) Workshops** connect business goals with measurable quality attributes. Starting with business objectives, teams work backward to identify questions that indicate goal achievement and metrics that answer those questions. This ensures quality attributes align with actual business needs rather than technical assumptions.

**Stakeholder Interviews** work especially well for uncovering quality attribute concerns. Different stakeholders care about different quality attributes—end users focus on performance and usability, operations teams worry about reliability and maintainability, executives care about cost and compliance. Structured interviews help surface these diverse perspectives.

**Architecture Risk Analysis** examines proposed or existing architectures for quality attribute risks. This technique helps identify where architectural decisions might impact quality attributes, revealing non-functional requirements that need explicit attention.

### Understanding Quality Attribute Trade-offs

Quality attributes rarely align perfectly—security measures add latency, high availability requires redundancy and complexity, scalable architectures might sacrifice consistency. The most successful systems optimize the right quality attributes for their specific context rather than trying to maximize everything.

## Conclusion: Building the Right Thing, The Right Way

Requirements engineering is the foundation of successful software systems. The three types of requirements—functional, quality attributes, and constraints—work together to define what needs to be built, how well it should perform, and what boundaries shape the solution.

Each requirement type demands different discovery approaches: collaborative workshops for functional requirements, structured scenarios for quality attributes, and systematic identification for constraints. The goal isn't perfect requirements but shared understanding between business and technical stakeholders.

Requirements evolve as systems mature and business contexts change. The most successful systems are built on processes that embrace this evolution while maintaining focus on delivering real business value. When done well, requirements engineering doesn't just prevent failure—it creates the foundation for exceptional success.