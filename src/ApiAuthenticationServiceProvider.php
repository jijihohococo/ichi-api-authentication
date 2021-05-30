<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
class ApiAuthenticationServiceProvider extends ServiceProvider{
	
	public function boot(){
		if ($this->app->runningInConsole()) {
			
			$this->registerMigrations();

			$this->registerGuard();

			$this->publishes([
				__DIR__.'/../database/migrations' => database_path('migrations'),
			], 'ichi-migrations');

			$this->publishes([
                __DIR__.'/../config/ichi.php' => config_path('ichi.php'),
            ], 'ichi-config');

            $this->commands([
            	Console\ApiAuthCommand::class,
            	Console\InstallCommand::class
            ]);
		}

	}

	public function registerGuard(){
		return Auth::extend('ichi',function($app,$name,array $config){

		});
	}

	public function registerProvider(){

	}

	public function registerMigrations(){
		return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
	}

	public function register(){

	}	
}