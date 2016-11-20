## Car Rental API
Total Tickets Done: 8

This Car Rental API is built by using Laravel 5.0 framework for the purpose of pre-test interview held by one company. 

Here are following tickets that have been done:
+ 1. CRUD Client: http://redmine.byte-stack.net/issues/660
+ 2. CRUD Car: http://redmine.byte-stack.net/issues/661
+ 3. CRUD Rental: http://redmine.byte-stack.net/issues/664
+ 4. Available Car Information: http://redmine.byte-stack.net/issues/669
+ 5. Rented Car Information: http://redmine.byte-stack.net/issues/668
+ 6. Car Rental History within specified month: http://redmine.byte-stack.net/issues/663
+ 7. Client Rental History: http://redmine.byte-stack.net/issues/662
+ 8. API Blueprint: http://redmine.byte-stack.net/issues/666

## How to Test

This Car Rental API being tested by using Google Chrome Advanced Rest Client app.

+ Current database name and configuration are set to local. Database name: car_rental_api, localhost.
+ Run Migration and Seeding (php artisan migrate and php artisan db:seed)

### Notes
As for this ticket: http://redmine.byte-stack.net/issues/669 and http://redmine.byte-stack.net/issues/663
Due to laravel standard about route parameters is different, there is a slight difference of using it:
+ From this: /cars/free?date={dd-mm-yyyy}
+ To this (the one that i use): /cars/free/date={dd-mm-yyyy} *changed the '?' mark to '/'

+ From this: /histories/car/{id}?month={mm-yyyy}
+ To this (the one that i use): /histories/car/{id}?month={mm-yyyy} *changed the '?' mark to '/'

Thank you for reading!