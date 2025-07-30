# Performance Metrics and Scaling Thresholds

Understanding when and how to scale requires knowing typical performance values and recognizing bottleneck patterns. This guide provides real-world metrics that trigger scaling decisions.

## Core Performance Metrics

### RPS (Requests Per Second)
- **Definition**: Number of requests processed per second
- **Key consideration**: Sustained vs peak load capacity

### Latency (P50, P95, P99)
- **P50**: 50% of requests complete within this time
- **P95**: 95% of requests complete within this time  
- **P99**: 99% of requests complete within this time
- **Critical**: P99 latency often drives user experience

### Throughput
- **Data throughput**: MB/s or GB/s of data processed
- **Transaction throughput**: Operations completed per second
- **Different from RPS**: One request can involve multiple operations

### CPU Utilization
- **Safe operating range**: 60-70% sustained
- **Alert threshold**: 80%+ sustained
- **Scaling trigger**: Consistent 85%+ usage

### Memory Usage
- **JVM applications**: Scale when heap usage >80%
- **Native applications**: Scale when RAM usage >85%
- **Include garbage collection overhead**

### I/O Operations (IOPS)
- **Disk IOPS**: Read/write operations per second
- **Network IOPS**: Network packets per second
- **Database IOPS**: Query operations per second

### Network Bandwidth
- **Inbound/outbound data transfer rates**
- **Typically measured in Mbps or Gbps**
- **Consider both sustained and burst capacity**

### Connection Pool Utilization
- **Database connections**: Active vs total pool size
- **HTTP connections**: Keep-alive connection usage
- **Scale trigger**: >80% pool utilization

### Queue Depth/Length
- **Message queue backlog size**
- **Request queue length**
- **Processing lag indicators**

## Typical Production Values by System Type

### Web Applications
**NGINX**
- **RPS**: 10K-50K+ simple requests
- **Latency**: <1ms for static content
- **CPU**: 1-2% per 1K RPS for static content

**Apache HTTP Server**
- **RPS**: 1K-5K requests (traditional MPM)
- **Memory**: ~8MB per worker process
- **Connection limit**: 256-400 concurrent by default

**Node.js Applications**
- **RPS**: 5K-15K for simple APIs
- **Latency**: 10-50ms for typical API calls
- **Memory**: 50-200MB typical heap size

### Databases

**PostgreSQL**
- **QPS**: 5K-15K simple queries
- **Connections**: 100-200 max concurrent (default config)
- **Latency**: <1ms for indexed lookups, 10-100ms for complex queries
- **Scale trigger**: >80% connection pool usage

**MySQL**
- **QPS**: 10K-30K simple queries  
- **Connections**: 151 default max
- **InnoDB buffer pool**: Should be 70-80% of RAM
- **Scale trigger**: Slow query log shows >100ms queries

**Redis**
- **OPS**: 100K-1M+ operations per second
- **Latency**: <1ms for simple operations
- **Memory**: Scale when >80% of maxmemory
- **Network**: Can saturate 1Gbps network before CPU

**MongoDB**
- **OPS**: 10K-50K document operations
- **Connections**: 65,536 max by default
- **WiredTiger cache**: 50% of RAM minus 1GB
- **Scale trigger**: Working set > RAM

### Message Brokers

**Apache Kafka**
- **Throughput**: 100MB/s - 1GB/s per broker
- **Messages**: 100K-1M+ messages/second
- **Latency**: 2-5ms end-to-end
- **Partitions**: 100-1000 per broker optimal

**RabbitMQ**
- **Messages**: 10K-50K messages/second
- **Latency**: 1-5ms
- **Memory**: Scale when >80% RAM usage
- **Connections**: 1000+ concurrent connections

**AWS SQS**
- **Standard queues**: 3,000 messages/second per action
- **FIFO queues**: 300 messages/second (or 3,000 with batching)
- **Latency**: 10-50ms typical

### Load Balancers

