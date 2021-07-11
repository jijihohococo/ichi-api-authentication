<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\{TokenRepository,RefreshTokenRepository};
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiApiAuthentication,IchiTokenAuthentication,IchiRefreshTokenAuthentication};
use Illuminate\Container\Container;
use JiJiHoHoCoCo\IchiApiAuthentication\Exceptions\{TokenException,RefreshTokenException,IchiException};
trait HasApi{

	public $accessToken;

	public function getAllTokens(){
		return TokenRepository::getTokens($this->getApiId(),$this->id);
	}

	public function revoke(){
		if(app('request')->bearerToken() && TokenRepository::check( getTokenFromHeader(app('request')->header('Authorization')) , $this->getApiId() ) ){
			$tokenId=$this->accessToken()->getTokenId();
			TokenRepository::revoke($tokenId);
			RefreshTokenRepository::revokeByParentToken($tokenId);
		}else{
			throw TokenException::invalidToken();
		}
	}
	
	public function withAccessToken($accessToken){
		$this->accessToken=$accessToken;
		return $this;
	}

	public function accessToken(){
		return $this->accessToken;
	}

	private function getUserAttributes(){
		return [
			'id' =>	$this->id ,
			'email' =>	$this->email ,
			'password' =>	$this->password
		];
	}

	public function ichiToken(){
		if($this->checkGuard()){
			return Container::getInstance()->make(TokenRepository::class)
			->make($this->getGuard(),$this->getUserAttributes());
		}
		throw IchiException::invalid();
	}

	private function checkGuard(){
		return IchiApiAuthentication::where('model_name',get_class($this))->exists();
	}

	private function getGuard(){
		return IchiApiAuthentication::select('guard_name')->where('model_name', get_class($this) )->first()->guard_name;
	}

	private function getApiId(){
		return IchiApiAuthentication::select('id')->where('model_name',get_class($this))->first()->id;
	}

	
	private function checkRefreshTokenExpired($refreshToken){
		return RefreshTokenRepository::check($refreshToken) && RefreshTokenRepository::expired($refreshToken) && 
		RefreshTokenRepository::checkParentTokenRevoke($refreshToken);
	}

	public function revokedTokens(){
		return TokenRepository::countRevokedTokens($this->id,$this->getApiId());
	}

	public function refreshToken(){
		if(checkBearer($refreshToken=app('request')->header('refresh_token'))){
			$refreshToken=getTokenFromHeader($refreshToken);
			if( $this->checkRefreshTokenExpired($refreshToken) ){
				$user=RefreshTokenRepository::getUser($refreshToken);
				RefreshTokenRepository::revokeByRefreshToken($refreshToken);
				$this->id=$user->id;
				$this->email=$user->email;
				$this->password=$user->password;
				return $this->ichiToken();
			}else{
				throw RefreshTokenException::invalidToken();
			}
		}else{
			throw TokenException::invalidToken();
		}
	}

	public function logOutOtherTokens(){
		if(app('request')->bearerToken() && TokenRepository::check($newToken=getTokenFromHeader(app('request')->header('Authorization')) , $apiId=$this->getApiId() ) ){
			TokenRepository::revokeOtherTokens($newToken,$this->id,$apiId);
		}else{
			throw TokenException::invalidToken();
		}
	}
}