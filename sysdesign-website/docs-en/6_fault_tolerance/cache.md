# Caching: Strategic Implementation Patterns and Trade-offs

## Introduction

Caching represents one of the most fundamental performance optimization strategies in distributed systems, yet its implementation requires careful consideration of trade-offs between performance, consistency, and complexity. This comprehensive examination covers the essential aspects of caching strategy, including decision frameworks, implementation patterns, and architectural considerations that determine caching effectiveness at scale.

## Caching Decision Framework

Caching effectiveness depends fundamentally on cache hit ratios and access patterns. While caching appears universally beneficial, inappropriate caching strategies can degrade system performance rather than improve it. Caching provides value only when data retrieval from cache is significantly faster than source retrieval and when cache hit rates justify the overhead.

Two fundamental challenges affect caching effectiveness:

- Cache misses introduce additional latency overhead from cache lookup operations before falling back to primary data sources
- Cache population requires additional computational and storage resources that must be justified by performance improvements

This can even be formalized:

```
AverageTime = DataAccessTime × CacheMissRate + CacheAccessTime
```

Variable definitions:

- _AverageTime:_ average response time from our service.
- _DataAccessTime:_ average data access time — how much time is needed to retrieve data without cache.
- _CacheMissRate:_ the ratio of cache misses to the total number of cache requests. It shows how often the needed data is absent from the cache.


```
Cache Miss Rate = Number of Cache Misses / Total Number of Cache Accesses
```

In the ideal case, if the number of cache misses equals 0, then _CacheMissRate_ also equals zero. According to our formula, this means that data access equals the cache access time:


```
AverageTime = DataAccessTime × 0 + CacheAccessTime = CacheAccessTime
```

In practice, this rarely happens.

Consider a performance analysis with defined parameters:

- DataAccessTime = 100ms
- CacheAccessTime = 20ms

Substituting into the formula: _AverageTime_ = 100 ⋅ _CacheMissRate_ + 20

If cache is not used, access time is always = 100 ms.

Therefore, cache is effective if:

```
AverageTime(withcache) < DataAccessTime(nocache) = 100
```

Let’s substitute:

```
100 × CacheMissRate + 20 < 100
100 × CacheMissRate < 80
CacheMissRate < 0.8
```

Accordingly, if **CacheMissRate** ≥ 0.8, then the cache is ineffective.

Key insights from this analysis:

- Caching is not always able to increase performance
- Calculate your system’s metrics before deciding caching

## Caching Layer Architecture

Modern web applications implement caching at multiple architectural layers, each serving distinct performance optimization objectives. Understanding these layers enables strategic caching decisions that maximize performance benefits while minimizing complexity overhead.

## Client-Side Caching

Client-side caching in a web application is a mechanism for storing data (such as HTML, CSS, JS, images, or even API responses) on the client side (in the browser) to avoid repeated downloads from the server.

This speeds up page loading and reduces server load. Usually, such cache doesn’t require implementation and is managed by HTTP headers:

`Cache-Control`: the main header that determines how and how long to cache.

Examples:

- `Cache-Control: max-age=3600` — cache for 1 hour
- `Cache-Control: no-cache` — cache can be stored, but needs to check freshness with the server
- `Cache-Control: no-store` — don't cache anything

`ETag`: unique hash of the resource, which helps the browser check if it has changed.

On the next request, the client sends this `ETag` in the `If-None-Match` header, and the server checks:

- If the content hasn’t changed, returns `304 Not Modified` (without body)
- If it has changed, returns new content and new `ETag`

`Last-Modified` is an HTTP header that the server sends, indicating the date and time of the resource's last modification.

When making a repeat request, the browser sends the `If-Modified-Since` header, and the server decides:

- If the resource hasn’t changed, responds with `304 Not Modified`
- If it has changed, sends the new content

## CDN

CDN (Content Delivery Network) is a distributed network of servers that cache and serve static content to users from the nearest node.

A typical example: static files (images, JS, CSS, videos, fonts) are cached on CDN servers to:

- Speed up delivery
- Reduce load on the main server (origin)
- Ensure fault tolerance and scaling