**HAProxy**
- **Connections**: 100K+ concurrent connections
- **RPS**: 50K+ requests per second
- **Latency**: <1ms added latency
- **CPU**: 1 core can handle 10K-20K RPS

**AWS Application Load Balancer**
- **RPS**: 25 new connections/second per target (default)
- **Latency**: 1-5ms added latency
- **Auto-scaling**: Automatic capacity scaling

**NGINX Plus**
- **RPS**: 100K+ requests per second
- **Connections**: Limited by system resources
- **Health checks**: Sub-second failure detection

### API Gateways

**Kong**
- **RPS**: 10K-50K requests per second
- **Latency**: 1-3ms added latency per plugin
- **Memory**: 50-200MB base usage

**AWS API Gateway**
- **REST API**: 10,000 RPS default limit
- **HTTP API**: 10,000 RPS default limit  
- **Latency**: 5-15ms added latency

## Vertical Scaling Thresholds

### CPU-bound Scenarios
**Scale up when**:
- Single-threaded applications hitting CPU limits
- Complex computation workloads
- Encryption/decryption operations

**Scale out when**:
- Multi-threaded applications
- Web request processing
- Parallel data processing

**Example**: Single-core Redis instance at 100% CPU → scale up to multi-core machine or scale out with Redis Cluster

### Memory-bound Scenarios
**Scale up triggers**:
- JVM heap usage >85%
- Database buffer pool hit ratio <95%
- Cache hit ratio dropping significantly
- Frequent garbage collection pauses

**Scale out triggers**:
- Memory requirements exceed largest available instance
- Working set larger than single machine RAM
- Need fault tolerance across machines

**Example**: PostgreSQL with 32GB RAM, buffer pool at 28GB usage → either scale up to 64GB RAM or implement read replicas

### I/O-bound Scenarios
**Disk I/O scaling**:
- IOPS utilization >80%
- Disk queue length consistently >10
- Read/write latency >10ms for SSDs

**Network I/O scaling**:
- Network utilization >70% of bandwidth
- Packet loss >0.1%
- Network queue depth increasing

**Example**: Database with 10K IOPS limit hitting 9K IOPS → scale to higher IOPS storage or distribute across multiple databases

### Single-threaded Limitations
**Redis**: Single-threaded event loop
- **Scaling point**: CPU core at 100%
- **Solution**: Redis Cluster for write scaling, read replicas for read scaling

**Node.js**: Single-threaded event loop
- **Scaling point**: Event loop delay >10ms
- **Solution**: PM2 cluster mode or multiple instances

## Horizontal Scaling Thresholds

### Stateless Service Scaling
**RPS-based scaling**:
- Target: 70% of max RPS capacity
- Scale out when: Sustained load >70% capacity
- Scale in when: Load <30% capacity for >10 minutes

**Latency-based scaling**:
- P95 latency increases >50% from baseline
- P99 latency >500ms for user-facing services
- Error rate >0.1%

**Example**: API service handling 7K RPS with 10K RPS capacity → trigger horizontal scaling

### Database Scaling
**Connection limits**:
- PostgreSQL: Scale when >80% of max_connections
- MySQL: Scale when connection pool exhaustion occurs
- Solution: Read replicas or connection pooling (PgBouncer, ProxySQL)

**Query performance**:
- Slow query percentage >5%
- Average query time increases >2x baseline
- Lock wait time increasing

**Example**: PostgreSQL with 200 max connections, seeing 170 active → add read replicas or scale up

### Cache Scaling
**Memory pressure**:
- Redis memory usage >80%
- Cache eviction rate increasing
- Hit ratio dropping below 95%

**Hotspot patterns**:
- Uneven key distribution
- Single Redis instance CPU at 100%
- Network bandwidth saturation

**Example**: Redis cluster with uneven key distribution, one node at 90% memory → rebalance shards or add nodes

### Queue Scaling
**Message backlog**:
- Queue depth growing consistently
- Processing lag >acceptable SLA
- Consumer lag increasing

