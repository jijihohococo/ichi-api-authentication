<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Repository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiApiAuthentication,IchiTokenAuthentication};
use JiJiHoHoCoCo\IchiApiAuthentication\IchiConfiguration;
use Illuminate\Support\Facades\Hash;
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\RefreshTokenRepository;
class TokenRepository{

	public $ichiConfiguration;
	public function __construct(IchiConfiguration $ichiConfiguration){
		$this->ichiConfiguration=$ichiConfiguration;
	}

	public static function getApiId($guard){
		return IchiApiAuthentication::where('guard_name',$guard)->first()->id;
	}

	public static function getToken($guard,$userId){
		return IchiTokenAuthentication::select('token')->where('user_id',$userId)
		->where('api_authentication_id',self::getApiId($guard))
		->first();
	}

	public function make($guard,array $userData ){
		
		$apiId=self::getApiId($guard);
		$ichiToken=IchiTokenAuthentication::updateOrCreate(
			['user_id'=>$userData['id'] , 'api_authentication_id' => $apiId ],
			[
				'user_id' => $userData['id'] ,
				'token' => Hash::make($guard. $userData['id'] . $userData['email'] . $userData['password'] .  time()) ,
				'expired_at' => $this->ichiConfiguration->getExpiredAt()  ,
				'api_authentication_id' => $apiId,
				'revoke' => false
			]);
		$refreshToken=new RefreshTokenRepository();
		$newRefreshToken=$refreshToken->make($this->ichiConfiguration,$ichiToken->id,$userData);
		$ichiToken->setRefreshToken($newRefreshToken->refresh_token);
		$ichiToken->setRefreshTokenExpiredTime($newRefreshToken->expired_at);
		return $ichiToken;
	}

	public static function revoke($id){
		IchiTokenAuthentication::findOrFail($id)->update([
			'revoke' => true
		]);
	}

}