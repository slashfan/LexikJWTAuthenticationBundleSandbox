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

## AngularJS App Demo

A demo application is available in the web/angular-demo directory. It is based on the great post [Authentication with Ionic and Angular.js in a Cordova/Phonegap mobile web application](http://www.kdmooreconsulting.com/blogs/authentication-with-ionic-and-angular-js-in-a-cordovaphonegap-mobile-web-application/).

To run the demo app : 

* install the assets using `bower install`
* run the symfony application with a `app/console server:run`
* browse to `http://localhost:8000/angular-demo/index.html`
