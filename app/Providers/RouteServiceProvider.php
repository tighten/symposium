<?php namespace SaveMyProposals\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'SaveMyProposals\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		$router->filter('admin-auth', function () {
			if (\Auth::guest()) {
				return \Redirect::to('log-in');
			}
			
			// Guess we should have roles... @todo
			if (\Auth::user()->email != 'matt@jibberjabber.com') {
				\Log::error('Non-admin user tried to access admin-only section.');
				return \Redirect::to('log-in');
			}
		});
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		$this->loadRoutesFrom(app_path('Http/routes.php'));
	}

}
