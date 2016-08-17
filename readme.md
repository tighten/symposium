# Symposium
[![Codeship Status for tightenco/symposium](https://codeship.com/projects/5dfd2740-dc61-0132-1e9f-025863fcc952/status?branch=master)](https://codeship.com/projects/79937)

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

1. (Optionally) [Fork this repository](https://help.github.com/articles/fork-a-repo/)
2. Clone the repository locally
3. [Install dependencies](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) with `composer install`
4. Copy [`.env.example`](https://github.com/tightenco/symposium/blob/master/.env.example) to `.env` and modify its contents to reflect your local environment.
5. [Run database migrations](http://laravel.com/docs/5.1/migrations#running-migrations). If you want to include seed data, add a `--seed` flag.

    ```bash
    php artisan migrate --env=local
    ```
6. Configure a web server, such as the [built-in PHP web server](http://php.net/manual/en/features.commandline.webserver.php), to use the `public` directory as the document root.

    ```bash
    php -S localhost:8080 -t public
    ```
7. Run tests with `composer test`.
