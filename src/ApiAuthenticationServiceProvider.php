<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Illuminate\Support\ServiceProvider;
class ApiAuthenticationServiceProvider extends ServiceProvider{
	
	public function boot(){
		if ($this->app->runningInConsole()) {
			$this->registerMigrations();

			$this->publishes([
				__DIR__.'/../database/migrations' => database_path('migrations'),
			], 'ichi-migrations');
		}

	}

	public function registerMigrations(){
		return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
	}

	public function register(){

	}	
}