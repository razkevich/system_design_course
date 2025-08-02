(todo write intro , let's start by mentioning the definition that sw architecture is the definition of components and how they relate to each other , i forgot who said that, some popular sw architecture book. say that here we wanna talk about how we define the components)

Decomposition is not always about deployment separation. We care about it with a monolith or any other architectural style too (possibly even more).

So what makes an architect draw a rectangle on their diagram? what are the forces that pull some pieces of functionality (assumed or implemented) together? There are multiple concerns or points of view that influence that: (todo let's make subsections out of the below and briefly explain them, feel free to restructure and add more if needed)
* Functionality - it makes sense to map real world concepts/notions onto the solution space. that's the concern of DDD (domain driven desing) (todo explain why and how)
* Quality attributes - things like performance, security influence how we separate components
* Technical constraints - deployment environments, existing systems
* Others - team structure, expertise, cognitive limits, etc

There's also some guiding principles that have been fleshed out by the collective wisdom (todo let's make subsections out of the below and briefly explain them, feel free to restructure and add more if needed)
* high cohesion, low coupling - what we wanna achieve is group related things together. 'Related' is not only about functional closeness: it spans across all above concerns (todo explain and give examples)
* **High Cohesion, Low Coupling** - Related things together, unrelated things apart
- **Separation of Concerns** - Different aspects handled by different modules
- **Information Hiding** - Hide implementation details
- **Conway's Law** - System structure mirrors organization structure
- Common Closure Principle - Classes that change together, stay together
- Common Reuse Principle - Classes used together, stay together
- SOLID Principles (Class-Level Design)


Another way to look at decomposition is through the lense of integration and disintegration drivers