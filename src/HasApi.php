<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\{TokenRepository,RefreshTokenRepository};
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiApiAuthentication,IchiTokenAuthentication};
use Illuminate\Container\Container;
use Carbon\Carbon;
trait HasApi{

	public $accessToken;

	public function getAllTokens(){
		return IchiTokenAuthentication::where('api_authentication_id',
			$this->getApiId() )
		->where('user_id',$this->id)
		->get();
	}

	public function revoke(){
		TokenRepository::revoke(
			IchiTokenAuthentication::select('id')
			->where('api_authentication_id', $this->getApiId() )
			->where('user_id',$this->id)
			->first()
			->id
		);
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
		return $this->checkGuard() > 0 ? 
		Container::getInstance()->make(TokenRepository::class)
		->make($this->getGuard(),$this->getUserAttributes()) : null ;
	}

	private function checkGuard(){
		return IchiApiAuthentication::where('model_name',get_class($this))->count();
	}

	private function getGuard(){
		return IchiApiAuthentication::select('guard_name')->where('model_name', get_class($this) )->first()->guard_name;
	}

	private function getApiId(){
		return IchiApiAuthentication::select('id')->where('model_name',get_class($this))->first()->id;
	}

	
	private function checkRefreshTokenExpired($refreshToken){
		return RefreshTokenRepository::check($refreshToken) && RefreshTokenRepository::expired($refreshToken);
	}

	public function revokedTokens(){
		return TokenRepository::countRevokedTokens($this->id,$this->getApiId());
	}

	public function refreshToken(){
		if(checkBearer($refreshToken=app('request')->header('refresh_token'))){
			$refreshToken=getTokenFromHeader($refreshToken);
			if( $this->checkRefreshTokenExpired($refreshToken) ){
				$user=RefreshTokenRepository::getUser($refreshToken);
				RefreshTokenRepository::delete($refreshToken);
				$this->id=$user->id;
				$this->email=$user->email;
				$this->password=$user->password;
				return $this->ichiToken();
			}
		}
	}
}