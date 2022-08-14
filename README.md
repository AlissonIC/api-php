# api-php
This is a RESTFUL API made to speed up the development time of applications that use PHP as a base, in less than 5 minutes it is possible to obtain endpoints for queries already with security and pre-configured good practices.

# Login auth
Example to login and get the `bearer token`:<br>
```
curl --location --request POST 'http://localhost/api/v1/auth/login' \
--form 'mail="alisson@gmail.com"' \
--form 'password="202cb962ac59075b964b07152d234b70"'
```

# Request
All requests need a `bearer token` generated in the `login endpoint`, the token can be passed in the request header or in the content (error prevention for servers that block authorization in the header).

# Return
All returns produce a json with `status` and `data` elements, when the request does not produce errors, the return will be "success" and the data will be returned within the "data" object of the contract, the status will be "error" and "data" will display the reason why the request was not successful.