CDN implementations utilize two primary content distribution strategies: push CDN and pull CDN architectures.

Pull CDN itself “pulls” content from the origin server as needed.

When a user first requests a resource:

1. The CDN checks: is it in the cache?
2. If not, the CDN sends a request to the origin, receives the content, and stores it (caches it).
3. Subsequent requests are served from the CDN cache.

In Push CDN, you manually upload (push) files to the CDN. Content is already stored on the CDN’s edge servers before user requests.

| Characteristic | Pull CDN | Push CDN |
|---|---|---|
| Content loading | Automatically from origin | Manually or via CI/CD |
| First access | Slow (if not in cache) | Fast (content already there) |
| File management | Simple | Requires more control |
| Used for | Static sites, APIs, PWAs | Videos, large files, releases |

Selection criteria depend on specific use cases and operational requirements:

## Reverse Proxy Caching

Reverse proxy caching is implemented at the reverse proxy level — before the request reaches the application. The goal is to reduce or eliminate request processing by the application if the response was already formed earlier and hasn’t changed.

Consider a typical implementation where Nginx sits in front of the backend and caches responses to `/products/123`.

When responses are recently generated and cached, Nginx serves them directly without forwarding requests to the application layer.

Suitable for:

- Static pages
- Partially dynamic content with long TTL
- WordPress, Django, etc., where HTML is generated on the server

## Application Service Caching

Application caching works inside the application code. Most often this is:

- in-memory cache (e.g., `Map`, `ConcurrentHashMap`, `Guava Cache`)
- distributed cache (e.g., `Redis`, `Memcached`)

The application itself determines what, when, and how to cache.

## DB Caching

Modern databases implement extensive internal caching mechanisms (Buffer Pool, Page Cache, Query Plan Cache), which operate transparently. This section focuses on application-level database caching strategies for frequently accessed data and query results.

This mechanism can be implemented at two levels.

**Query-level caching**

Query-level caching stores the results of frequently executed SQL queries in memory. When the same query is executed again, the result is returned from the cache rather than making a new query to the database. This reduces DB load and speeds up system response.

**Object-level caching**

Object-level caching stores individual data objects or records retrieved from the database. This approach is useful when certain objects are requested frequently or when data in the database is relatively stable. It reduces the need for frequent database access and improves overall application performance.

## Conclusion

The caching mechanism is multi-layered. Each layer is important and protects the next one from having to process the request. Competent design of multi-layered caching is key to performance and scalability.

![Caching Layers](/img/caching_layers.png)

## Cache Invalidation Strategies

Invalidation strategies determine when and how cached data becomes stale and requires refresh or removal. Effective invalidation ensures data consistency while maintaining performance benefits across distributed caching layers.

## TTL

**TTL (Time To Live)** is the lifetime of a cached value. After this period expires, the data is considered stale and must be updated or deleted.

TTL is set at the moment of placing data in the cache or is taken from a default value.

The optimal TTL value depends on:

- the nature of the data,
- required freshness,
- cost of updating,
- caching level.

If **TTL** is too small, data will quickly become invalid, which in most cases will lead to a high **Cache Miss Rate**.

If **TTL** is too large, users will receive stale data for a long time, which can be critical in some business scenarios.

There’s also a less obvious problem — identical **TTL** for all entries. If the lifetime expires for a large number of keys simultaneously, thousands of requests for data updates may hit the backend. This phenomenon is called **cache stampede**. To avoid it, **jitter** is used — randomization of **TTL** within a given range (for example, TTL ± 10%). This helps distribute the load over time.

Another similar situation is the **Thundering Herd Problem**. It occurs when multiple requests simultaneously access a key whose lifetime has expired. All these requests begin to compute the same value for the cache in parallel, which can drastically reduce system performance. If you encounter this problem, it’s worth considering alternative strategies for managing lifetime and updating data in the cache.

