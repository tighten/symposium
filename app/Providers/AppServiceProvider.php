<?php namespace SaveMyProposals\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		\Blade::setRawTags('{{', '}}');
		\Blade::setContentTags('{{{', '}}}');

		require app_path() . '/modelEvents.php';
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
			'SaveMyProposals\Services\Registrar'
		);

		$this->app->bind('form', function () {
            return new \Illuminate\Html\FormBuilder(
                $this->app->make('Illuminate\Html\HtmlBuilder'),
                $this->app->make('Illuminate\Routing\UrlGenerator'),
                csrf_token()
            );
        });

        \Blade::setRawTags('{{', '}}');
		\Blade::setContentTags('{{{', '}}}');
		\Blade::setEscapedContentTags('{{{', '}}}');
	}

}
