<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use JiJiHoHoCoCo\IchiApiAuthentication\IchiUserProvider;
use Illuminate\Auth\RequestGuard;
class ApiAuthenticationServiceProvider extends ServiceProvider{
	
	public function boot(){
		if ($this->app->runningInConsole()) {
			
			$this->registerMigrations();

			$this->publishes([
				__DIR__.'/../database/migrations' => database_path('migrations'),
			], 'ichi-migrations');

			$this->publishes([
				__DIR__.'/../config/ichi.php' => config_path('ichi.php'),
			], 'ichi-config');

			$this->commands([
				Console\ClientApiAuthCommand::class,
				Console\RemoveApiAuthCommand::class
			]);
		}

	}

	public function registerGuard(){
		Auth::resolved(function ($auth) {
			$auth->extend('ichi', function($app, $name, array $config) {
				return tap( $this->registerRequestGuard($config,$name)  ,function($guard){
					$this->app->refresh('request', $guard, 'setRequest');
				});
			});
		});
	}

	public function registerRequestGuard($config,$guardName){
		return new RequestGuard(function($request) use ($config,$guardName){
			return (new UserGuard(
				new IchiUserProvider(Auth::createUserProvider($config['provider'])) ,
				$guardName
			))->user($request);
		},$this->app['request']);
	}

	public function registerMigrations(){
		return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
	}

	public function register(){
		$this->registerGuard();
		$this->registerIchiDataSet();
	}

	public function registerIchiDataSet(){
		$this->app->singleton(IchiConfiguration::class, function (){
			return tap(new IchiConfiguration , function($ichiConfiguration){
				$ichiConfiguration->setExpiredAt(
					Ichi::setExpiredAt()
				);
				$ichiConfiguration->setRefreshExpiredAt(
					Ichi::setRefreshExpiredAt()
				);
			});
		});
	}	
}