| Component | TTL | Typical TTL | What to cache | Jitter | Features |
|---|---|---|---|---|---|
| Browser | Via HTTP headers (`Cache-Control`, `Expires`) | 5 minutes – several days | Static: CSS, JS, images; sometimes API responses | Not applied | |
| CDN | Via `Cache-Control`, can be set forcibly | 5 minutes – several hours | HTML, JSON, media files | Usually not needed | |
| Proxy server | Configured manually | 1–30 minutes | HTML, API responses, auth tokens | Optional | Can use `stale-while-revalidate` strategy |
| Application server | Fully customizable | From seconds to days | DB results, calculations, authorizations, sessions | Recommended | Jitter is especially important for mass reading of cached data |

## Event-Based Invalidation

Event-based cache invalidation is a mechanism where the cache is cleared or updated at the moment data changes, rather than when TTL expires.

When the data source (for example, DB or API) is updated, an event is sent to the system that deletes or updates the corresponding entry in the cache.

**Examples of events:**

- User profile update
- Product deletion
- Feature settings change
- Saving a new report

**Invalidation Options**

1. **Deletion (invalidate / evict)** — when data changes, related entries are removed from the cache. On the next request, data will be reloaded from the source.
2. **Update (refresh)** — if the new value is known at the moment of the event, the cache can be immediately updated, bypassing the step of re-querying the source.

In practice, the **refresh** strategy is more common, however in some cases deletion (**invalidate**) may be preferable — for example, if updating data in the cache is too expensive or the risk of getting an inconsistent value is high.

**Event Delivery Options**


| Approach | Mechanism | Usage Example | Technologies / Tools |
|---|---|---|---|
| Direct synchronous call | When updating an object, the application immediately calls cache invalidation | Updating user profile immediately clears cache | — |
| Asynchronous call (Pub/Sub) | Service A updates data and publishes event `userUpdated(id=123)`. Service B invalidates cache upon receiving event | User update → event invalidates cache in third-party service | Kafka, RabbitMQ, Redis PubSub, AWS SNS/SQS |

## Cache Versioning

**Cache versioning** is a technique where a version identifier is added to the key (or URL) of a cache entry. When a new version of the application or data is released, this identifier changes, and the browser, CDN, or other caching layer treats the entry as new, requesting it again.

**What is a version and where to insert it**

A version is any label that is guaranteed to change when content changes:

- content hash (`app.a8c3f7.js`);
- build number (`/static/20250805/app.js`);
- query parameter (`?v=2025-08-05`);
- key prefix in Redis (`v3:user:42`);
- bucket name in CacheStorage (`my-site-v4`).

What matters is not how exactly it looks, but that different versions have different keys.

The choice of approach depends on system specifics: in web, hashes and URL versions are more important; in APIs — endpoint versioning; in in-memory caches — versions in keys.

Properly configured versioning reduces load, improves user experience, and simplifies project maintenance.

## Cache Tagging

Cache tagging is a method of organizing and managing cached data using tags that allow logical grouping and efficient invalidation of related cache entries.

Instead of caching data by individual keys and invalidating each entry manually, tagging allows assigning common tags to multiple entries and deleting them in bulk by referencing that tag.

## Why is cache tagging needed

**Mass and precise invalidation**

When data changes, you need to clear only those cache entries that relate to it quickly. Examples:

- User updated — need to reset all cache entries associated with this user.
- Article changed — need to reset the cache of the article page and related data (comments, meta-information, etc.).

**Logical data grouping**

Tagging helps better structure the cache. For example:

- Tag `user:123` can be applied to profile, order list, and user settings.
- Tag `product:456` — to product card, reviews, and search results with this product.

**Efficiency improvement**

Tagging minimizes invalidation errors and improves performance — no need to manually search and iterate through cache keys.

# Cache Eviction Algorithms

Cache capacity limitations require systematic approaches to data eviction when storage limits are reached. Eviction algorithms determine which cached data to remove, directly impacting cache hit ratios and overall system performance. Optimal eviction strategies balance cache hit maximization with implementation complexity.

## FIFO (First-In, First-Out)

**Principle**: first in — first out. The oldest elements are removed first.

**Pros**:

- Simple implementation.
- Suitable if the order of data arrival is more important than relevance.

**Cons**:

- Ignores frequency and recency of use.
- May evict frequently used data.

