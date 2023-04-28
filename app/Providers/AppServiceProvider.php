<?php

namespace App\Providers;

use App\CallingAllPapers\Client;
use App\Handlers\Events\SlackSubscriber;
use Collective\Html\FormBuilder;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::withoutDoubleEncoding();

        Blade::directive('sorted', function ($expression) {
            list($sorted_by, $query) = explode(',', $expression, 2);

            return "<?php echo e({$sorted_by} == {$query} ? 'u-bold' : ''); ?>";
        });

        // @todo: Sort of gross, probably can figure out
        // a better solution.
        if ($this->app->environment() !== 'testing') {
            Event::subscribe(SlackSubscriber::class);
        }

        require app_path() . '/macros.php';

        Paginator::useTailwind();

        Validator::extend('emailblacklist', function ($attribute, $value, $parameters, $validator) {
            try {
                $blacklist = File::get(storage_path('app/email_domain_blacklist.txt'));
            } catch (Exception $e) {
                return true;
            }

            $blacklist = collect(explode("\n", trim($blacklist)));
            $domain = explode('@', $value)[1];

            return $blacklist->filter(function ($blacklistedDomain) use ($domain) {
                return Str::contains($domain, $blacklistedDomain);
            })->isEmpty();
        });

        Request::macro('isContainedBy', function ($routeName) {
            return str($this->path())->startsWith(
                str(route($routeName, [], false))->ltrim('/'),
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::withoutCookieSerialization();
        Passport::ignoreMigrations();

        $this->app->bind('form', function () {
            return new FormBuilder(
                $this->app->make('Collective\Html\HtmlBuilder'),
                $this->app->make('Illuminate\Routing\UrlGenerator'),
                null,
                csrf_token()
            );
        });

        $this->registerCallingAllPapersClient();
    }

    public function registerCallingAllPapersClient()
    {
        $this->app->when(Client::class)
            ->needs(GuzzleClient::class)
            ->give(function () {
                return new GuzzleClient([
                    'headers'  => ['User-Agent' => 'Symposium CLI'],
                    'base_uri' => 'https://api.callingallpapers.com/v1/cfp',
                ]);
            });
    }
}
