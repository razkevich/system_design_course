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
- When a user hits the rate limit, the server will return the `429` error code indicating that too many requests have been issued.

## Rate limiting dimensions

There are different dimensions by which you can limit requests:

**Identity-based limiting:**

- IP Address: Simple but can be bypassed; problematic with shared NAT
- User ID: Requires authentication; most accurate for logged-in users
- API Key: Good for B2B APIs; allows different service tiers
- Tenant/Organization: Essential for multi-tenant SaaS

**Resource-based limiting:**

- Endpoint-specific limits based on computational cost
- Operation cost where complex queries consume more "quota points"
- Hierarchical limits (e.g., user limits within tenant limits)

## Designing rate limiting system

There are several approaches to building rate limiting systems:

|Implementation Level|Best For|Key Trade-offs|
|---|---|---|
|**API Gateway**|Simple protection, DDoS defense|Centralized but less flexible; added latency|
|**Standalone Service**|Complex rules, shared across services|Reusable but introduces dependency; potential bottleneck|
|**Within Service**|Custom business logic, service-specific needs|No network overhead but harder to manage globally|

For cloud-based SaaS applications, a **hybrid approach** often makes sense: basic rate limits at the API gateway level, with sophisticated business logic rate limiting within services where needed.

### Stateful vs. stateless approaches

**Stateless** (using external storage like Redis):

- Horizontally scalable, simple deployment
- Network latency and external dependency
- Better for distributed systems

**Stateful** (in-memory storage):

- Very low latency, no external dependencies
- Requires sticky sessions, complex rebalancing
- Better for single-instance or small deployments

### Distributed systems challenges

**Clock Skew**: Servers may have different times. Solutions include NTP synchronization and tolerance windows.

**Network Partitions**: During splits, rate limiting state may diverge. Choose between accepting temporary inconsistency or implementing quorum-based decisions.

**Consistency Guarantees**:

- Eventually Consistent: Acceptable for most APIs
- Strongly Consistent: Required for billing-critical operations
- Best Effort: Lowest latency but least accurate

## Rate limiting algorithms

### Token Bucket

A bucket holds tokens consumed by requests and refilled at a constant rate. Allows burst traffic up to bucket capacity while maintaining long-term rate limits. Uses lazy evaluation — no background process needed — "virtual" tokens usage/refill are calculated at request time.

**Best for:** General API rate limiting where some burstiness is acceptable 

**Trade-off:** Simple and efficient but requires careful capacity planning

### Leaky Bucket

Requests fill a bucket that "leaks" at a constant rate, enforcing smooth output. Can be implemented with an actual queue or virtually with counters.

**Best for:** Protecting backend systems that cannot handle bursts 

**Trade-off:** Smooth rate but may delay legitimate traffic

### Fixed Window Counter

Count requests in fixed time windows (e.g., each minute). Simple but suffers from boundary spikes where users can make double the limit by timing requests around window boundaries.

**Best for:** Internal metrics, non-critical limiting 

**Trade-off:** Very simple but least accurate

### Sliding Window Log

Stores timestamps of all requests and counts those within the sliding window. Most accurate but memory-intensive.

**Best for:** When accuracy is critical and request volume is manageable 

**Trade-off:** Perfect accuracy but high memory usage

### Sliding Window Counter

Hybrid approach using weighted averages of current and previous fixed windows. Approximates sliding window behavior efficiently.

**Best for:** Production systems needing good accuracy with reasonable resource usage 

**Trade-off:** Good balance but still an approximation

### GCRA (Generic Cell Rate Algorithm)

Used by Redis-cell, tracks when the next request should be allowed based on emission intervals. Provides smooth limiting with exact wait times.

**Best for:** When you need very smooth rate limiting with minimal memory 

**Trade-off:** More complex to understand but very efficient

## Determining appropriate rate limits

**Capacity-based approach:**

1. Load test endpoints to find breaking points
2. Apply safety margins (typically 70-80% of maximum)
3. Consider downstream dependencies

**Business-driven approach:**

1. Analyze legitimate usage patterns
2. Set limits above 99th percentile of normal usage
3. Create different tiers for customer segments

**Key metrics to monitor:**

- Hit rate: What percentage of users hit limits?
- Denial patterns: Are denials clustered or distributed?
- Customer impact: Are paying customers affected?
- Recovery time: How long do users stay limited?

## Client-side best practices

Clients should implement:

- **Exponential backoff with jitter** to prevent thundering herd
- **Respect Retry-After headers** when provided
- **Proactive client-side limiting** to avoid hitting server limits
- **Circuit breakers** to fail fast when consistently rate limited

## Rate Limiting Solutions Comparison

|Solution|Best For|Key Consideration|
|---|---|---|
|**Nginx rate limiting**|Simple protection at web server level|Limited to basic request/connection rates|
|**Redis-cell**|Distributed systems needing consistency|Requires Redis infrastructure|
|**AWS API Gateway**|AWS-based serverless applications|Vendor lock-in, cost at scale|
|**Kong Gateway**|Complex microservice architectures|Steeper learning curve|
|**Cloudflare**|Global, public-facing APIs|Limited customization options|
|**Custom Implementation**|Specific business requirements|Development and maintenance burden|

## Key takeaways

1. **Start simple, evolve as needed** - Don't over-engineer initially
2. **Choose algorithms based on requirements** - Token bucket for most cases, GCRA for smooth limiting
3. **Layer your defenses** - Multiple levels provide better protection
4. **Monitor and adapt** - Rate limits should evolve with usage patterns
5. **Design for failure** - Plan for when rate limiting itself fails
6. **Communicate clearly** - Good error messages and headers help clients adapt
7. **Test thoroughly** - Especially distributed behavior and edge cases
8. **Balance protection with user experience** - Limits should be rarely noticed by legitimate users

Rate limiting is not just about preventing abuse—it's about ensuring quality service for all users while protecting your infrastructure. The best rate limiting system is invisible to good actors while effectively stopping bad ones.