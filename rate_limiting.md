How should we design a SaaS application to deal with a rise in incoming traffic? Of course, the answer is to design it for scalability to handle increased load, be it sudden burst of traffic or steady usage growth.

But what is the degree to which our system is scalable? What kind of sudden usage spikes can it safely handle? That's an important consideration, and the architect should be able to answer that question. A tactic to enforce such constraints is called Rate Limiting.

There are many situations that could cause dangerous traffic spikes:
* Legitimate usage patterns during "hot" periods (e.g. Black Friday)
* Viral social media moments or influencer mentions
* Malicious traffic trying to bring our systems down
* Users trying to run load tests or some automations involving our APIs
* Bot scrapers and competitive intelligence gathering

