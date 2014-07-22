# LexikJWTAuthenticationBundle Sandbox

[![Build Status](https://travis-ci.org/slashfan/LexikJWTAuthenticationBundleSandbox.svg)](https://travis-ci.org/slashfan/LexikJWTAuthenticationBundleSandbox)

A minimalist sandbox to quickly test JWT authentication through LexikJWTAuthenticationBundle and Symfony2.3.
** Demonstration purpose only. **

## Installation

### Dependencies

    composer install

### SSL keys

    openssl genrsa -out app/var/jwt/private.pem -aes256 4096
    openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem

## Running Tests

    bin/phpunit -c app

## AngularjS Demo

A demo application based on [this post](http://www.kdmooreconsulting.com/blogs/authentication-with-ionic-and-angular-js-in-a-cordovaphonegap-mobile-web-application/) is available in the web/angular-demo directory.
To run it, install the assets using `bower install` and browse to the index.html (for the example to work, both the api and the client app must be in the same domain).
