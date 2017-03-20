<!--
Nov 5, 2016

https://github.com/thephpleague/oauth2-client

https://github.com/thephpleague/oauth2-client/archive/master.zip

There are two terms that can be confusing when deal with oauth:

user and client

User is the person sitting at the computer.
That person will have an account with google: ie sonso@gmail.com

The Client is the program or app you, the programmer, are writing.
In order for the client to query the user's google account,
the client must also have a google account, albeit a different type.

In order for the app to get such an account, you the programmer must
also have a regular google account: ie memyselni@gmail.com

The programmer will need to register at https://console.developers.google.com
and create a project and credentials for the app. You then download a json file
which will have a client_id and client_secret that the app needs.

Store these securely as you dont want other people to act as if they are your app.

These need to be submitted when your app asks the user to log in to
their google account and authorize the app to access whatever is
specified by the app in the 'scope'.

Once the user has authorized the app by loggin into their gmail account,
the app will receive a 'code'. This can be submitted along with the client_id
to get an access_token and a refresh_token.

The access_token and client_id need to be submitted with any query made
to the users account.

The access token will expire after an hour.
The app then needs to submit it's client_id and the refresh_token
in order to get a new access_token.



To paraphrese the google documentation, your app, once authorized by the user,
will 'impersonate' the user in order to access information from their google account.
This is possible because the user has authorized the app's service acount to do so.

In short, this is a convoluted, but secure way of the user giving your app
it's own username and password to the users account.


The mistake I made in the beginning was assuming that the service account
needed to be created in the developer console under the user account.

It can be, and it is, but it didn't need to be. I'm not changing it now.



//-->
