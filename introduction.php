<?php

Mar 20, 2017

Look up a phone number in Google Contacts.

If you're anythning like me, you want to know how things work rather than just blindly use someone else's library.

I'll admit, I don't know how to build a combustion engine, but I do know know how to change my own oil and spark plugs.

Libraries are great when you are working on big projects and don't want to re-invent the wheel.
But I'm not building a car.

My goal was simple, look up a phone number in my Google Contacts and get the associated name if it existed.
This is something that is actually quite simple to do once you figure it out.

Working with api's really isn't that hard.
But if you go by the Google results, you'd think it required rocket surgery!

All the documentation I found said to use Googles existing libraries which required me to install the Composer Library,
the sum total of which required more disk space than my entire project! BLEH!!!


The thing that caught me up in the Google documentation is that all the examples seem to think we as dev's 
want the users to authorize our app to access something from the users account. 
Which, yes, is a very common usage, but...

Apparently the idea of creating an app to access information from your own account is completely unheard of.


So what the first file (get-ga-token.php) does is ask you to log into your own account 
so it can get the initial client id & secret. You should only have to run this once.

The client id and client secret are like a secondary username and password for a google account 
that apps can request, store, and use to access information as if they were you the user.

FYI: You can revoke these at any time and should probably review them once every millennia or so.
https://myaccount.google.com/permissions


Now to make things more confusing, your app also needs to have it's own credentials.
Register your app as a 'project' on Google Console: https://console.developers.google.com
if you haven't already. This is how Google knows who/what is accessing a users account.




To me this seems like a completely idiotic extra step to take in order to access your own account but... 
It's the only way I could figure out after two weeks of hair pulling and, ironically, Googling.

I'd be happy if someone could show me the error of my ways.



?>
