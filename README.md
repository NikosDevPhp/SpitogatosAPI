# SpitogatosAPI
A Laravel Spitogatos API with search functionality

## Installation
Git clone this repository and use it.
Not pushed on packagist.org, can be done by easily by Github Hooks

Create a .env file from .env.example and fill in fields APP_URL and DB credentials

To import excel in database please run
```bash
php artisan import:listings --path='SpiN Listings.xlsx'
```
from any directory

## Documentation

1.The response is cached with a key with the url and post parameters if the status code 
is 200 with Middleware 'cache.full.response' which performs better than Database caching.
Custom Observer is created to clear cache automatically on Model save.
Cache can be manually cleared by running 
```bash
php artisan cache:clear
```

2.Specific Middleware 'cors' to handle Cross Origin for VM testing. Can be disabled in specific route in 'routes/api.php'

3.Logging is enabled by default in 'storage/logs/queries.log' with 'queries' channel 
using Monolog and Json Formatter to be easily manipulated for reports.
There is a listener that logs all sql queries to the database. Cached responses
are also logged with post parameters and the special attribute 'from Cache' attached.

4.Functional tests are done for API responses in 'tests/Feature/ApiTest.php' and 
'cors' middleware and unit tests only for the create-update functionality as there
is no other CRUD functionality of the API. Factory method for mocking Listing Model created.

5.Database Schema created additional availability table because in the long 
run maybe specification can change and violateone-to-one relation. 
(e.g. an Apartment can be for Sale and for Rent at the same time)

6.Laravel used as the API backend as it can provide many out-of-the-box functionalities
and can scale horizontally with Cloud Services. 

## TODO 

Elastic Search implementation can also speed up response times(for similar implementation please have a look at HearthstoneAPI in my github repo https://github.com/NikosDevPhp/HearthstoneAPI)

Authentication using JWT should be used to facilitate security


## History
Tested on Vagrant environment and worked
as of 02/02/2020.
Contact me on niktriant89@gmail.com for your advise, comments etc.
