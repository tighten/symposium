<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    */

    'name' => 'Symposium',

    'env' => env('APP_ENV', 'production'),


    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG'),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'America/Detroit',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'YourSecretKey!!!'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog"
    |
    */

    'log' => 'daily',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        Illuminate\Notifications\NotificationServiceProvider::class,
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Pipeline\PipelineServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Broadcasting\BroadcastServiceProvider',
        'Illuminate\Bus\BusServiceProvider',
        Laravel\Scout\ScoutServiceProvider::class,


        /*
         * Application Service Providers...
         */
        'App\Providers\AppServiceProvider',
        // App\Providers\BroadcastServiceProvider::class,
        'App\Providers\EventServiceProvider',
        'App\Providers\RouteServiceProvider',
        'Bugsnag\BugsnagLaravel\BugsnagServiceProvider',

        'Collective\Html\HtmlServiceProvider',
        'Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider',
        'Thujohn\Twitter\TwitterServiceProvider',
        'Maknz\Slack\SlackServiceProvider',
        'LucaDegasperi\OAuth2Server\Storage\FluentStorageServiceProvider',
        'LucaDegasperi\OAuth2Server\OAuth2ServerServiceProvider',
        PragmaRX\Firewall\Vendor\Laravel\ServiceProvider::class,

        'App\Providers\OAuthGuardServiceProvider',
        App\Providers\CaptchaServiceProvider::class,
        App\Providers\JoindInServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        MaddHatter\LaravelFullcalendar\ServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'       => 'Illuminate\Support\Facades\App',
        'Artisan'   => 'Illuminate\Support\Facades\Artisan',
        'Auth'      => 'Illuminate\Support\Facades\Auth',
        'Blade'     => 'Illuminate\Support\Facades\Blade',
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache'     => 'Illuminate\Support\Facades\Cache',
        'Config'    => 'Illuminate\Support\Facades\Config',
        'Cookie'    => 'Illuminate\Support\Facades\Cookie',
        'Crypt'     => 'Illuminate\Support\Facades\Crypt',
        'DB'        => 'Illuminate\Support\Facades\DB',
        'Event'     => 'Illuminate\Support\Facades\Event',
        'File'      => 'Illuminate\Support\Facades\File',
        'Hash'      => 'Illuminate\Support\Facades\Hash',
        'Input'     => 'Illuminate\Support\Facades\Input',
        'Inspiring' => 'Illuminate\Foundation\Inspiring',
        'Lang'      => 'Illuminate\Support\Facades\Lang',
        'Log'       => 'Illuminate\Support\Facades\Log',
        'Mail'      => 'Illuminate\Support\Facades\Mail',
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Paginator' => 'Illuminate\Support\Facades\Paginator',
        'Password'  => 'Illuminate\Support\Facades\Password',
        'Queue'     => 'Illuminate\Support\Facades\Queue',
        'Redirect'  => 'Illuminate\Support\Facades\Redirect',
        'Redis'     => 'Illuminate\Support\Facades\Redis',
        'Request'   => 'Illuminate\Support\Facades\Request',
        'Response'  => 'Illuminate\Support\Facades\Response',
        'Route'     => 'Illuminate\Support\Facades\Route',
        'Schema'    => 'Illuminate\Support\Facades\Schema',
        'Session'   => 'Illuminate\Support\Facades\Session',
        'URL'       => 'Illuminate\Support\Facades\URL',
        'Validator' => 'Illuminate\Support\Facades\Validator',
        'View'      => 'Illuminate\Support\Facades\View',
        'Bugsnag'   => 'Bugsnag\BugsnagLaravel\Facades\Bugsnag',
        'Form'      => 'Collective\Html\FormFacade',
        'HTML'      => 'Collective\Html\HtmlFacade',
        'Gravatar'  => 'Thomaswelton\LaravelGravatar\Facades\Gravatar',
        'Twitter'   => 'Thujohn\Twitter\Facades\Twitter',
        'Slack'     => 'Maknz\Slack\Facades\Slack',
        'Authorizer' => 'LucaDegasperi\OAuth2Server\Facades\AuthorizerFacade',
        'Image'     => Intervention\Image\Facades\Image::class,
        'Firewall' => PragmaRX\Firewall\Vendor\Laravel\Facade::class,
        'Calendar' => MaddHatter\LaravelFullcalendar\Facades\Calendar::class,
    ],

];