**Application**: when simplicity is more important than performance, for example in resource-limited embedded systems.

## LRU (Least Recently Used)

**Principle**: the least recently used element is evicted. It comes from the idea that if data hasn’t been accessed for a long time, it can be removed.

**Pros**:

- Good performance in typical access scenarios.
- Based on the assumption that recently used data is more likely to be needed again.

**Cons**:

- More complex implementation (requires doubly linked list and hash table).
- May work poorly with cyclic access to large volumes of data.

**Application**: browser cache, databases, file systems.

## LFU (Least Frequently Used)

**Principle**: the element that was used least frequently is removed. Similar to LRU, but considers frequency of data rather than recency of access.

**Pros**:

- Takes into account data popularity.
- Works well with stable access patterns.

**Cons**:

- Requires tracking access count, which complicates implementation.
- May retain outdated but previously popular data.

**Improvement variants**:

- **LFU with Aging** — periodic reduction of counters. Each time period (or with each access), counters of all elements are decreased by a certain amount. Thus, old and long-unused elements gradually “lose weight” and can be evicted.

**Application**: caching in long-lived services where access patterns are stable, and the goal is to keep in cache those elements that are used most _frequently_, not just recently.

## MRU (Most Recently Used)

**Principle**: The **most recently** used element is removed. This is useful in scenarios where if data was just used, it’s highly likely it won’t be needed in the near future. That is, the access pattern is opposite to what LRU is designed for.

**Pros**:

- Effective for sequential data access (after use, element is rarely needed again).
- Quickly frees cache for new data in streaming and batch scenarios.
- Can reduce redundant storage of unnecessary data when linearly processing large files or sets.

**Cons**:

- Works poorly with temporal locality (often removes data that will soon be needed).
- Highly dependent on access pattern, gives low cache hit in universal scenarios.
- Ineffective with cyclic or repetitive data processing.
- Often reduces performance compared to LRU in typical applications.
- May increase I/O load due to more cache misses.

**Application**:

- **Sequential access** to data:
- Stream reading of files (e.g., media files, large databases during export).
- Batch processing, where data is used once.
- **I/O buffers** in DBMS for temporary tables and scans.
- **Processing large datasets**, when each element is used only briefly and then no longer needed.
- **ETL processes** (Extract-Transform-Load), where data goes through stages and doesn’t return to previous ones.

## Random Replacement (RR)

**Principle**: a random element is removed.

**Pros**:

- Very simple implementation.
- Avoids “pattern sticking” and doesn’t require complex data structures.

**Cons**:

- Unpredictable performance.
- Frequent replacement of useful data is possible.

**Application**: systems with limited computational resources (e.g., in hardware).

## Second Chance

**Principle**: modified version of FIFO, where each element gets a “second chance” when being evicted. Instead of immediate deletion, the use bit is checked: if set, the element is moved to the end of the queue and the bit is reset; if not — the element is deleted.

**Pros**:

- Simple implementation with minor modification to FIFO.
- Considers whether element was used recently, increasing cache hit compared to pure FIFO.
- Balance between simplicity and considering data relevance.

**Cons**:

- Doesn’t consider frequency of use, only fact of last access.
- With many active elements, all may get “second chance,” reducing efficiency.
- Slightly more complex than pure FIFO (needs use bit).

**Application**:

- Operating systems for memory page management (including UNIX/Linux).
- Caching in resource-limited systems where FIFO needs slight improvement without implementing complex algorithms.
- I/O buffers in file systems.

## Clock

**Principle**: optimized implementation of Second Chance, where elements are arranged in a circle, and a pointer (“clock hand”) passes through them. During eviction, the use bit is checked: if 0 — element is deleted; if 1 — bit is reset, and pointer moves on until finding a deletion candidate.

**Pros**:

- Saves memory compared to classic Second Chance (no need to move elements in queue).
- Time-efficient — traversal is cyclic, without restructuring.
- Simple and fast implementation with many elements.

**Cons**:

- Like Second Chance, considers only recent use, not frequency.
- With many active pages, may search long for eviction victim.
- Works worse in scenarios with fast random access where many elements have bit 1.

