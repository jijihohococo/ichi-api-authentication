<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
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
            	Console\ApiAuthCommand::class,
            	Console\InstallCommand::class
            ]);
		}

	}

	public function registerMigrations(){
		return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
	}

	public function register(){

	}	
}