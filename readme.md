# Symposium
[![Codeship Status for tighten/symposium](https://app.codeship.com/projects/abb147a0-0e05-0137-f7f7-062378f4838a/status?branch=master)](https://app.codeship.com/projects/326836)

A web app for conference speakers to track talks, bios, and conferences. Free, available online at [Symposiumapp.com](http://symposiumapp.com/).

A fun side project by some lovely folks at [Tighten Co.](http://tighten.co/).

### Additional resources

* [Api documentation](doc/api.md)
* Chat about it on freenode IRC channel `#symposium`

### Requirements

* PHP >= 5.5.9
* A [supported relational database](http://laravel.com/docs/5.1/database#introduction) and corresponding PHP extension
* [Composer](https://getcomposer.org/download/)
* [NPM](https://nodejs.org/)
* [Google Places API Key](https://developers.google.com/places/web-service/get-api-key) for speakers to set their location. A configuration guide can be found [here](/google-guide.md).
* [Algolia](https://www.algolia.com/) Account

### Installation

1. (Optionally) [Fork this repository](https://help.github.com/articles/fork-a-repo/)
2. Clone the repository locally
3. [Install dependencies](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) with `composer install`
4. Copy [`.env.example`](https://github.com/tighten/symposium/blob/master/.env.example) to `.env` and modify its contents to reflect your local environment.
5. Place your Algolia keys in the `.env` file. This is also required for running PHPUnit tests.
	
	```bash
	ALGOLIA_APP_ID=your-app-id-key
	ALGOLIA_SECRET=your-secret-key
	```
    
6. Generate an application key 

    ```bash 
    php artisan key:generate
    ```
    
7. [Run database migrations](http://laravel.com/docs/5.1/migrations#running-migrations). If you want to include seed data, add a `--seed` flag.

    ```bash
    php artisan migrate --env=local
    ```
    
8. (Optionally) Enable the API. This will output two client ID/secrets that you can use for testing

    ```bash
    php artisan passport:install
    ```
    
9. [Install frontend dependencies](https://docs.npmjs.com/cli/install) with `npm install`
10. Build CSS with `npm run dev`
11. Configure a web server, such as the [built-in PHP web server](http://php.net/manual/en/features.commandline.webserver.php), to use the `public` directory as the document root.

    ```bash
    php -S localhost:8080 -t public
    ```
12. Run tests with `composer test`.
