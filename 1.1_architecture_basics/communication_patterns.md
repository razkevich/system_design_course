# Communication Patterns

In distributed systems, communication patterns determine more than just how services exchange data—they shape performance, reliability, and maintainability. While monoliths rely on simple method calls, distributed architectures must navigate network complexities, partial failures, and coordination across autonomous components.

The fundamental challenge is that networks are unreliable. Every remote call introduces latency, creates coupling, and can fail. This reality forces us to choose communication patterns consciously, understanding their trade-offs and designing for failure scenarios from the start.

## Choosing the Right Pattern

The first step in designing communication is understanding what you need. Different use cases demand different approaches, and the wrong choice can sink performance or create operational nightmares.

| Use Case | Synchronous | Asynchronous Messaging | Event Streaming |
|----------|-------------|----------------------|-----------------|
| **Client-facing APIs** | ✅ Immediate response | ❌ Poor user experience | ❌ Unnecessary complexity |
| **Service coordination** | ✅ Simple to debug | ✅ Resilient to failures | ✅ Highly scalable |
| **Data consistency** | ✅ Strong consistency | ❌ Eventual consistency | ❌ Eventual consistency |
| **High throughput** | ❌ Limited scalability | ✅ Good performance | ✅ Excellent performance |
| **Real-time updates** | ❌ Requires polling | ✅ Push-based model | ✅ Push-based model |
| **Error handling** | ✅ Immediate feedback | ❌ Complex scenarios | ❌ Complex scenarios |

When users interact directly with your system, synchronous patterns usually make sense—they expect immediate responses. But for service-to-service communication, asynchronous patterns often provide better resilience and scalability at the cost of complexity.

## Protocol Performance Characteristics

Understanding the performance implications of different protocols helps you make informed decisions. Here's what you can expect in real-world scenarios:

| Protocol | Typical Latency | Throughput Range | Best Use Case |
|----------|-----------------|------------------|---------------|
| **REST/HTTP** | ~100ms | 1K-10K requests/sec | Public APIs, CRUD operations |
| **gRPC** | ~10ms | 10K-100K requests/sec | Service mesh communication |
| **GraphQL** | ~100ms | 1K-10K requests/sec | Client-specific data fetching |
| **RabbitMQ** | ~1-10ms | 10K messages/sec | Work queue distribution |
| **Apache Kafka** | ~1-10ms | 1M+ messages/sec | Event streaming at scale |

These numbers vary significantly based on payload size, network conditions, and infrastructure, but they provide a baseline for expectations.

## Synchronous Communication

For immediate request-response interactions, synchronous patterns remain the most straightforward choice. They're easy to reason about, debug, and implement correctly.

### REST: The Universal Standard

REST APIs have become the lingua franca of web services for good reason. They're simple, well-understood, and work everywhere:

```java
@RestController
public class OrderController {
    
    @PostMapping("/orders")
    public ResponseEntity<Order> createOrder(@RequestBody OrderRequest request) {
        Order order = orderService.createOrder(request);
        return ResponseEntity.status(201).body(order);
    }
}
```

REST's strength lies in its simplicity and ubiquity. Every developer understands HTTP methods, status codes are standardized, and debugging tools are abundant. However, this simplicity comes with performance limitations—JSON is verbose, HTTP has overhead, and you're limited to request-response patterns.

### gRPC: Performance When It Matters

When you need better performance and are willing to accept some complexity, gRPC delivers significant improvements:

```protobuf
service OrderService {
    rpc CreateOrder(CreateOrderRequest) returns (Order);
    rpc ListOrders(Empty) returns (stream Order);
}
```

```java
@Service
public class OrderServiceImpl extends OrderServiceGrpc.OrderServiceImplBase {
    @Override
    public void createOrder(CreateOrderRequest request, StreamObserver<Order> responseObserver) {
        Order order = businessLogic.createOrder(request);
        responseObserver.onNext(order);
        responseObserver.onCompleted();
    }
}
```

