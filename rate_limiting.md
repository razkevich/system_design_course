# How to Design Rate Limiting for Your SaaS Application

How should we design a SaaS application to deal with a rise in incoming traffic? Of course, the answer is to design it for scalability to handle increased load, be it sudden burst of traffic or steady usage growth.

But what is the degree to which our system is scalable? What kind of sudden usage spikes can it safely handle? The problem with horizontal scaling might be that it would take time to spin up new instances to handle increased load. Plus, it might be too expensive to provision more resources to handle it (especially given that some traffic might be not worth handling for different reasons). That's an important consideration, and the architect should be able to answer these questions. An architectural tactic to enforce such constraints is called Rate Limiting (sometimes called throttling).

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
- When a user hits the rate limit, the server will return the `429` error code indicating that too many requests have been issued. Another approach is to refuse to return any response to potentially malicious requests (or even confuse them with a 200) in order to obfuscate internal state to the attacker.

## Designing rate limiting system

There are several approaches to building rate limiting systems. We can check and enforce limits at different levels:

| Place to check and enforce limits                                                | Pros                                                                                                                 | Cons                                                                                                    | Complexities                                                                              |
| -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------- |
| API gateway level (e.g. a standalone service that gets called for every request) | • Centralized control: easy to configure and manage<br>• Protects backend services                                   | • Added network hop for all calls<br>• May become bottleneck<br>• Less flexibility for custom logic     | • Need high availability<br>• Requires distributed state management                       |
| Standalone service that offers rate limiting API to other backend services       | • Reusable across services<br>• Centralized configuration<br>• Can implement complex algorithms<br>• Easy to monitor | • Network latency for each check<br>• Dependency for all services<br>• Potential bottleneck             | • Service discovery<br>• Circuit breaker patterns<br>• Caching strategies needed          |
| Inside the service itself                                                        | • No network overhead<br>• Custom business logic<br>• Service-specific limits<br>• No external dependencies          | • Code duplication<br>• Harder to manage globally<br>• Inconsistent implementation<br>• No shared state | • Coordination between instances<br>• State synchronization<br>• Configuration management |
For cloud-based SaaS applications, most often it makes sense to implement a **hybrid approach**: enforce basic rate limits at the API gateway level, and implement more sophisticated business logic rate limiting within services or through a dedicated rate limiting service - where needed.
### Stateful vs. stateless approaches

**Stateless approaches** store rate limiting data in external storage (like Redis):

- **Pros:** Horizontally scalable, simple deployment, no sticky sessions needed
- **Cons:** Network latency, external dependency
- **Complexities:** Handling storage failures, atomic operations, cache invalidation

**Stateful approaches** store rate limiting data in service memory:

- **Pros:** Very low latency, no external dependencies
- **Cons:** Requires sticky sessions, complex rebalancing, potential data loss
- **Complexities:** State synchronization, handling node failures, hot shard management

## Rate limiting algorithms

How does a distributed rate-limiting service determine the requestor's current request rate and compare it with the desired limit? There are common algorithms to do that, each with different trade-offs between accuracy, memory usage, and implementation complexity.

### Token Bucket

**Main idea:** A bucket holds tokens that are consumed by requests and refilled at a constant rate.

Each request consumes a token. If no tokens are available, the request is rejected. The bucket refills at a configured rate (e.g., 10 tokens per second) up to a maximum capacity. This maximum capacity allows the algorithm to handle burst traffic - if a user hasn't made requests for a while, tokens accumulate up to the bucket capacity, allowing them to make multiple rapid requests.

A key implementation detail is that **no background process actively fills the bucket**. Instead, the system uses lazy evaluation: when a request arrives, it calculates how many tokens should have been added since the last request based on the elapsed time and refill rate. This approach is more efficient and works well in distributed systems since it doesn't require background threads or timers.

**Benefits:**

- Memory efficient (only stores token count and last update timestamp)
- Handles burst traffic well while maintaining long-term rate limits
- Simple to implement and understand
- Works well for most API rate limiting scenarios

**Complexities:**

- Requires atomic operations in distributed systems to prevent race conditions
- Clock synchronization between servers becomes important
- Determining optimal bucket capacity and refill rate requires understanding traffic patterns

### Leaky Bucket

**Main idea:** Requests fill a bucket that "leaks" at a constant rate, simulating a queue with fixed processing rate.

Unlike token bucket, which allows bursts, the leaky bucket enforces a smooth, constant output rate. There are two ways to implement this:

**Traditional implementation:** Maintains an actual queue where incoming requests are stored. A separate process or thread continuously removes and processes requests from this queue at a fixed rate. If the queue is full, new requests are rejected.

**Virtual/lazy implementation:** Instead of a real queue, the system calculates when each request would be processed based on the current virtual queue state. When a request arrives, it calculates the earliest time it could be processed (based on when previous requests would finish). If this time is too far in the future (queue too long), the request is rejected. This approach, like token bucket, requires no background processes.

