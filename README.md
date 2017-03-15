## Journal

*A simple journal application built on Laravel 5*

### Setup

Create a database and a user with the proper privileges to initialize tables. Once it's running, the usual privileges should suffice: index, select, insert, update, delete.

```bash
git clone git@github.com:ssteele/journal.git    # clone a copy of the repo to your machine
cd journal                                      # navigate to web root using command-line
```

Setup your environment by saving a .env file filling in YOUR_VALUES into the template below:

```php
APP_ENV=local
APP_DEBUG=true
APP_KEY=YOUR_RANDOM_STRING
DB_HOST=localhost
DB_DATABASE=YOUR_DATABASE
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD
DB_PORT=8889
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

Now back to the command line:

```bash
composer install                                # install dependencies
composer update                                 # update dependencies
php artisan migrate                             # create database tables
php artisan serve --port=2222                   # serve the site
/Applications/MAMP/bin/php/php7.0.13/bin/php artisan serve --port=2222
```

Register by browsing here: [http://localhost:2222/auth/register](http://localhost:2222/auth/register)

### Use

You can host multiple users. Once logged in, a user can add journal entries [one at a time](http://localhost:2222) or you can [bulk upload a CSV](http://localhost:2222/upload) using the format below:

```csv
Date|Tempo|Entry
01.01.16|0|My entry for January 1, 2016
01.02.16|0|Wow, yesterday was busy!
01.03.16|0|...another entry
```