**Application**:

- Virtual memory management in OS (Windows, Linux).
- Page buffers in DBMS (PostgreSQL, Oracle).
- Disk block cache in file systems.

## 2Q (Two Queues)

**Principle**: algorithm uses two queues — one for new elements (FIFO), second for frequently used (LRU). New element first enters FIFO queue; if used again, moves to LRU queue. On overflow, eviction occurs from FIFO or LRU depending on settings.

**Pros**:

- Considers both relevance and frequency of use.
- Avoids LRU problems with “one-time noise” — randomly loaded and no longer needed data is quickly evicted.
- Flexibly configurable for different access patterns.

**Cons**:

- More complex than LRU or FIFO.
- Requires tuning each queue’s size for optimal performance.
- With incorrect configuration, may work worse than simpler algorithms.

**Application**:

- Cache in databases (e.g., PostgreSQL for page buffer).
- File systems and disk caches where filtering “one-time” data is important.
- Web servers and proxy servers with high load and mixed request patterns.

## SLRU (Segmented LRU)

**Principle**: cache is divided into two segments — **probationary** and **protected**. New element first enters probationary segment, working by LRU. If element is reused, it moves to protected segment (also LRU). On overflow, eviction first occurs from probationary segment.

**Pros**:

- Well filters “one-time” data.
- Frequently used elements stay longer in cache.
- Considers both frequency and relevance of use.
- More predictable behavior compared to classic LRU under mixed loads.

**Cons**:

- More complex than LRU or FIFO.
- Requires segment size tuning for optimal performance.
- With incorrect configuration, may behave like regular LRU, losing advantages.

**Application**:

- File systems (e.g., in ZFS).
- Cache in databases (PostgreSQL, Oracle).
- Proxy servers and CDN where protecting “long-lived” popular data from eviction by random traffic is important.

## TLRU (Time Aware LRU)

**Principle**: LRU modification where each element has lifetime (TTL). During eviction or access, algorithm considers not only recency of use but also remaining time until TTL expiration. Elements with expired lifetime are deleted first, even if recently used.

**Pros**:

- Allows considering data relevance period.
- Prevents storing outdated information in cache.
- Works well for data with known expiration time (e.g., prices or quotes).

**Cons**:

- Requires storing and checking additional metadata (TTL).
- Increases implementation complexity compared to LRU.
- May prematurely evict data that could still be useful if TTL is set too strictly.

**Application**:

- Financial systems for caching prices, rates, exchange rates.
- CDN and web caches where resources have explicit expiration.
- IoT and telemetry when data loses value after certain time period.

## LRU-K

**Principle**: LRU extension that considers not only last access but also **K-th last access** to element. Access history is maintained for each element, and during eviction, those with oldest K-th last access are chosen. This helps distinguish random one-time accesses from stably frequently used data.

**Pros**:

- Effectively filters “one-time noise” in cache.
- Better adapts to real usage patterns than classic LRU.
- Can keep in cache elements used with certain regularity, even with large intervals between accesses.

**Cons**:

- More complex implementation and higher memory requirements (storing access history).
- Requires tuning parameter K — with wrong choice, algorithm may lose efficiency.
- Increases overhead for updating statistics with each access.

**Application**:

- DBMS (e.g., Oracle, PostgreSQL) for page buffer management.
- File systems and disk caches where keeping frequently used but not necessarily “fresh” data is important.
- Scenarios with reuse after long pauses (scientific calculations, analytical queries).

## ARC (Adaptive Replacement Cache)

**Principle**: adaptive combination of LRU and LFU. Cache is divided into four lists:

- **T1** — recently used elements (LRU analog).
- **T2** — frequently used elements (LFU analog).
- **B1** — “ghosts” of recently evicted elements from T1 (metadata only).
- **B2** — “ghosts” of frequently evicted elements from T2.

The algorithm dynamically adjusts the size of T1 and T2 based on which list elements return more often on repeated requests.

**Pros**:

- Self-adapts to load type (more LRU or more LFU).
- Considers both relevance and frequency of use.
- Effective with changing access patterns.
- Guarantees performance no worse than LRU in the worst case.

