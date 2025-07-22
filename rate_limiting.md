# How to Design Rate Limiting for Your SaaS Application

How should we design a SaaS application to deal with a rise in incoming traffic? Of course, the answer is to design it for scalability to handle increased load, be it sudden burst of traffic or steady usage growth.

But what is the degree to which our system is scalable? What kind of sudden usage spikes can it safely handle? The problem with horizontal scaling might be that it would take time to spin up new instances to handle increased load. Plus, it might be too expensive to provision more resources to handle it (especially given that some traffic might be not worth handling for different reasons). That's an important consideration, and the architect should be able to answer these questions. An architectural tactic to enforce such constraints is called Rate Limiting.

There are many situations that could cause dangerous traffic spikes:

- Legitimate usage patterns during "hot" periods (e.g. Black Friday)
- Viral social media moments or influencer mentions
- Malicious traffic trying to bring our systems down
- Users trying to run load tests or some automations involving our APIs
- Bot scrapers and competitive intelligence gathering

In this article we'll review common approaches and architectures for designing rate limiting systems and rate limiting algorithms.

## Common assumptions about rate limiting

- **Shared rate limiting usually makes sense for simple use cases.** If we want to make tenant-aware rate limiting, or enforce custom application logic to check if limits are exceeded, then we need to implement it within the service itself or use a more sophisticated standalone rate limiting service that supports custom rules.
- **We often can relax consistency requirements:** it's not a big deal if we let through some requests. We need design for strict guarantees (e.g. if every request is very expensive), but this comes with increased cost and complexity.
- **Rate limits should be communicated clearly to clients** through standard headers (RateLimit-Limit, RateLimit-Remaining, RateLimit-Reset) to prevent retry storms.
- **Different endpoints may need different rate limits** based on their computational cost and business importance.

## Designing rate limiting system

There are several approaches to building rate limiting systems. We can check and enforce limits at different levels:

| Place to check and enforce limits                                                | Pros                                                                                                                 | Cons                                                                                                    | Complexities                                                                              |
| -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------- |
| API gateway level (e.g. a standalone service that gets called for every request) | • Centralized control: easy to configure and manage<br>• Protects backend services                                   | • Added network hop for all calls<br>• May become bottleneck<br>• Less flexibility for custom logic     | • Need high availability<br>• Requires distributed state management                       |
| Standalone service that offers rate limiting API to other backend services       | • Reusable across services<br>• Centralized configuration<br>• Can implement complex algorithms<br>• Easy to monitor | • Network latency for each check<br>• Dependency for all services<br>• Potential bottleneck             | • Service discovery<br>• Circuit breaker patterns<br>• Caching strategies needed          |
| Inside the service itself                                                        | • No network overhead<br>• Custom business logic<br>• Service-specific limits<br>• No external dependencies          | • Code duplication<br>• Harder to manage globally<br>• Inconsistent implementation<br>• No shared state | • Coordination between instances<br>• State synchronization<br>• Configuration management |

### Stateful vs. stateless approaches

**Stateless approaches** store rate limiting data in external storage (like Redis):

- **Pros:** Horizontally scalable, simple deployment, no sticky sessions needed
- **Cons:** Network latency, external dependency
- **Complexities:** Handling storage failures, atomic operations, cache invalidation

**Stateful approaches** store rate limiting data in service memory:

- **Pros:** Very low latency, no external dependencies
- **Cons:** Requires sticky sessions, complex rebalancing, potential data loss
- **Complexities:** State synchronization, handling node failures, hot shard management

### Service vs. Library

**Rate limiting as a service** provides centralized control and is easier to manage across multiple applications, but adds network latency and creates a dependency. 

**Rate limiting as a library** offers better performance and no network overhead, but requires updates across all services and can lead to inconsistent implementations. 

### Hybrid approach

For cloud-based SaaS applications, most often it makes sense to implement a **hybrid approach**: enforce basic rate limits at the API gateway level, and implement more sophisticated business logic rate limiting within services or through a dedicated rate limiting service - where needed.

## Rate limiting algorithms

How does a distributed rate-limiting service determine the requestor's current request rate and compare it with the desired limit? There are common algorithms to do that:

### Token Bucket

**Main idea:** A bucket holds tokens that are consumed by requests and refilled at a constant rate.

Each request consumes a token. If no tokens are available, the request is rejected. The bucket refills at a configured rate (e.g., 10 tokens per second).

**Benefits:**

- Memory efficient (only stores token count and last update time)
- Handles burst traffic well
- Simple to implement

**Complexities:**

