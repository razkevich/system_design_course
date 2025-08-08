# System Design: Why You Can't Have Everything at Once (CAP and PACELC Without Excessive Theory)

## Introduction

Any technical solution includes a series of conditions and compromises that are important to understand yourself and be able to communicate to your team and management.

When discussing system design, we usually talk about factors such as development and maintenance costs, fault tolerance, availability, scalability, and others.

As you might guess, it's very difficult, and sometimes impossible, to achieve all these conditions simultaneously.

In fact, the CAP theorem and its extension PACELC are simple and clear examples of such compromises.

## CAP Theorem

Let's refer to the Wikipedia definition.

The CAP theorem (also known as Brewer's theorem) is a heuristic statement that in any implementation of distributed computing, it's possible to provide no more than two of the following three properties:

- **Consistency** — at all computing nodes at the same point in time, data does not contradict each other.
- **Availability** — any request to a distributed system completes with a response, however without guarantee that the responses of all nodes match.
- **Partition tolerance** — splitting a distributed system into several isolated sections does not lead to incorrect responses from each of them.

![[cap.png]]

In my opinion, after such a definition, a normal person only has more questions:

- Why only two out of three? Why can't we have everything at once?
- What does "consistency" mean? Is it like in ACID?
- What is "network partition"? Is it like when the internet goes down?
- How can a developer understand what's more important: C, A, or P? Are there any tips?

Let's try to figure it out.

The CAP theorem is often incorrectly interpreted as requiring always giving up one of the three guarantees. In reality, the choice between consistency and availability only arises in case of network partitions or failures.

### What does this mean in practice?

If the system is **CP (Strong Consistency)**, then in case of network errors, you choose data consistency. If one of two nodes fails, then some users may not be able to reach your application — but data integrity won't be compromised.

By data integrity here we mean the following: if you write something to the database, that's exactly what will be stored there. Moreover, after network recovery, there won't be data conflicts — for example, it won't happen that on one node the account balance is 100, and on another it's 200.

If the system is **AP (High Availability)**, then in case of network problems, priority is given to availability — at the expense of consistency.

In practice, this means that you can always write or read something, but:

- the data you read may be outdated;
- changes you write may not immediately be visible to other users.

There are many "weak" consistency models, each with its own nuances — but we won't consider them now.

As already mentioned, all this only makes sense when there are network failures or partitions.

At all other times, the compromise should be considered from the perspective of the PACELC theorem.

## PACELC

The PACELC theorem is a more nuanced and detailed version of the CAP theorem.

It states that:

- In case of network **Partition** in a distributed system, you need to choose between **Availability** and **Consistency** — as described in the classic CAP theorem;
- **Else** — that is, when the system is working normally and there are no partitions — you have to choose between **Latency** and **Consistency**.

This compromise arises naturally: to ensure resilience to failures and partitions, data and services are replicated, often between data centers or geographically distant nodes. This, in turn, leads to the need to choose between the level of consistency and the associated latency.

![[cap2.png]]

In simple terms, when striving to ensure strong consistency, the system needs to use synchronous replication, guaranteeing that all replicas contain up-to-date data.

For example, if we have three servers, and one of them receives a request to increase a user's balance by $100, then:

1. The data is first written to this server;
2. Then a similar request is sent to two other replicas;
3. The system waits for write confirmation from all three nodes;
4. And only after that considers the operation complete.

This naturally increases latency, proportional to the number of replicas.

On the other hand, if the system uses asynchronous replication and doesn't wait for responses from other nodes, then ensuring strict consistency is impossible in principle.

In such cases, the system supports so-called **eventual consistency** — that is, over time all replicas come to the current state and reflect the latest version of the data.

## Summary

The CAP and PACELC theorems are important concepts in distributed systems design. They set the framework for understanding the inevitable trade-offs that engineers face when creating highly available systems with data consistency requirements.