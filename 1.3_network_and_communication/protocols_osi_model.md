# Protocols and OSI Model

Understanding network protocols and the OSI model is fundamental to designing distributed systems. This article covers the layered approach to networking, key protocols, and modern communication patterns.

## OSI Model Overview

The Open Systems Interconnection (OSI) model provides a conceptual framework for understanding network communication through seven distinct layers. Each layer has specific responsibilities and communicates only with adjacent layers.

### The Seven Layers

1. **Physical Layer**: Transmits raw bits over physical medium (cables, radio waves)
2. **Data Link Layer**: Handles node-to-node delivery and error detection
3. **Network Layer**: Routes packets between different networks (IP addressing)
4. **Transport Layer**: Ensures reliable end-to-end communication
5. **Session Layer**: Manages connections between applications
6. **Presentation Layer**: Handles data encryption, compression, and format translation
7. **Application Layer**: Provides network services to end-user applications

## TCP/IP Model vs OSI Model

In practice, the TCP/IP model is more commonly used than the theoretical OSI model. It simplifies the seven OSI layers into four practical layers:

| OSI Model Layer                    | TCP/IP Model Layer | TCP/IP Protocol Examples |
| ---------------------------------- | ------------------ | ------------------------ |
| Application, Presentation, Session | Application        | SMTP, HTTP               |
| Transport                          | Transport          | TCP, UDP                 |
| Network                            | Network            | IP, ICMP                 |
| Data Link, Physical                | Network Access     | IEEE 802.2, Ethernet     |

## HTTP Protocol Evolution

HTTP has evolved significantly since its inception, with each version addressing specific performance and security concerns. Currently, **HTTP/1.1 remains the most widely deployed version**, though HTTP/2 adoption is steadily increasing, especially among major websites and CDNs.

### HTTP/1.0
- Single request-response per connection
- No persistent connections
- Simple but inefficient for modern web applications

### HTTP/1.1
- Persistent connections (keep-alive)
- Request pipelining
- Chunked transfer encoding
- Host header support for virtual hosting

### HTTP/2
- Binary protocol instead of text-based
- Multiplexing multiple requests over single connection
- Server push capabilities
- Header compression (HPACK)

### HTTP/3
- Built on QUIC protocol over UDP
- Improved performance over unreliable networks
- Reduced connection establishment time
- Better handling of network changes

## HTTPS/SSL/TLS/mTLS

Security in HTTP communication is achieved through various encryption protocols:

### SSL/TLS
- **SSL (Secure Sockets Layer)**: Legacy protocol, now deprecated
- **TLS (Transport Layer Security)**: Modern replacement for SSL
- Provides encryption, authentication, and data integrity
- Uses asymmetric cryptography for key exchange, symmetric for data transfer

### TLS Handshake Process
1. Client sends supported cipher suites
2. Server responds with chosen cipher and certificate
3. Client verifies certificate and generates pre-master secret
4. Both parties derive session keys
5. Secure communication begins

### mTLS (Mutual TLS)
- Both client and server authenticate each other
- Common in microservices architectures
- Provides stronger security for service-to-service communication
- Requires certificate management infrastructure

## REST Model (Richardson Maturity Model)

Roy Fielding's REST principles are often misunderstood. Leonard Richardson's maturity model helps classify REST implementations:

### Level 0: The Swamp of POX
- Single endpoint for all operations
- Usually POST requests with operation details in payload
- RPC-style over HTTP

### Level 1: Resources
- Multiple URIs for different resources
- Still typically uses POST for everything
- Beginning of resource-oriented thinking

### Level 2: HTTP Verbs
- Proper use of HTTP methods (GET, POST, PUT, DELETE)
- Appropriate HTTP status codes
- Most "RESTful" APIs reach this level

### Level 3: Hypermedia Controls (HATEOAS)
- API responses include links to related actions
- Client discovers available operations dynamically
- True REST according to Fielding's constraints

## Key Takeaways

- OSI model provides conceptual framework; TCP/IP model reflects real-world implementation
- HTTP evolution focuses on performance and multiplexing improvements
- TLS is essential for secure communication; mTLS adds mutual authentication
- Most APIs claiming to be RESTful are actually Level 2 in Richardson's model
- Understanding these fundamentals is crucial for designing reliable distributed systems