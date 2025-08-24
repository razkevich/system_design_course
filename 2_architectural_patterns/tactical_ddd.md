# Tactical Domain-Driven Design

## Overview

Tactical Domain-Driven Design provides the building blocks for implementing rich domain models within bounded contexts. While strategic DDD focuses on identifying bounded contexts and understanding their relationships across the enterprise, tactical DDD addresses the implementation of expressive domain models within those contexts.

Many enterprise applications rely on simple data structures that contain state but minimal behavior:

```java
public class Order {
    private String id;
    private String customerId;
    private List<OrderItem> items;
    private OrderStatus status;
    private BigDecimal totalAmount;
    
    // getters and setters...
}
```

This "Java Bean" approach creates simple data structures that work well with frameworks but lack the rich behavior and business rules that define the domain. All business logic becomes concentrated in service classes, resulting in what Domain-Driven Design terms "anemic domain models."

Tactical DDD patterns transform these simple data holders into rich objects that encapsulate both data and behavior, creating domain models that truly represent business concepts and enforce business rules.

## The Problem with Anemic Domain Models

Anemic domain models are classes that contain data but little to no behavior. They're essentially glorified data transfer objects (DTOs) with business logic scattered across various service classes. While this approach works, it misses opportunities for creating more maintainable and expressive code.

A typical order processing service demonstrates this pattern:

```java
@Service
public class OrderService {
    public void processOrder(Order order) {
        if (order.getStatus() != OrderStatus.PENDING) {
            throw new IllegalStateException("Only pending orders can be processed");
        }
        
        BigDecimal total = BigDecimal.ZERO;
        for (OrderItem item : order.getItems()) {
            total = total.add(item.getPrice().multiply(new BigDecimal(item.getQuantity())));
        }
        order.setTotalAmount(total);
        order.setStatus(OrderStatus.CONFIRMED);
    }
}
```

This design separates business rules from the data they operate on, reducing discoverability and maintainability of domain logic.

## Tactical DDD: Building Rich Domain Models

## Core Principles

Tactical DDD creates domain objects that encapsulate both data and behavior, placing business logic close to the data it operates on. The approach does not eliminate all services but ensures that business logic resides in appropriate locations.

Within a bounded context, tactical patterns transform simple data structures into rich domain objects. These objects, whether Entities or Value Objects, encapsulate business logic and maintain ownership of their state.

## Entities: Objects with Identity

Entities represent domain concepts that have a distinct identity that persists over time. In tactical DDD, entities should contain their core business logic, not just expose their state.

```java
public class Order {
    private final OrderId id;
    private final CustomerId customerId;
    private final List<OrderItem> items;
    private OrderStatus status;
    private Money totalAmount;
    
    public Order(OrderId id, CustomerId customerId) {
        this.id = Objects.requireNonNull(id);
        this.customerId = Objects.requireNonNull(customerId);
        this.items = new ArrayList<>();
        this.status = OrderStatus.PENDING;
        this.totalAmount = Money.ZERO;
    }
    
    public void addItem(Product product, int quantity) {
        if (status != OrderStatus.PENDING) {
            throw new IllegalStateException("Cannot modify confirmed order");
        }
        
        OrderItem item = new OrderItem(product, quantity);
        items.add(item);
        recalculateTotal();
    }
    
    public void confirm() {
        if (items.isEmpty()) {
            throw new IllegalStateException("Cannot confirm empty order");
        }
        if (status != OrderStatus.PENDING) {
            throw new IllegalStateException("Order already processed");
        }
        
        this.status = OrderStatus.CONFIRMED;
    }
    
    private void recalculateTotal() {
        this.totalAmount = items.stream()
            .map(OrderItem::getSubtotal)
            .reduce(Money.ZERO, Money::add);
    }
    
    // Getters for necessary data access (no setters for business-critical fields)
    public OrderId getId() { return id; }
    public OrderStatus getStatus() { return status; }
    public Money getTotalAmount() { return totalAmount; }
}
```

Business rules are embedded within the entity, enabling the order to validate state transitions and maintain invariants. This represents the core principle of tactical DDD: transforming passive data holders into active domain objects that understand and enforce business rules.

## Value Objects: Rich Data Types

Value Objects transform data handling by grouping related properties into cohesive, meaningful objects with encapsulated behavior, replacing primitive type proliferation throughout the codebase.

### From Primitive Obsession to Domain Types

Method signatures demonstrate the transformation from primitive-heavy approaches:

**Before Value Objects:**
```java
calculateShipping(BigDecimal amount, String currency, String street, String city, String zipCode, String country)
```

**With Value Objects:**
```java
calculateShipping(Money price, Address destination)
```

Value Objects extend beyond simple grouping by encapsulating behavior that would otherwise require utility classes or services.

### Behavior Encapsulation

Value Objects contain domain-specific business logic. A `Money` object provides arithmetic operations (addition, multiplication, comparison), while an `Address` object handles validation and distance calculations. This behavior remains close to the data it operates on.

### Benefits

- **Type Safety**: Prevents incorrect parameter passing (customer ID vs. order ID)
- **Expressiveness**: Self-documenting method signatures
- **Validation**: Business rule enforcement at object creation
- **Immutability**: New instances for changes, preventing accidental modifications
- **Testability**: Isolated business logic for unit testing

### Application Guidelines

Create Value Objects to:
- Replace primitive types representing domain concepts (email addresses, phone numbers, monetary amounts)
- Group related fields that travel together (address components, coordinates)
- Encapsulate domain-specific behavior (calculations, validations, formatting)

