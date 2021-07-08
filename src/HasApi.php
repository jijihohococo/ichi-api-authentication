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

	public function getUserAttributes(){
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

	public function checkGuard(){
		return IchiApiAuthentication::where('model_name',get_class($this))->count();
	}

	public function getGuard(){
		return IchiApiAuthentication::select('guard_name')->where('model_name', get_class($this) )->first()->guard_name;
	}

	public function getApiId(){
		return IchiApiAuthentication::select('id')->where('model_name',get_class($this))->first()->id;
	}

	public function checkExpired(){
        $token=getTokenFromHeader(app('request')->header('Authorization'));
        $apiAuthId=$this->getApiId();
        return TokenRepository::check($token,$apiAuthId) && TokenRepository::expired($token,$apiAuthId);
    }

    public function checkRefreshTokenExpired(){
    	$refreshToken=app('request')->header('Authorization');
    	return RefreshTokenRepository::check($refreshToken) && RefreshTokenRepository::expired($refreshToken);
    }

	public function refreshToken(){
		RefreshTokenRepository::delete(app('request')->header('refresh_token'));
		return Container::getInstance()->make(TokenRepository::class)->make($this->getGuard(),$this->getUserAttributes());

	}
}