**Cons**:

- More complex implementation and higher overhead compared to LRU.
- Requires storing additional meta-information (ghost lists).
- For very small caches, overhead may outweigh benefit.

**Application**:

- DBMS (e.g., IBM DB2, PostgreSQL through extensions).
- Data storage systems and file systems (ZFS, Lustre).
- High-load web caches and proxies where load changes over time.

## LIRS (Low Inter-reference Recency Set)

**Principle**: algorithm that improves LRU by analyzing the **distance between repeated accesses** (reuse distance) and dividing elements into:

- **LIR** (Low Inter-reference Recency) — frequently used with small interval between accesses, stay in cache.
- **HIR** (High Inter-reference Recency) — elements with large interval between accesses, stored in cache only temporarily.

LIRS dynamically moves elements between LIR and HIR depending on actual access patterns.

**Pros**:

- Significantly reduces the impact of “one-time noise” compared to LRU.
- Retains data with real repeat demand even with large intervals between accesses.
- More effective than LRU in scenarios with a large working dataset and complex access patterns.

**Cons**:

- More complex than LRU, it requires maintaining two structures (stack and queue).
- Higher overhead for updating structures with each access.
- Doesn’t always give a benefit in scenarios with simple patterns (where LRU is already optimal).

**Application**:

- Data storage systems and DBMS (MySQL, PostgreSQL) for page buffer optimization.
- File systems with high performance requirements (e.g., Linux VFS).
- High-load caches in web applications and CDN, where traffic is unpredictable and contains noise.

## OPT (Optimal Replacement, aka Belady’s Algorithm)

**Principle**: theoretically optimal eviction algorithm that always removes element **that will be needed furthest in the future** (or not needed at all). Works knowing complete order of future data accesses, so in real systems used only for modeling and evaluating effectiveness of other algorithms.

**Pros**:

- Guarantees minimum possible number of cache misses.
- Serves as benchmark for comparing other algorithms.
- Helps in research and tuning cache algorithms.

**Cons**:

- Impossible to implement in real-time (need to know future).
- Can only be used in simulations, profiling, or offline analysis.
- Doesn’t account for real overhead of maintaining data structures.

**Application**:

- Modeling and testing caching algorithms.
- Analysis and comparison of strategies in scientific research.
- Educational materials for understanding caching efficiency limits.

## Cheat-sheet

| Algorithm | Frequency | Recency | TTL | Complexity | Notes |
|---|---|---|---|---|---|
| FIFO | ✗ | ✗ | ✗ | Simple | Simple, but blind to relevance |
| LRU | ✗ | ✓ | ✗ | Medium | Widely applicable |
| LFU | ✓ | ✗ | ✗ | Medium | Often retains "old" data |
| MRU | ✗ | ✓ | ✗ | Simple | Unique use cases |
| RR | ✗ | ✗ | ✗ | Simple | Minimal resources |
| Second Chance | ✗ | ✓ | ✗ | Medium | FIFO improvement |
| Clock | ✗ | ✓ | ✗ | Medium | Memory efficient |
| 2Q | ✓ | ✓ | ✗ | Complex | Resistant to cycles |
| SLRU | ✓ | ✓ | ✗ | Complex | Segmented LRU |
| TLRU | ✗ | ✓ | ✓ | Medium | Considers lifetime |
| LRU-K | ✓ | ✓ | ✗ | Complex | Considers multiple accesses |
| ARC | ✓ | ✓ | ✗ | High | Adaptive and balanced |
| LIRS | ✓ | ✓ | ✗ | High | High accuracy |
| OPT | ✓ | ✓ | ✗ | Theory | Benchmark, not implementable |

# Caching Strategies

Choosing the right eviction algorithm is only part of the task. It’s equally important to determine the caching strategy, that is, how and when data enters the cache and synchronizes with the main storage.

The optimal strategy directly depends on the nature of the workload. In real systems, data access patterns can differ dramatically:

- In some cases, **reads** predominate (**read-intensive**), and the main goal is to minimize latency when serving data, maximizing cache hit.
- In others — writes make up most operations (**write-intensive**), and data consistency and minimizing synchronization overhead with storage come to the forefront.

