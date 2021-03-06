<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Repository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\IchiApiAuthentication;
class ClientRepository{

	public function create($guard,array $selectedGuardArray){
	return	IchiApiAuthentication::create([
			'guard_name' => $guard ,
			'model_name' => config('auth.providers.'. 
			\Arr::get($selectedGuardArray , $guard .'.provider' ) .'.model')
		]);
	}

	public function checkGuardDuplicate($guard){
		return IchiApiAuthentication::where('guard_name',$guard)->count();
	}
	
	
}