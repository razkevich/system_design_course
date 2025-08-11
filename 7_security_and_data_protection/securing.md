# 🛡️ Securing cloud native applications

(todo write a medium.com style article , all in a professional natural human-like tone/style)


todo find a title to lure readers to read this medium.com article slightly click-bait-ish but not too much. The article has to be in the context of System Design for Cloud-Native SaaS Systems. all in a professional natural human-like tone/style. i'll outline the structure and give hints how to fill the sections. it has to have a structure but also not robotic and too structured, it has to be human like, like it's written by a human senior engineer, in a consistent and coherent way. feel free to modify / augment the structure if you think it brings value
# Intro (todo here and other titles - find a nicer title)
let's write how important that is in general and for the sake of cloud native saas apps especially. let's bring up some (2-3) prominent examples of security breaches that resulted in huge losses or other negative consequences. 
# compliance
todo let's write about compliance requirements (such as SOC2 and gdpr and ccpa and/or others): when and by who and for who they're needed and how important it is for companies to pass these audits

# access 
let's walk the user from primitive username-based controls to RBAC and other modern and best practice approaches

# tech
let's discuss how security is implemented in k8s, aws, let's mention how java/spring and golang supports security. write anything else you might find relevant  in the context of System Design for Cloud-Native SaaS Systems

# best practices
are there best practices/ advice on how to approach security  in the context of System Design for Cloud-Native SaaS Systems.you can talk about various things from mfa /mpa to applying varying security strictness to various resources (e.g. public images vs cryptographic keys)

# zero trust and least privilege
provide concise albeit informative overview of these concepts

# attack mitigation
let's discuss what are main types of attacks and what an architect can/should do to mitigate those. Give short overview how different aws/k8s/3rd party tools help mitigate them (i guess a good example is aws waf, and i guess smth is implemented on the CDN layer (aws/cloudfront), but maybe there's more and better prominent examples). let's consider a wide range of attacks, from DoS to sql injection to xss