- Synchronization in distributed systems
- Determining optimal bucket size and refill rate

### Leaky Bucket

**Main idea:** Requests fill a bucket that "leaks" at a constant rate, simulating a queue with fixed processing rate.

Requests are added to a queue. If the queue is full, new requests are rejected. The queue is processed at a fixed rate.

**Benefits:**

- Smooths out traffic bursts
- Predictable output rate

**Complexities:**

- Less memory efficient (stores queue)
- Can introduce latency for legitimate traffic
- Queue management overhead

### Fixed Window Counter

**Main idea:** Count requests in fixed time windows (e.g., 0-60 seconds of each minute).

Tracks request count per fixed time interval. Resets counter at window boundaries.

**Benefits:**

- Very simple to implement
- Low memory usage
- Easy to understand

**Complexities:**

- Boundary issues (can allow 2x rate at window edges)
- Less accurate than sliding window
- Thundering herd at window reset

### Sliding Window Log

**Main idea:** Store timestamp of each request and count requests within the sliding time window.

Maintains a log of all request timestamps. Counts requests by checking timestamps within the current window.

**Benefits:**

- Most accurate algorithm
- No boundary issues
- Provides detailed usage data

**Complexities:**

- High memory usage (stores all timestamps)
- O(n) complexity for counting
- Garbage collection of old entries

### Sliding Window Counter

**Main idea:** Hybrid approach using multiple fixed windows to approximate a sliding window.

Combines counts from current and previous fixed windows using weighted average based on time position.

**Benefits:**

- Good accuracy/memory tradeoff
- O(1) operations
- Lower memory than sliding log

**Complexities:**

- Slightly less accurate than sliding log
- More complex than fixed window
- Window size selection impacts accuracy



# Rate Limiting Solutions Comparison

| Name                           | Type                 | Purpose                                               | Benefits                                                                                           |
| ------------------------------ | -------------------- | ----------------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| **Nginx rate limiting module** | Open Source          | Built-in rate limiting for nginx web server           | • Supports multiple algorithms<br>• Good for simple use cases<br>• No additional components needed |
| **Envoy Proxy**                | Open Source          | Advanced rate limiting for service mesh architectures | • Global and local rate limiting modes<br>• Integrates with service mesh<br>• Highly performant    |
| **Redis-cell**                 | Open Source          | Redis module for distributed rate limiting            | • Implements GCRA algorithm<br>• Atomic operations<br>• Enables distributed rate limiting          |
| **Bucket4j**                   | Open Source (Java)   | In-memory rate limiting library for Java applications | • Multiple algorithm support<br>• Spring Boot integration<br>• Simple implementation               |
| **Go-rate**                    | Open Source (Golang) | Rate limiting library for Go applications             | • Token bucket implementation<br>• Simple and efficient<br>• Lightweight                           |
| **AWS API Gateway**            | Managed Service      | Cloud-based API management with rate limiting         | • Built-in rate limiting<br>• Usage plans and API keys<br>• Auto-scaling capabilities              |
| **Cloudflare Rate Limiting**   | Managed Service      | Edge-based rate limiting and DDoS protection          | • Global distribution<br>• DDoS protection<br>• Minimal latency at edge                            |
| **Kong API Gateway**           | Managed Service      | API gateway with plugin-based rate limiting           | • Plugin-based architecture<br>• Multiple algorithm support<br>• Enterprise features available     |
| **Azure API Management**       | Managed Service      | Cloud-based API management for Azure ecosystem        | • Policy-based rate limiting<br>• Integration with Azure services<br>• Developer portal included   |

## Conclusion and takeaways

Rate limiting is a critical component of modern SaaS applications, protecting systems from abuse while ensuring fair resource usage. Key takeaways:

1. **Start simple, evolve as needed:** Begin with basic rate limiting at the API gateway and add sophistication as your system grows
    
2. **Choose algorithms wisely:** Token bucket for general use, sliding window for accuracy-critical applications
    
3. **Layer your defenses:** Implement rate limiting at multiple levels for comprehensive protection
    
4. **Consider the trade-offs:** Balance between accuracy, performance, and complexity based on your requirements
    
5. **Communicate clearly:** Use standard headers and provide good error messages to help clients handle rate limits
    
6. **Monitor and adapt:** Track rate limiting metrics and adjust limits based on actual usage patterns
    
7. **Plan for scale:** Design your rate limiting system to grow with your application
    

Remember, rate limiting is not just about preventing abuse—it's about ensuring a quality experience for all users while protecting your infrastructure. The best rate limiting system is one that users rarely notice but that saves your service during critical moments.