This algorithm is particularly useful when the backend system cannot handle any burst traffic and requires a predictable, constant request rate. For example, if interfacing with a legacy system that can only process exactly 10 requests per second, a leaky bucket ensures this limit is never exceeded.

**Benefits:**

- Provides perfectly smooth output rate
- Protects rate-sensitive backend systems
- Predictable behavior and resource usage

**Complexities:**

- Requires maintaining a queue, using more memory than token bucket
- Can introduce latency even for legitimate traffic during busy periods
- More complex to implement in distributed systems due to queue management
- May not be suitable for APIs where some burstiness is acceptable

### Fixed Window Counter

**Main idea:** Count requests in fixed time windows (e.g., 0-60 seconds of each minute).

The algorithm divides time into fixed windows and maintains a counter for each window. When the window expires, the counter resets to zero. For example, with 1-minute windows, requests from 12:00:00 to 12:00:59 are counted together, then the counter resets at 12:01:00.

The main challenge with this approach is the **boundary spike problem**: a user could potentially make double the allowed requests by timing them around the window boundary. For instance, if the limit is 100 requests per minute, a user could make 100 requests at 12:00:59 and another 100 at 12:01:00, effectively making 200 requests in 2 seconds while staying within the per-window limit.

**Benefits:**

- Very simple to implement and understand
- Minimal memory usage (one counter per active window)
- Easy to debug and monitor
- Good for internal metrics and non-critical rate limiting

**Complexities:**

- The boundary spike issue can allow significant over-limit traffic
- Less accurate than sliding window approaches
- Can cause thundering herd problems when many clients synchronize to window boundaries
- Not suitable when strict rate limiting is required

### Sliding Window Log

**Main idea:** Store timestamp of each request and count requests within the sliding time window.

This algorithm maintains a complete log of all request timestamps within the time window. When checking rate limits, it counts all requests that fall within the sliding window (current time minus window size). Old entries outside the window are removed periodically or on-demand.

This provides the most accurate rate limiting because it uses the exact sliding window rather than approximations. Every request is evaluated against the precise count of requests in the past time period. However, this accuracy comes at the cost of storing every individual request timestamp.

**Benefits:**

- Most accurate algorithm with true sliding window behavior
- No boundary spike issues
- Provides detailed usage data for analytics and debugging
- Can support complex rate limiting rules based on request patterns

**Complexities:**

- High memory usage proportional to request volume
- Counting operations can be expensive with many requests
- Requires efficient garbage collection of expired entries
- More complex to scale in distributed systems

### Sliding Window Counter

**Main idea:** Hybrid approach using multiple fixed windows to approximate a sliding window.

This algorithm combines the simplicity of fixed windows with better accuracy approaching that of a sliding window. It maintains counters for the current and previous fixed windows, then calculates a weighted average based on the current position within the window.

For example, if 30 seconds have passed in the current minute-long window, the algorithm weights the current window's count by 50% (30/60) and the previous window's count by 50% (30/60). This approximation significantly reduces the boundary spike problem while maintaining the efficiency of counter-based approaches.

**Benefits:**

- Good balance between accuracy and resource usage
- Constant-time operations regardless of request volume
- Significantly reduces boundary spike issues
- Easier to implement in distributed systems than sliding log

**Complexities:**

- Still an approximation, not perfectly accurate
- Requires maintaining multiple window counters
- The weighting calculation adds some complexity
- Accuracy depends on window size selection

# Rate Limiting Solutions Comparison

| Name                                                  | Purpose                                        | Benefits                                                                                           |
| ----------------------------------------------------- | ---------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| **Nginx rate limiting module** (Open Source)          | Built-in rate limiting for nginx web server    | • Supports multiple algorithms<br>• Good for simple use cases<br>• No additional components needed |
| **Redis-cell** (Open Source)                          | Redis module for distributed rate limiting     | • Implements GCRA algorithm<br>• Atomic operations<br>• Enables distributed rate limiting          |
| **AWS API Gateway** (Managed Service)                 | Cloud-based API management with rate limiting  | • Built-in rate limiting<br>• Usage plans and API keys<br>• Auto-scaling capabilities              |
| **Azure API Management** (Managed Service)            | Cloud-based API management for Azure ecosystem | • Policy-based rate limiting<br>• Integration with Azure services<br>• Developer portal included   |
| **Cloudflare Rate Limiting** (Managed Service)        | Edge-based rate limiting and DDoS protection   | • Global distribution<br>• DDoS protection<br>• Minimal latency at edge                            |
| **Kong API Gateway** (Managed Service or Self-hosted) | API gateway with plugin-based rate limiting    | • Plugin-based architecture<br>• Multiple algorithm support<br>• Enterprise features available     |

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