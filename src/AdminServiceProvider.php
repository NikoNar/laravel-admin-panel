<?php 
namespace Codeman\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Codeman\Admin\Http\Middleware\Admin;

/**
 * Codeman\Admin\
 */
class AdminServiceProvider extends ServiceProvider
{
	public function boot()
	{
		
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
		$this->loadViewsFrom(__DIR__.'/views', 'admin-panel');
		$this->loadMigrationsFrom(__DIR__.'/database/migrations');

		
		// $this->publishes([
  //       	__DIR__.'/path/to/config/courier.php' => config_path('courier.php'),
  //       	 __DIR__.'views' => resource_path('views/vendor/admin'),
  //   	]);

		$this->publishes([
       	 	__DIR__.'/assets' => public_path('admin-panel'),
   		], 'public');

		// Publish images config file 
		
		$this->publishes([
       		__DIR__.'/config/images.php' => config_path('images.php'),
		], 'config');
		
		// Publish google analytics credentials file 
		$this->publishes([
			__DIR__.'/config/service-account-credentials.json' => storage_path('app/analytics/service-account-credentials.json'),
		], 'storage');

		AliasLoader::getInstance()->alias('Form', '\Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias('Html', '\Collective\Html\HtmlFacade');
        AliasLoader::getInstance()->alias('JsValidator', '\Proengsoft\JsValidation\Facades\JsValidatorFacade');
        AliasLoader::getInstance()->alias( 'LaravelLocalization' , 'Mcamara\LaravelLocalization\Facades\LaravelLocalization');
        AliasLoader::getInstance()->alias( 'Avatar' , 'Laravolt\Avatar\Facade');
		
		// Register Middleware for Admin
		$router = $this->app['router'];
    	$router->pushMiddlewareToGroup('admin', Http\Middleware\Admin::class);

	}

	public function register()
	{
		$this->app->bind(
		    __DIR__.'\Interfaces\PageInterface',
		    __DIR__.'\Controllers\PageController'
		);
		// require __DIR__.'/../vendor/autoload.php';

		$this->app->bind(
		    "Codeman\Admin\Interfaces\PageInterface",
		    "Codeman\Admin\Services\PageService"
		);
		
		$this->app->bind(
		    "Codeman\Admin\Interfaces\NewsInterface",
		    "Codeman\Admin\Services\NewsService"
		);
		$this->app->bind(
		    "Codeman\Admin\Interfaces\MenuInterface",
		    "Codeman\Admin\Services\MenuService"
		);
		$this->app->bind(
		    "Codeman\Admin\Interfaces\ProductInterface",
		    "Codeman\Admin\Services\ProductService"
		);

		$this->app->register(\Collective\Html\HtmlServiceProvider::class);
        $this->app->register(\Proengsoft\JsValidation\JsValidationServiceProvider::class);
        $this->app->register(\Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class);
		$this->app->register(\Laravolt\Avatar\ServiceProvider::class);
		
		$this->setEnvironmentValue(['ANALYTICS_VIEW_ID' => '185059691']);

		$this->publishes([
			__DIR__.'/config/service-account-credentials.json' => storage_path('app/analytics/service-account-credentials.json'),
		], 'storage');

	}

	public function setEnvironmentValue(array $values)
	{

		$envFile = app()->environmentFilePath();
		$str = file_get_contents($envFile);

		if (count($values) > 0) {
			foreach ($values as $envKey => $envValue) {

				$str .= "\n"; // In case the searched variable is in the last line without \n
				$keyPosition = strpos($str, "{$envKey}=");
				$endOfLinePosition = strpos($str, "\n", $keyPosition);
				$oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

				// If key does not exist, add it
				if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
					$str .= "{$envKey}={$envValue}\n";
				} else {
					//$str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
				}

			}
		}

		$str = substr($str, 0, -1);
		if (!file_put_contents($envFile, $str)) return false;
		return true;

	}
}
