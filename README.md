# LexikJWTAuthenticationBundle Sandbox

[![Build Status](https://travis-ci.org/slashfan/LexikJWTAuthenticationBundleSandbox.svg)](https://travis-ci.org/slashfan/LexikJWTAuthenticationBundleSandbox)

A minimalist sandbox to quickly test JWT authentication through [LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle) and Symfony2.3.
**Demonstration purpose only. Do not use this application directly in production.**

## Installation

### Dependencies

    composer install -o

## Running test suite

    bin/phpunit -c app

## Manually check token generation using the CLI

    curl -X POST http://localhost:8000/api/login_check -d username=user -d password=password

## Run the AngularJS demo app

A sample demo application is available in the web/angular-demo directory. It is based on the great post [Authentication with Ionic and Angular.js in a Cordova/Phonegap mobile web application](http://www.kdmooreconsulting.com/blogs/authentication-with-ionic-and-angular-js-in-a-cordovaphonegap-mobile-web-application/).

To run the demo app : 

* install the assets using `bower install` in the web/angular-demo directory
* run the symfony application with a `app/console server:run`
* browse to `http://localhost:8000/angular-demo/index.html`
