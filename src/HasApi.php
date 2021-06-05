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
		return TokenRepository::updateOrCreate( $this->getGuard() ,$this->id);
	}

	public function getGuard(){
		return IchiApiAuthentication::select('guard_name')->where('model_name', get_class($this) )->first()->guard_name;
	}
}