Value Objects create a rich vocabulary of domain concepts that clearly express business intent, transforming codebases from collections of loosely related primitives into cohesive domain models.

## Domain Services: Complex Business Logic

Not all business logic belongs in entities or value objects. Domain services handle operations that involve multiple entities or represent domain concepts that don't naturally fit within a single object.

```java
@DomainService
public class OrderPricingService {
    private final DiscountCalculator discountCalculator;
    private final TaxCalculator taxCalculator;
    
    public OrderTotal calculateTotal(Order order, Customer customer) {
        Money subtotal = order.getSubtotal();
        Money discount = discountCalculator.calculateDiscount(order, customer);
        Money tax = taxCalculator.calculateTax(subtotal.subtract(discount), customer.getLocation());
        
        return new OrderTotal(subtotal, discount, tax);
    }
}
```

Domain services coordinate between entities and value objects, maintaining organized and testable complex business logic.

### Service Responsibilities

While entities contain core business logic, certain operations require domain services:

- **Multi-entity operations**: Logic that involves multiple aggregates or entities. For example, transferring inventory between warehouses involves multiple `Warehouse` aggregates and should be handled by an `InventoryTransferService`.

- **External system integration**: Rules that require data from external services. A `CreditCheckService` might validate a customer's creditworthiness by calling an external credit bureau API before allowing large orders.

- **Complex calculations involving multiple contexts**: Pricing logic that considers customer tier, product categories, seasonal discounts, and regional taxes might be too complex for a single entity and better suited for a `PricingService`.

- **Domain policies that change frequently**: Rules that are likely to change based on business conditions. A `ShippingPolicyService` might determine delivery options based on current carrier availability and business rules that change seasonally.

- **Performance-sensitive operations**: Calculations that require caching, batch processing, or specialized algorithms. A `RecommendationService` might use machine learning models that are too heavy for individual entities.

**Principle**: Entities focus on core identity and immediate business rules, while services handle coordination, integration, and complex cross-cutting concerns.

## Aggregates: Consistency Boundaries

An aggregate is a cluster of related entities and value objects that are treated as a single unit for data changes. Within a bounded context, aggregates define consistency boundaries—everything inside the aggregate must remain consistent, while the aggregate itself is the only way external code can modify this cluster.

The aggregate has one designated "root" entity that serves as the gatekeeper. External objects can only reference and modify the aggregate through its root, never by directly accessing internal entities. This ensures that business rules are always enforced and the aggregate never ends up in an invalid state.

Aggregates are one of the most important tactical patterns because they define consistency boundaries within your domain. They ensure that business invariants are maintained across related entities while keeping the complexity manageable.

```java
public class Order { // Aggregate Root
    private final OrderId id;
    private final CustomerId customerId;
    private final List<OrderItem> items; // Internal entities
    private OrderStatus status;
    
    // Only the aggregate root can be referenced from outside
    // All modifications go through the aggregate root
    
    public void changeItemQuantity(ProductId productId, int newQuantity) {
        OrderItem item = findItem(productId);
        if (item == null) {
            throw new IllegalArgumentException("Item not found in order");
        }
        
        if (status != OrderStatus.PENDING) {
            throw new IllegalStateException("Cannot modify confirmed order");
        }
        
        item.changeQuantity(newQuantity);
        recalculateTotal();
        
        // Business rule: Orders over $1000 require approval
        if (totalAmount.isGreaterThan(new Money(new BigDecimal("1000")))) {
            this.status = OrderStatus.PENDING_APPROVAL;
        }
    }
}
```

Controlling access through the aggregate root ensures consistent enforcement of business rules.

## Implementation Strategy

Transitioning from anemic models to rich domain models requires a systematic approach:

### Incremental Approach
1. **Start Small**: Begin with well-understood domain concepts, particularly classes with multiple associated service methods
2. **Identify Business Rules**: Extract validation logic, state transitions, and calculations from service classes
3. **Create Domain Types**: Replace primitive types with value objects for domain concepts
4. **Encapsulate Operations**: Replace setters with behavior-expressing methods (`order.confirm()` vs `order.setStatus(CONFIRMED)`)
5. **Test Domain Logic**: Leverage improved testability through encapsulated business logic

## Common Misconceptions

**Rich domain models are excessive for simple CRUD applications**: While true for basic operations, applications typically evolve beyond simple CRUD. Rich models facilitate this evolution.

**JPA/Hibernate incompatibility**: Modern JPA supports rich domain models effectively. Specific techniques like `@Access(AccessType.FIELD)` and careful constructor design enable integration.

**Service elimination**: Application services remain essential for workflow coordination and transaction management. Domain services handle complex business logic. The distinction lies in abstraction level and responsibility distribution.

## Benefits

Rich domain models provide:

- **Self-documenting code**: Business rules visible within domain objects
- **Improved encapsulation**: Prevention of invalid state representation
- **Enhanced testability**: Isolated business logic testing
- **Reduced coupling**: Colocation of related data and behavior
- **Clear intent**: Method names expressing business operations rather than technical mechanics

## Summary

Tactical DDD creates domain models that reflect business domain complexity and richness. While strategic design establishes boundaries and relationships, tactical design provides implementation tools for expressive models within those boundaries.

Entities, value objects, aggregates, and domain services enable code that expresses domain language and concepts effectively. The implementation requires time and practice, but results in more maintainable, testable code aligned with domain expert perspectives.

The objective involves placing business logic appropriately and creating models that accurately represent the domain, rather than eliminating all services or maximizing object intelligence.