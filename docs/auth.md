Authentication
==============

Authentication is done via oauth 2. Upon VM creation a client credentials pair and an user are created. 

Example `access_token` request (with credentials):

```
POST /token HTTP/1.1
Accept: application/json
Content-Type: application/json

{
  "client_id" : "1_random_id",
  "client_secret" : "secret",
  "grant_type" : "password",
  "username" : "test",
  "password" : "test" 
}
```

Example response:

```
{
    "access_token": "NmFhODljNDIyMWZiYzY1MDIwOWVjY2IyYmFjM2U3ODRiNjM1N2I1ODMwMTM0MGQ3Y2MwYWY2M2Q0NjliYmEzNg",
    "expires_in": 3600,
    "token_type": "bearer",
    "scope": null,
    "refresh_token": "Y2RkNWJlNDE1N2U3NTkzZjM0ODY5ZjZhODFkNTRjZjZiMjA2YmNiYTEwMjJmYWE0YzI3MTliYzc5ZDU2NDE2MA"
}
```

Every subsequent request will have to include the access token in the authorization header like this:
`Authorization: Bearer $access_token`

Note: If you load fixtures multiple times `client_id` will change because the id of the client row in the database will be incremented. (just try `2_random_id` and so on)