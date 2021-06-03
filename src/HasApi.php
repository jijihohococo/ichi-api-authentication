<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\TokenRepository;
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
}