gRPC uses binary serialization (Protocol Buffers) and HTTP/2, resulting in smaller payloads and better performance. The trade-off is complexity—binary protocols are harder to debug, browser support requires proxies, and the learning curve is steeper.

## Asynchronous Communication

When you need to decouple services, handle high throughput, or build resilient systems, asynchronous patterns become essential. They trade simplicity for scalability and resilience.

### Message Queues: Reliable Work Distribution

Message queues excel at distributing work reliably across multiple consumers. RabbitMQ is a popular choice that provides strong delivery guarantees:

```java
// Publishing events
@Service
public class OrderEventPublisher {
    
    public void publishOrderCreated(Order order) {
        OrderCreatedEvent event = new OrderCreatedEvent(order);
        rabbitTemplate.convertAndSend("order.exchange", "order.created", event);
    }
}

// Consuming events
@RabbitListener(queues = "inventory.queue")
@Component
public class InventoryEventHandler {
    
    public void handleOrderCreated(OrderCreatedEvent event) {
        inventoryService.reserveItems(event.getItems());
        // Process completes independently
    }
}
```

This pattern works well for work distribution where each message should be processed exactly once. The queue acts as a buffer, allowing services to process work at their own pace and survive temporary failures.

### Event Streaming: High-Throughput Event Processing

When you need to handle massive throughput or want to build event-driven architectures, streaming platforms like Kafka become invaluable:

```java
@KafkaListener(topics = "order-events", groupId = "payment-service")
public class PaymentEventHandler {
    
    public void handleOrderCreated(OrderCreatedEvent event) {
        paymentService.initiatePayment(event);
        // Multiple services can process the same event
    }
}
```

Unlike traditional message queues, event streams allow multiple consumers to process the same events independently. This enables powerful patterns like event sourcing and makes it easy to add new consumers without changing existing systems.

## Making the Right Choice

The decision between synchronous and asynchronous patterns often comes down to three key questions:

**Do you need an immediate response?** If users are waiting for the result, synchronous patterns provide the best experience. If the work can happen in the background, asynchronous patterns offer better scalability.

**How much throughput do you need?** REST typically tops out around 10K requests per second on modest hardware. If you need more, consider gRPC for synchronous patterns or event streaming for asynchronous ones.

**How important is strong consistency?** Synchronous patterns make it easy to maintain strong consistency across services. Asynchronous patterns inevitably lead to eventual consistency, which requires more careful design but enables better scalability.

## Building Resilient Communication

Regardless of which patterns you choose, distributed communication will fail. Networks are unreliable, services go down, and load can overwhelm systems. Resilience patterns help your system gracefully handle these inevitable failures.

### Circuit Breakers: Preventing Cascade Failures

When a downstream service starts failing, circuit breakers prevent your service from making repeated failed calls:

```java
@CircuitBreaker(name = "payment-service", fallbackMethod = "fallbackPayment")
public PaymentResult processPayment(PaymentRequest request) {
    return paymentClient.process(request);
}

public PaymentResult fallbackPayment(PaymentRequest request, Exception ex) {
    // Queue the payment for later processing
    paymentQueue.send("retry-payments", request);
    return PaymentResult.pending(request.getId());
}
```

Circuit breakers monitor failure rates and automatically stop making calls when failures exceed a threshold. This prevents cascade failures and gives failing services time to recover.

### Retry Strategies: Handling Transient Failures

Not all failures are permanent. Network blips, temporary overload, and brief service restarts can often be handled with simple retries:

| Failure Type | Retry Strategy | Max Attempts | Rationale |
|--------------|----------------|--------------|-----------|
| **Network timeouts** | Exponential backoff | 3 | Usually transient |
| **Rate limiting** | Fixed delay | 5 | Predictable recovery |
| **Service unavailable** | Circuit breaker | - | May indicate systemic issues |

The key is distinguishing between transient failures (worth retrying) and permanent failures (should fail fast).

## Distributed Transactions

One of the most challenging aspects of distributed systems is coordinating transactions across multiple services. Traditional ACID transactions don't work across network boundaries, so we need different approaches.

### The Saga Pattern

