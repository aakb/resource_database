# resource_database
The Resource Database. Contains an API and an administration interface.

## Generate keys for JWT authentication
Generate the SSH keys:

https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#generate-the-ssh-keys

```
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

Set the `JWT_PASSPHRASE` in `.env.local` to the selected passphrase.

## Using the API

To test the API at `/api` authorize first:
```
idc bin/console lexik:jwt:generate-token EMAIL_OF_USER
``` 