**Processing rates**:
- Consumers can't keep up with producers
- Message processing time increasing
- Dead letter queue accumulating messages

**Example**: Kafka topic with 1M message backlog growing by 10K/minute → add consumer instances or partitions

## Sharding Decision Points

### Database Sharding Triggers

**Storage size**:
- Single database >1TB (PostgreSQL/MySQL performance degradation)
- Backup/restore time >acceptable maintenance window
- Index size doesn't fit in memory

**Query performance**:
- Table scans taking >5 seconds
- Join operations across large tables degrading
- Index maintenance overhead significant

**Connection limits**:
- Max connections reached regularly
- Connection pooling not sufficient
- Geographic distribution requirements

**Examples**:
- **Instagram**: Sharded PostgreSQL when photos table hit billions of rows
- **Slack**: Sharded by team/workspace when single DB couldn't handle write load

### Application Sharding

**CPU thresholds**:
- Single instance consistently >85% CPU
- Response time degrading under load
- Vertical scaling reaches hardware limits

**Memory thresholds**:
- Heap usage >80% causing GC pressure
- Working set doesn't fit in single machine
- Memory leaks in long-running processes

**Request volume thresholds**:
- Single instance handling >capacity limit
- Geographic latency requirements
- Fault tolerance requirements

**Example**: Microservice handling 50K RPS when capacity is 30K RPS → shard by user ID or geographic region

### Cache Sharding

**Memory limits**:
- Single Redis instance approaching memory limit
- Eviction policy causing cache misses
- Dataset larger than largest available instance

**Hotspot patterns**:
- Uneven key access patterns
- Single instance CPU bottleneck
- Network bandwidth saturation on single node

**Access patterns**:
- Geographic access patterns
- Time-based access patterns  
- User-based access patterns

**Example**: Redis cache with 80% memory usage and hot keys causing CPU spikes → implement consistent hashing across multiple nodes

## Real-World Scaling Examples

### Netflix
**Challenge**: 200M+ users, 1B+ hours watched daily
**Metrics**: 
- 15M+ RPS during peak hours
- <100ms startup time requirement
- 99.99% availability target

**Scaling approach**:
- Microservices: 1000+ services
- Auto-scaling: Based on CPU, memory, and custom metrics
- Geographic distribution: Regional deployments
- Chaos engineering: Proactive failure testing

### Twitter
**Challenge**: 500M+ tweets/day, real-time timeline generation
**Metrics**:
- 6K tweets/second average, 143K peak
- Timeline generation <200ms
- 400M+ active users

**Scaling approach**:
- Read scaling: Massive fan-out to pre-computed timelines
- Write scaling: Sharded MySQL, Redis clusters
- Real-time: Separate infrastructure for trending topics
- Caching: Multi-level cache hierarchy

### Reddit
**Challenge**: 50M+ daily active users, 100K+ communities
**Metrics**:
- 25M+ comments/day
- <2 second page load time
- High read-to-write ratio (100:1)

**Scaling approach**:
- Database sharding: By subreddit and time
- Caching: Aggressive caching at multiple levels  
- CDN: Static content distribution
- Queue-based: Async processing for votes, comments

### Discord
**Challenge**: 150M+ monthly users, real-time messaging
**Metrics**:
- Billions of messages daily
- <150ms message delivery
- 99.9% uptime requirement

**Scaling approach**:
- Sharded MongoDB: By guild (server)
- Message queues: Custom Elixir-based system
- Voice infrastructure: Separate scaling for voice/video
- Edge presence: Global gateway distribution

### Shopify
**Challenge**: Black Friday traffic spikes, e-commerce transactions
**Metrics**:
- 10.3M orders during 2023 Black Friday weekend
- 61% traffic increase peak vs normal
- <3 second checkout completion

**Scaling approach**:
- Horizontal scaling: Auto-scaling based on queue depth
- Database scaling: Read replicas and write scaling
- Cache warming: Predictive cache population
- Rate limiting: Protect core services during spikes