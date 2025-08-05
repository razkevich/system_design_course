# Understanding the Domain of DDD: A Strategic and Tactical Design Mental Map

Let's get our head around the _Domain of DDD_. I've always found it to be a valuable concept that offers a systematic approach to analyzing business problems and modeling solutions in software. However, I've consistently struggled with the top books on DDD (such as Eric Evans's "Domain-Driven Design: Tackling Complexity in the Heart of Software" or Vaughn Vernon's **"Implementing Domain-Driven Design"**). The multitude of notions and concepts feels overwhelming, and what's missing is a disambiguation section that brings all these terms together to "set the stage" for deeper discussion.

So I invested some effort in building a mental map of these concepts, and I'm satisfied with the result. DDD is largely split into two parts: strategic design and tactical design. Strategic design focuses on the real-world problem (the Domain) and how we model a software solution to address it. Tactical design focuses on the implementation patterns and building blocks within bounded contexts.

**Key insight**: Strategic DDD's purpose is to discover the *boundaries* between contexts and manage the *relationships* between them, while tactical DDD defines what goes *inside* each bounded context. Strategic design answers: Where should context boundaries be? How should different contexts integrate? Tactical design answers: How do we implement rich domain models within each context?

Let me walk through both to show how they complement each other.

> Of course, the article presents a somewhat idealized view of the process. In practice, the boundary between problem and solution spaces can be blurrier, and strategic decisions are often more constrained by existing systems and organizational realities.

## Strategic Design: The Big Picture

There are two fundamental "spaces" in strategic design:

- **Problem space** - The business domain as it exists in reality, independent of any software solution. It's about understanding what needs to be solved.
- **Solution space** - Where we design our software architecture and boundaries to address the problem space challenges.

### Problem Space Contains:

- **Domain** - The overall subject area or business you're working in
- **Subdomains** - Logical divisions of the domain based on business capabilities
    - **Core Domain** - Key differentiating capabilities unique to your business
    - **Supporting Subdomains** - Necessary but not differentiating capabilities
    - **Generic Subdomains** - Cross-cutting concerns important to understand the problem but not unique to it

### Solution Space Contains:

- **Bounded Context** - Software boundary within which a domain model is defined
- **Context Map** - Visual representation of bounded context relationships and integration patterns
- **Integration patterns** - How bounded contexts communicate (Shared Kernel, Customer-Supplier, Anticorruption Layer, etc.)

### Notions Shared Between Problem and Solution Space:

- **Ubiquitous Language** - Shared vocabulary that emerges from business conversations but becomes the implementation language
- **Domain Model** - Understanding of business concepts that becomes software abstractions
- **Domain boundaries** - Natural business divisions that inform software boundaries

## Tactical Design: The Building Blocks

While strategic design gives us the big picture, tactical design provides the concrete patterns and building blocks we use to implement our domain model within each bounded context. Unlike strategic design which spans both problem and solution spaces, tactical design operates mostly within the solution space, focusing on how we structure our code to reflect business concepts clearly and maintainably.

### Solution Space Contains:

#### Core Building Blocks:

- **Entities** - Objects with a distinct identity that persists over time (e.g., a Customer with a unique ID)
- **Value Objects** - Objects defined by their attributes rather than identity (e.g., an Address or Money amount)
- **Aggregates** - Clusters of entities and value objects treated as a single unit for data changes
- **Aggregate Root** - The only entity within an aggregate that external objects can reference directly
- **Domain Services** - Operations that don't naturally belong to any entity or value object
- **Repositories** - Abstractions for accessing and storing aggregates
- **Factories** - Encapsulate the logic of creating complex objects or aggregates

#### Behavioral Patterns:

- **Domain Events** - Something significant that happened in the domain that other parts of the system care about
- **Application Services** - Coordinate domain objects to fulfill use cases, but contain no business logic themselves
- **Specifications** - Encapsulate business rules that can be combined and reused

### Notions Shared Between Problem and Solution Space:

- **Business Rules** - The constraints and logic that exist in the real world and must be enforced in code
- **Domain Concepts** - The fundamental ideas and processes from the business domain that tactical patterns help implement
- **Domain Invariants** - Conditions that must always be true within the domain, enforced through aggregates and other patterns

## How It All Fits Together

Everything starts with the problem space, where we analyze the challenge we want to solve through software. In many cases, this maps to real-world scenarios (like selling goods online in e-commerce), though the definition of "real world" can be somewhat fluid.

The problem space centers around the Domain, which contains multiple subdomains. For example, an e-commerce domain might consist of a Product Recommendations core subdomain, an Order Processing supporting subdomain, and a User Authentication generic subdomain. The core subdomain represents your key differentiating capabilities—what makes your business unique. Supporting subdomains are necessary but don't differentiate you from competitors, while generic subdomains reflect cross-cutting concerns that are important for understanding the problem but aren't unique to your business.

This defines the Problem space: our reflection of the real world before we consider any solution or software implementation.

The solution space primarily contains bounded contexts, which define software boundaries as distinct entities and outline the relationships and integration patterns between them. Here's an important insight: integration patterns live in the solution space, but they're informed by relationships that exist in the problem space. If two subdomains have a natural dependency in the real world, this influences the integration pattern chosen between their corresponding bounded contexts.

Within each bounded context, we apply tactical design patterns to implement our domain model. For instance, in our Order Processing bounded context, we might have an Order entity (with identity and lifecycle), OrderItem value objects (defined by product and quantity), and an OrderAggregate that ensures business invariants like "total price must match sum of line items." The OrderRepository provides access to persisted orders, while a PricingService handles complex pricing calculations that don't belong to any single entity.

## The Bridge Between Spaces

The Domain (problem space) and Bounded Context (solution space) are connected by shared concepts, most importantly the Domain Model. This model spans both spaces and defines how we relate domains and bounded contexts into one coherent system. The relationship can be many-to-many: one bounded context might address multiple subdomains, and one subdomain might be addressed by multiple bounded contexts. Crucially, there can be multiple domain models within different bounded contexts for the same business domain, with each context having its own specialized model.

Equally important is the ubiquitous language: a set of terms and conventions that both business and technical stakeholders use to communicate. The same word can mean different things across bounded contexts, but within one context, that word is unambiguous. For example, "Customer" means different things in different contexts—in Sales it's a prospect to convert, in Billing it's an account to invoice, and in Support it's someone needing help. Within each context, the tactical patterns help us implement these concepts consistently: Customer might be an Entity in the Sales context but a Value Object in the Billing context, depending on whether its identity matters in that specific domain model.

## From Strategy to Implementation

The beauty of DDD lies in how strategic and tactical design work together. Strategic design helps us identify the right boundaries and understand the business landscape, while tactical design gives us the tools to implement rich, maintainable domain models within those boundaries. You start with strategic design to understand what you're building and where the boundaries should be, then apply tactical patterns to implement the domain logic within each bounded context.

This isn't a waterfall process—you'll often discover insights during tactical implementation that cause you to revisit your strategic decisions. The domain model emerges through this iterative process of understanding the business and implementing software that truly reflects how the business works.

## Why This Framework Matters

This mental scaffolding helps navigate the DDD landscape more systematically than jumping straight into either strategic concepts or tactical patterns in isolation. By understanding how these foundational relationships work together—from high-level domain analysis down to specific implementation patterns—the overwhelming multitude of DDD concepts becomes more approachable and interconnected, providing a solid foundation for applying DDD principles effectively in real-world software development.

The key insight is that DDD isn't just about code patterns or architectural decisions in isolation—it's about creating software that genuinely reflects and supports the way businesses operate, from the highest strategic level down to the most detailed implementation choices.