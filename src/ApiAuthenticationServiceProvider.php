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
				Console\RegisterApiAuthCommand::class
			]);
		}

	}

	public function registerGuard(){
		Auth::extend('ichi', function($app, $name, array $config) {
			return new RequestGuard(function($request) use ($config){
				new UserGuard(
					new IchiUserProvider(Auth::createUserProvider($config['provider']) 
				))->user($request)
				});
			});
		}

		public function registerMigrations(){
			return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
		}

		public function register(){
			$this->registerGuard();
		}	
	}