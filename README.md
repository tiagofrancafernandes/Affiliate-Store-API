# EXITUS API

## What is Exitus API?
Exitus API provides authentication, authorization for your web apps. Your users can sign in directly with a username and password.

There is a user data pull for authorized users. You as a developer can manage the user's data in your web application (use username, email, id, created_at and updated_at for your purposes).

User authorization through Exitus API based on API authentication using a random token assigned to each user of your application.

### Getting started with Exitus API?
The Exitus API provides endpoint URLs for registration, authorization, email verification, password reset.

Due to user authorization, after successful authentication, the server response contains a token. This token must be saved by your application and used for each future request as the "Bearer Token".

#### There are several API URLs you should know about:

> Tip: if use VSCode, try install the REST Client extension `@id:humao.rest-client`

##### Registration:
`POST: https://api.tiagofranca.com/api/register`

For user registration, you must use an **unauthorized** POST request with the following parameters:
- name
- email
- password
- password_confirmation

```http
### Register request
POST http://127.0.0.1:8000/api/register
Accept: application/json
Content-Type: application/json

{
    "name": "Admin",
    "email": "admin@mail.com",
    "password": "power@132",
    "password_confirmation": "power@132"
}
```

##### Login:
`POST: https://api.tiagofranca.com/api/login`

For user login, you must use an **unauthorized** POST request with the following parameters:
- email
- password
- remember

```http
### Login request
POST http://127.0.0.1:8000/api/login
Accept: application/json
Content-Type: application/json

{
    "email": "admin@mail.com",
    "password": "power@132",
    "remember": true
}
```

##### Sign out:
`POST: https://api.tiagofranca.com/api/logout`

```http
### Logout request
POST http://127.0.0.1:8000/api/logout
Accept: application/json
Content-Type: application/json
Authorization: Bearer MyAuthToken
```

For sign out user, you must use an **authorized** POST request without any parameters.

##### Email Verification (send url):
`POST: https://api.tiagofranca.com/api/send-email-verification-url`

To send email verification URL to user's email address, you must use an **authorized** POST request with following:
- verificationUrl

"verificationUrl" is an Base url of a page where user will be redirected from his/her email address (eg. http://domain.com/verify-email-check).

##### Email Verification (check url):
`POST: https://api.tiagofranca.com/api/send-email-verification-check`

To check email verification URL from user's email address, you can use an **unauthorized** or an authorized POST request with following parameters:
- id
- hash

"id" is an id of the current user. "hash" is an automatically generated string from email verification URL (eg. http://domain.com/verify-email-check?id=24&hash=d1D/2aMqY5AVUNjRsaqsK.W56oYS5ltgnJUod3IgJVjKcfxBkJXPu).

##### Forgot password:
`POST: https://api.tiagofranca.com/api/forgot-password`

To send forgot password URL to user's email address, you must use an **authorized** POST request with following parameters:
- email
- resetPasswordUrl

"email" is an email of the current user. "resetPasswordUrl" is an Base url of a page where user will be redirected from his/her email address (eg. http://domain.com/reset-password).

##### Reset password:
`POST: https://api.tiagofranca.com/api/reset-password`

To reset password you must handle reset password URL from user's email address, using an **authorized** POST request with following parameters:
- email
- password
- password_confirmation
- token

"token" is an automatically generated string in URL (eg. http://domain.com/reset-password?token=y10$oGbE99vXTLTeTC.k7QVgiOFvtmB1dLY4dXRnteLgTzRKNKYjfLQWS).

##### Get Auth User Data:
`GET: https://api.tiagofranca.com/api/user`

```http
### User data request
GET http://127.0.0.1:8000/api/user
Accept: application/json
Content-Type: application/json
Authorization: Bearer MyAuthToken
```

To get user's data you must use an **authorized** GET request with Bearer Token generated after successful login request.
