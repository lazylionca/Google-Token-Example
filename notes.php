<!--
Nov 5, 2016

https://github.com/thephpleague/oauth2-client
https://github.com/thephpleague/oauth2-client/archive/master.zip

There are two terms that can be confusing when dealing with oauth:

        User and Client

The User is the person sitting at the computer.
That person will have an account with google: ie: sonso@gmail.com

The Client is the program or App that You, the Programmer, are writing.
In order for the Client/App to query a User's google account,
the Client/App must also have a Google account, albeit a different type: a service account.

In order for an App/Client to get such an account, You the Programmer must
also have a Google account: ie memyselni@gmail.com

The Programmer will need to register at https://console.developers.google.com and 
create a project and credentials, thus creating a service account for the App.
You then download a json file which will have a client_id and client_secret that the app will use.
Store this file securely as you dont want other people to act as if they are your App.
(That would be bad, mmmkay)

These credentials need to be submitted whenever your App asks a User to log in to their Google 
account and authorize the App to access whatever is specified by the App in the 'Scope'.

Pro-tip: Don't forget to the specify the Scope! (Google it. Go ahead. I'll wait.)

Once the User has authorized the App by logging into their Google account, the App will receive a 'code'. 
This code can then be submitted along with the App's client_id to get an access_token and a refresh_token.

This access_token and the App's client_id need to be submitted as part of any query made to the User's account.

The access_token will expire after an hour.
The app then needs to submit it's client_id and the refresh_token in order to get a new access_token.
goto 35

To paraphrase the Google documentation, your App, once authorized by the User,
will 'impersonate' said User in order to access information from the User's Google account.
This is possible because the User has authorized the App's service acount to do so.

In short, this is a convoluted, but secure way for a User to give your App
it's own username and password to their account.


The mistake I made in the beginning was assuming that my App's service account
needed to be created in the developer console under my User account,
since in my case it's my own account that I'm trying to get my app to access.

It can be done that way, and I did it, but it didn't need to be. I'm not changing it now.

//-->
