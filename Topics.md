## Infrastructure & Performance

| Title                                                                      | О чем                                                                                                                                                                                                                          |
| -------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| How Kubernetes Jobs Saved Our Salesforce Integration (And $50K in Compute) | про то как мы вынесли логику сосания данных из СФ из приложения в k8s джобы, и это охереть как помогло с перформансом                                                                                                          |
|                                                                            | про правильные distributed locks with fencing                                                                                                                                                                                  |
| AWS Spot Instances in Production: What No One Tells You                    | чего нибудь выковырять интересное про спот инстансы в AWS, там есть темы про termination, pricing algorithms, EBS volume attachment race conditions, manipulation patterns during major events (re:Invent, Black Friday, etc.) |
| The Concurrent Algorithm Optimization That 10x'd Our Throughput            | про то как улучшать перформанс параллельных алгоритмов в джаве, по мотивам моих упражнений с перформансом метадата сервиса                                                                                                     |
| Why We Dumped ECS for EKS (And Why You Might Not Want To)                  | про то как вы переезжали на EKS, это еще до меня                                                                                                                                                                               |
| The Database Design From Hell: How GUIDs Broke Our Application             | обожаю нашу гуид таблицу, это просто секс                                                                                                                                                                                      |

## AI & Modern Development

|Title|О чем|
|---|---|
|How AI Doubled Team Capacity with AI (Without Replacing Humans)|что нибудь про ИИ, например щас я буду делать спайк про devin.ai / factory.ai|

## Architecture & Systems

|Title|О чем|
|---|---|
|API Style Guides: The Strategy That Saved Us From Breaking 500+ Integrations|что нибудь про API style guides|
|Multi-Tenant SaaS: The Architecture Decisions That Make or Break Scale|про tenant isolation в saas. я год назад прочел целую книгу про это.|
|SRE for Startups: The Minimum Viable Reliability Stack|я тут пытаюсь в SRE в продли. Получается не очень, но написать что то можно про SRE в стартапе при дефиците инженерных ресурсов|
|Distributed Consensus in the Real World: Beyond the Textbook Examples|я бы вспомнил про distributed concensus алгоритмы еще раз и сделал бы overview (raft, paxos etc.)|

## Technical Deep Dives

|Title|О чем|
|---|---|
|Beyond BFS/DFS: The Graph Algorithms That Actually Matter in Production|про алгоритмы на графах (начиная от А*/dijkstra до graph neural networks)|
|15 Coding Challenges That Reveal Real Engineering Skills|что нибудь про то как правильно хайрить|
|What's New in Java 21/Spring 6/K8s 1.28: The Features That Actually Matter|overview новых фич в джаве/спринге как собак нерезаных, но может быть что то более нишевое про какие нибудь либы/фреймворки/технологии|
|Hybrid SDLC: Embedding Scrum Sprints in Waterfall Delivery|то как я смоделировал в продли наш sdlc|
