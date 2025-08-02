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

This article explores tactical DDD patterns that can transform your passive data containers into expressive domain objects that tell the story of your business.

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

### 2. Value Objects: Immutable Concepts

Value objects represent concepts that are defined by their attributes rather than identity. They're immutable and can be freely shared.

```java
public class Money {
    public static final Money ZERO = new Money(BigDecimal.ZERO);
    
    private final BigDecimal amount;
    
    public Money(BigDecimal amount) {
        this.amount = Objects.requireNonNull(amount);
    }
    
    public Money add(Money other) {
        return new Money(this.amount.add(other.amount));
    }
    
    public Money multiply(int factor) {
        return new Money(this.amount.multiply(new BigDecimal(factor)));
    }
    
    public boolean isGreaterThan(Money other) {
        return this.amount.compareTo(other.amount) > 0;
    }
    
    @Override
    public boolean equals(Object obj) {
        if (this == obj) return true;
        if (!(obj instanceof Money)) return false;
        Money money = (Money) obj;
        return Objects.equals(amount, money.amount);
    }
    
    @Override
    public int hashCode() {
        return Objects.hash(amount);
    }
}
```

Value objects make your domain model more expressive and type-safe. Instead of passing around raw `BigDecimal` values, you're working with `Money` objects that carry domain meaning.

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

### 4. Aggregates: Consistency Boundaries

Aggregates define consistency boundaries in your domain. They ensure that business invariants are maintained across related entities.

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