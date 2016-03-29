<?php
namespace App\Modules\VergoInterview\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class VergoInterviewServiceProvider extends ServiceProvider
{
	/**
	 * Register the VergoInterview module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\VergoInterview\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the VergoInterview module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('vergo_interview', realpath(__DIR__.'/../Resources/Lang'));

		View::addNamespace('vergo_interview', base_path('resources/views/vendor/vergo_interview'));
		View::addNamespace('vergo_interview', realpath(__DIR__.'/../Resources/Views'));
	}
}
