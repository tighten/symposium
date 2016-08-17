<?php namespace App\Providers;

use Event;
use Illuminate\Support\ServiceProvider;
use App\Handlers\Events\SlackSubscriber;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::setRawTags('{{', '}}');
        \Blade::setContentTags('{{{', '}}}');
        \Blade::directive('sorted', function ($expression) {
            list($sorted_by, $query) = explode(',', str_replace(['(', ')', ' '], '', $expression), 2);
            return "<?php echo e({$sorted_by} == {$query} ? 'u-bold' : ''); ?>";
        });

        // @todo: Sort of gross, probably can figure out
        // a better solution.
        if ($this->app->environment() !== 'testing') {
            Event::subscribe(SlackSubscriber::class);
        }

        require app_path() . '/modelEvents.php';
        require app_path() . '/macros.php';
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
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );

        $this->app->bind('form', function () {
            return new \Collective\Html\FormBuilder(
                $this->app->make('Collective\Html\HtmlBuilder'),
                $this->app->make('Illuminate\Routing\UrlGenerator'),
                csrf_token()
            );
        });

        $this->app->alias('ttwitter', 'Thujohn\Twitter\Twitter');

        \Blade::setRawTags('{{', '}}');
        \Blade::setContentTags('{{{', '}}}');
        \Blade::setEscapedContentTags('{{{', '}}}');
    }
}
