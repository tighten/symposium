<?php

namespace App\Providers;

use App\Handlers\Events\SlackSubscriber;
use Event;
use Exception;
use Laravel\Passport\Passport;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive('sorted', function ($expression) {
            list($sorted_by, $query) = explode(',', $expression, 2);
            return "<?php echo e({$sorted_by} == {$query} ? 'u-bold' : ''); ?>";
        });

        // @todo: Sort of gross, probably can figure out
        // a better solution.
        if ($this->app->environment() !== 'testing') {
            Event::subscribe(SlackSubscriber::class);
        }

        require app_path() . '/macros.php';

        Validator::extend('emailblacklist', function ($attribute, $value, $parameters, $validator) {
            try {
                $blacklist = File::get(storage_path('app/email_domain_blacklist.txt'));
            } catch (Exception $e) {
                return true;
            }

            $blacklist = collect(explode("\n", trim($blacklist)));
            $domain = explode('@', $value)[1];

            return $blacklist->filter(function ($blacklistedDomain) use ($domain) {
                return str_contains($domain, $blacklistedDomain);
            })->isEmpty();
        });
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();

        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            \App\Services\Registrar::class
        );

        $this->app->bind('form', function () {
            return new \Collective\Html\FormBuilder(
                $this->app->make('Collective\Html\HtmlBuilder'),
                $this->app->make('Illuminate\Routing\UrlGenerator'),
                csrf_token()
            );
        });

        $this->app->alias('ttwitter', 'Thujohn\Twitter\Twitter');
        $this->app->alias('bugsnag.multi', Log::class);
        $this->app->alias('bugsnag.multi', LoggerInterface::class);
    }
}
