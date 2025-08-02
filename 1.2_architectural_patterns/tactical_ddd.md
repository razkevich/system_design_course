# Beyond Java Beans: Tactical Domain-Driven Design for Richer Domain Models

*How to move from anemic objects to expressive domain models that capture business complexity*

---

If you've been writing enterprise Java applications, chances are you've created countless classes that look like this:

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

These "Java Bean" style objects feel natural—they're simple, familiar, and work well with frameworks. But there's a problem: they don't capture the rich behavior and business rules that make your domain unique. Instead, all the interesting logic gets pushed into service classes, creating what Domain-Driven Design calls "anemic domain models."

I think many experienced developers unknowingly follow the principles of DDD Tactical Design because it just often makes sense, but I also think many are not and conscious of their insights. This article explores tactical DDD patterns that can transform the way we write java classes by comprehending and making use of the mental model that DDD provides.

## The Problem with Anemic Domain Models

Anemic domain models are classes that contain data but little to no behavior. They're essentially glorified data transfer objects (DTOs) with business logic scattered across various service classes. While this approach works, it misses opportunities for creating more maintainable and expressive code.

Consider a typical order processing service:

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

While functional, this design separates business rules from the data they operate on, making the domain logic harder to discover and maintain.

## Tactical DDD: Building Rich Domain Models

Tactical DDD provides patterns for creating domain objects that encapsulate both data and behavior. The goal isn't to eliminate all services, but to place business logic where it naturally belongs—close to the data it operates on.

From the DDD perspective, Java Beans can be either Entities or Value Objects. Both can benefit from encapsulating business logic and taking more ownership of their state.

### 1. Entities: Objects with Identity

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

Notice how the business rules are now embedded within the entity. The order knows how to validate its own state transitions and maintain its invariants.

In section 3 we'll talk about when it's actually preferential to keep business logic and behavior away from Entities to Services.

### 2. Value Objects: Transforming How You Work with Data

Value Objects change how you handle data in Java applications. Instead of scattering primitive types and collections throughout your codebase, VOs group related properties into cohesive, meaningful objects with their own behavior.

**From Primitive Obsession to Rich Types**

Consider a typical method signature before VOs:
`calculateShipping(BigDecimal amount, String currency, String street, String city, String zipCode, String country)`

With Value Objects:
`calculateShipping(Money price, Address destination)`

The transformation goes beyond just grouping—VOs encapsulate behavior that would otherwise live in utility classes or services.

**VOs Have Behavior, Not Just State**

Like entities, Value Objects can contain business logic. A `Money` object doesn't just hold an amount—it knows how to add, multiply, and compare itself. An `Address` object can validate postal codes or calculate distances. This behavior stays close to the data it operates on.

**Key Benefits:**

- **Type Safety**: Impossible to accidentally pass a customer ID where an order ID is expected
- **Expressiveness**: Method signatures become self-documenting
- **Validation**: Business rules are enforced at object creation
- **Immutability**: Changes return new instances, preventing accidental modifications
- **Testability**: Business logic in VOs is easy to unit test

**When to Create Value Objects:**

Replace primitive types when they represent domain concepts (email addresses, phone numbers, money), group related fields that always travel together (address components, coordinates), or when you need domain-specific behavior (calculations, validations, formatting).

Value Objects transform your codebase from a collection of loosely related primitives into a rich vocabulary of domain concepts that express business intent clearly.

**When to Extract from Java Beans:**
- Replace primitive obsession with domain-specific types
- Group related fields into cohesive value objects  
- Add domain-specific behavior and validation
- Enforce business rules through type safety

### 3. Domain Services: Complex Business Logic

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

Domain services coordinate between entities and value objects while keeping complex business logic organized and testable.

**When to Extract Business Rules/Behavior from Entities to Services**

While entities should contain their core business logic, certain rules belong in domain services:

- **Multi-entity operations**: Logic that involves multiple aggregates or entities. For example, transferring inventory between warehouses involves multiple `Warehouse` aggregates and should be handled by an `InventoryTransferService`.

- **External system integration**: Rules that require data from external services. A `CreditCheckService` might validate a customer's creditworthiness by calling an external credit bureau API before allowing large orders.

- **Complex calculations involving multiple contexts**: Pricing logic that considers customer tier, product categories, seasonal discounts, and regional taxes might be too complex for a single entity and better suited for a `PricingService`.

- **Domain policies that change frequently**: Rules that are likely to change based on business conditions. A `ShippingPolicyService` might determine delivery options based on current carrier availability and business rules that change seasonally.

- **Performance-sensitive operations**: Calculations that require caching, batch processing, or specialized algorithms. A `RecommendationService` might use machine learning models that are too heavy for individual entities.

The key principle: keep entities focused on their core identity and immediate business rules, while using services for coordination, integration, and complex cross-cutting concerns.

### 4. Aggregates: Consistency Boundaries

An aggregate is a cluster of related entities and value objects that are treated as a single unit for data changes. Think of it as a consistency boundary—everything inside the aggregate must remain consistent, while the aggregate itself is the only way external code can modify this cluster.

The aggregate has one designated "root" entity that serves as the gatekeeper. External objects can only reference and modify the aggregate through its root, never by directly accessing internal entities. This ensures that business rules are always enforced and the aggregate never ends up in an invalid state.

So, aggregates define consistency boundaries in your domain. They ensure that business invariants are maintained across related entities.

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

By controlling access through the aggregate root, you ensure that business rules are consistently enforced.

## Making the Transition

Moving from anemic models to rich domain models doesn't happen overnight. Here's a practical approach:

### Start Small
Begin with a single, well-understood domain concept. Look for classes that have many service methods operating on them—these are good candidates for enrichment.

### Identify Business Rules
Look through your service classes for validation logic, state transitions, and calculations. These often belong in domain objects.

### Create Meaningful Types
Replace primitive types with value objects where they represent domain concepts. Instead of `String customerId`, use `CustomerId`.

### Encapsulate State Changes
Remove setters and create methods that represent business operations. Instead of `order.setStatus(CONFIRMED)`, use `order.confirm()`.

### Test Your Domain Logic
Rich domain models are easier to unit test because the business logic is encapsulated within the objects. You can test business rules without complex setup.

## Common Misconceptions

**"Rich domain models are overkill for simple CRUD applications"**
True, but most applications grow beyond simple CRUD. Starting with richer models makes evolution easier.

**"This approach doesn't work with JPA/Hibernate"**
Modern JPA works well with rich domain models. You might need to use `@Access(AccessType.FIELD)` and be thoughtful about your constructors, but it's definitely achievable.

**"Services become useless"**
Application services still coordinate workflows and manage transactions. Domain services handle complex business logic. The difference is in the level of abstraction and responsibility.

## The Payoff

Rich domain models offer several advantages:

- **Self-documenting code**: Business rules are visible in the domain objects
- **Better encapsulation**: Invalid states become impossible to represent
- **Easier testing**: Business logic can be tested in isolation
- **Reduced coupling**: Related data and behavior are grouped together
- **Clearer intent**: Method names express business operations, not technical mechanics

## Conclusion

Tactical DDD isn't about following patterns religiously—it's about creating domain models that reflect the complexity and richness of your business domain. By moving beyond simple Java beans and embracing entities, value objects, and domain services, you can create code that not only works but truly expresses the language and concepts of your domain.

The transition takes time and practice, but the result is code that's more maintainable, testable, and aligned with how domain experts think about the business. Your future self (and your teammates) will thank you for the investment.

---

*Remember: The goal isn't to eliminate all services or make every object "smart." It's about placing business logic where it naturally belongs and creating models that tell the story of your domain.*