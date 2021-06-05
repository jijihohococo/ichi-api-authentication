<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\TokenRepository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\IchiApiAuthentication;
trait HasApi{

	public $accessToken;

	public function revoke($tokenId){
		$tokenRepository=new TokenRepository;
		$tokenRepository->revoke($tokenId);
	}
	
	public function withAccessToken($accessToken){
		$this->accessToken=$accessToken;
		return $this;
	}

	public function ichiToken(){
		return $this->checkGuard()==0 ? throw new  Exception("You need to register the guard firstly with command", 1);
		: TokenRepository::updateOrCreate( $this->getGuard() ,$this->id);
	}

	public function checkGuard(){
		return IchiApiAuthentication::where('model_name',get_class($this))->count();
	}

	public function getGuard(){
		return IchiApiAuthentication::select('guard_name')->where('model_name', get_class($this) )->first()->guard_name;
	}
}