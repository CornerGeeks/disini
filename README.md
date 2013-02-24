Disini - An Uberclone?
========

Feel like trying out geolocations today. Something along the lines of the UBER model. There are couple of ideas I could try.
- Mobile app to get a two truck coming if your car breaks down.
- Some sort of service offering, service finding app. Imagine listing what you are able to do, for a particular cost and save. (For example, I can look at your laptop for $3, for 10 minutes. I'm hanging out at at cafe now). The location would be stored. Then someone can search for a particular service or skills set.
- Same thing as above for meeting people? This exists probably, but same principle.
- Oh! location enabled second hand selling kind of thing.

Things to implement
-------------------
- A way to get geolocation data. Since we're doing mobile web, we'll depend on HTML5 geolocation APIs for now
- A way to look for locations near a location. Seem's there's a set algorithm to do this already. (Trigonometry! Also bounding boxes)
- A way to do notifications? Refresh website would be okay, but impractical. (Backgrounding the website would stop the data coming in.). Good ol email? In which case do I need to do something to protect email? Though storing email seems stock standard.
- I wonder if we can just use email without password to do this. IE, send authenticating token to emails. Practical? Dunno. Thinking out loud
- Oauth with social media networks. Facebook, twitter, the works.