Understanding which type of load dominates allows choosing a strategy that will provide optimal balance between performance, consistency, and operation cost. Next, we’ll examine how different approaches work under predominantly read or write conditions.

![Caching Strategies](/img/caching_strategies.png)

# Read-intensive

When read operations predominate in a system, the main goal is to maximize cache hits and reduce latency when retrieving data. Strategies are used here that allow quickly delivering relevant information with minimal requests to the main storage.

## Cache-aside

**Principle**: the application manages the cache itself. When requesting data, it first checks the cache; if data isn’t there (cache miss) — it’s loaded from storage, placed in cache, then returned to the user.

**Pros**:

- Simple implementation.
- Flexibility: application decides what and when to cache.
- Easy to integrate into existing architecture.

**Cons**:

- First request for new data will always be a cache miss.
- Application must explicitly manage updating and deleting data in cache.

**Application**: web applications, API gateways, services with variable datasets.

## Read-through

**Principle**: application always accesses the cache, which loads data from storage when necessary and stores it itself.

**Pros**:

- Simplifies application code — loading logic is hidden in cache.
- Guarantees data will be placed in cache automatically on first request.

**Cons**:

- More complex implementation of caching layer.
- May be harder to control update strategy.

**Application**: systems with frequent repeated reads where minimizing cache miss without complex application logic is important.

## Refresh-ahead

**Principle**: cache updates data in advance, before TTL expiration, if it’s predicted they’ll be needed soon.

**Pros**:

- Reduces cache miss probability for frequently requested data.
- Users receive fresh data without delay for loading from storage.

**Cons**:

- May load unnecessary data that won’t ultimately be used.
- Requires mechanism for predicting data demand.

**Application**: CDN, news portals, trading platforms, systems with predictable request peaks.

# Write-intensive

When write operations predominate in a system, the key task is to ensure **data consistency between cache and storage**, while minimizing delays and load on main storage. Strategy choice depends on what’s more critical: reliability and consistency or write speed.

## Write-through

**Principle**: write goes first to cache, then synchronously to main storage.

**Pros**:

- High data consistency.
- Simple recovery logic after failure — data is already in storage.

**Cons**:

- Write is slower as it goes synchronously to two places.
- Increased load on storage.

**Application**: financial systems, accounting databases, applications critical to data loss.

## Write-around

**Principle**: write goes directly to storage, bypassing cache; cache is updated only when reading data.

**Pros**:

- Reduced cache load during mass writes.
- Prevents evicting useful data from cache with data that may not be needed.

**Cons**:

- Subsequent read of new element will be cache miss.
- Data in cache may be outdated until first read.

**Application**: systems with rare re-reading of recently written data, logging, stream writing.

## Write-back

**Principle**: write goes only to cache, and data is sent to main storage asynchronously.

**Pros**:

- High write speed.
- Reduced storage load with multiple updates of same element.

**Cons**:

- Risk of data loss if cache fails before synchronization with storage.
- More complex implementation of synchronization mechanism.

**Application**: high-load systems, temporary buffers, scenarios with frequent updates of same dataset.

# Conclusion

Caching is not a magic “speed up” button, but an engineering discipline with many levels, strategies, and algorithms, each of which must be selected for the specific context.

The erroneous approach of “just cache it” often leads to the opposite effect: cache misses increase delays, stale data breaks business logic, and poor eviction algorithms or write strategies reduce performance.

Effective caching architecture requires:

- understanding the nature of the load (read-intensive, write-intensive, or mixed);
- choosing an appropriate strategy for data entry and validation;
- configuring eviction algorithms considering access patterns;
- proper TTL, tagging, and when necessary, versioning.

Proper caching design is a balance between speed, consistency, and resources. And the sooner this balance is found in a project, the less chance that cache will become a bottleneck rather than an acceleration tool.

Cache should be **transparent, predictable, and measurable**, and the decision to use it should be the result of metrics analysis, not intuition. That’s when it will stop being “just another optimization” and become a full-fledged architectural element.