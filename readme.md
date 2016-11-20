## Car Rental API

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Tickets Done]] 8

This Car Rental API is built by using Laravel 5.0 framework for the purpose of pre-test interview held by one company. 


## How to Test

This Car Rental API being tested by using Google Chrome Advanced Rest Client app.

### Notes
As for this ticket: http://redmine.byte-stack.net/issues/669 and http://redmine.byte-stack.net/issues/663
Due to laravel standard about route parameters is different, there is a slight difference of using it:
From this: /cars/free?date={dd-mm-yyyy}
To this (the one that i use): /cars/free/date={dd-mm-yyyy} *changed the '?' mark to '/'

From this: /histories/car/{id}?month={mm-yyyy}
To this (the one that i use): /histories/car/{id}?month={mm-yyyy} *changed the '?' mark to '/'

Thank you for reading!