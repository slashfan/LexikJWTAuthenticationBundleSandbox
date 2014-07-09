# LexikJWTAuthenticationBundle Sandbox

A minimalist sandbox to quickly test JWT authentication through LexikJWTAuthenticationBundle and Symfony2.3.
** No persistence, testing purpose only. **

## Installation

### Dependencies

    composer install

### SSL keys

    openssl genrsa -out app/var/jwt/private.pem -aes256 4096
    openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem

## Running Tests

    bin/phpunit -c app
