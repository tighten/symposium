## Symposium
[![Codeship Status for tightenco/symposium](https://codeship.com/projects/5dfd2740-dc61-0132-1e9f-025863fcc952/status?branch=master)](https://codeship.com/projects/79937)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/tightenco/symposium/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tightenco/symposium/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e0d5d507-de6a-4644-bf74-e5fed3b7c228/mini.png)](https://insight.sensiolabs.com/projects/e0d5d507-de6a-4644-bf74-e5fed3b7c228)
[![Stories in Ready](https://badge.waffle.io/tightenco/symposium.png?label=ready&title=Ready)](https://waffle.io/tightenco/symposium)

A web app for conference speakers to track talks, bios, and conferences. Free, available online at [Symposiumapp.com](http://symposiumapp.com/).

A fun side project by some lovely folks at [Tighten Co.](http://tighten.co/).

### Additional resources

* [Api documentation](doc/api.md)
* Chat about it on freenode IRC channel `#symposium`

### Requirements

* PHP >= 5.5.9
* PHP [mcrypt extension](http://php.net/manual/en/book.mcrypt.php)
* A [supported relational database](http://laravel.com/docs/5.1/database#introduction) and corresponding PHP extension
* [Composer](https://getcomposer.org/download/)

### Installation

1. [Fork this repository](https://help.github.com/articles/fork-a-repo/)
2. [Install dependencies](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies)
3. [Run database migrations](http://laravel.com/docs/5.1/migrations#running-migrations) against the desired database using the appropriate database connection name from [configuration](https://github.com/tightenco/symposium/blob/master/config/database.php)

    ```
    php artisan migrate --database=sqlite
    ```
4. Configure a web server to use the `public` directory as the document root and the appropriate database connection name as the `DB_CONNECTION` environmental variable.

    ```
    DB_CONNECTION=sqlite php -S localhost:8080 -t public
    ```