Sagas coordinate long-running transactions by breaking them into smaller, compensatable steps. There are two main approaches:

**Orchestration** uses a central coordinator to manage the transaction:

```java
@SagaHandler
public class OrderSagaOrchestrator {
    
    public void handleOrderCreated(OrderCreatedEvent event) {
        // Step 1: Reserve inventory
        commandGateway.send(new ReserveInventoryCommand(event.getOrderId()));
    }
    
    public void handleInventoryReserved(InventoryReservedEvent event) {
        // Step 2: Process payment
        commandGateway.send(new ProcessPaymentCommand(event.getOrderId()));
    }
    
    public void handlePaymentFailed(PaymentFailedEvent event) {
        // Compensate: Release inventory
        commandGateway.send(new ReleaseInventoryCommand(event.getOrderId()));
    }
}
```

**Choreography** allows services to coordinate through events without a central coordinator:

```java
@EventHandler
public class InventoryService {
    
    public void handleOrderCreated(OrderCreatedEvent event) {
        try {
            reserveItems(event.getItems());
            eventPublisher.publish(new InventoryReservedEvent(event.getOrderId()));
        } catch (InsufficientInventoryException e) {
            eventPublisher.publish(new InventoryReservationFailedEvent(event.getOrderId()));
        }
    }
}
```

Orchestration provides centralized control and easier debugging, while choreography offers better decoupling and resilience. Choose based on your team's capabilities and complexity requirements.

## Message Design and Evolution

In asynchronous systems, message schemas become contracts between services. Designing them for evolution prevents breaking changes as your system grows.

### Schema Evolution Best Practices

**Safe changes** that won't break existing consumers:
- Adding optional fields
- Adding new message types
- Making required fields optional
- Increasing field sizes

**Breaking changes** that require coordination:
- Removing fields
- Changing field types
- Renaming fields
- Making optional fields required

```protobuf
message User {
    string id = 1;
    string name = 2;
    string email = 3;
    string phone = 4;        // Safe: new optional field
    // Never: remove or rename existing fields
}
```

### Message Envelopes

Standardizing message metadata helps with routing, debugging, and correlation across services:

```java
public class MessageEnvelope<T> {
    private String messageId;
    private String correlationId;
    private Instant timestamp;
    private String source;
    private T payload;
}
```

This envelope pattern provides consistent metadata across all messages, making it easier to implement cross-cutting concerns like tracing and correlation.

## Monitoring and Observability

Distributed communication is inherently more complex to monitor than local method calls. You need visibility into message flows, failure patterns, and performance characteristics.

### Key Metrics to Track

| Metric | Target | Alert Threshold | Why It Matters |
|--------|--------|-----------------|----------------|
| **HTTP P95 latency** | < 500ms | > 1000ms | User experience impact |
| **Message processing lag** | < 100ms | > 1000ms | System responsiveness |
| **Error rate** | < 1% | > 5% | System reliability |
| **Circuit breaker trips** | 0/hour | > 3/hour | Service health indicator |

### Distributed Tracing

Understanding request flows across services requires distributed tracing:

```java
@Span("create-order")
public Order createOrder(OrderRequest request) {
    return orderService.save(request);
}
```

Tools like Jaeger or Zipkin can show you exactly how requests flow through your system, where time is spent, and where failures occur.

## Decision Framework

When choosing communication patterns, consider these principles:

1. **Start simple** - Use synchronous patterns until you have evidence they're insufficient
2. **Design for failure** - Networks are unreliable; plan for it from the beginning
3. **Monitor everything** - You can't debug what you can't see
4. **Plan for evolution** - Communication contracts will need to change
5. **Choose consciously** - Each pattern has specific trade-offs; understand them
6. **Test failure scenarios** - Verify that circuit breakers, timeouts, and retries work as expected
7. **Standardize patterns** - Consistency reduces cognitive load and operational complexity

Communication patterns are not just technical choices—they're architectural decisions that shape how your system behaves under load, how it fails, and how it can evolve. The most successful distributed systems choose patterns thoughtfully, implement them consistently, and monitor them comprehensively.