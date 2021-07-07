<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Repository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\IchiRefreshTokenAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\IchiConfiguration;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class RefreshTokenRepository{

	public function make(IchiConfiguration $ichiConfiguration , $tokenId,array $userData){
		$refreshToken=IchiRefreshTokenAuthentication::create([
			'refresh_token' => Hash::make($tokenId. $userData['id'] . $userData['email'] . $userData['password'] .  time()) ,
			'token_id' => $tokenId ,
			'expired_at' => $ichiConfiguration->getRefreshExpiredAt()
		]);
		return $refreshToken;
	}

	public function expired($refreshToken){
	return	IchiRefreshTokenAuthentication::where('refresh_token',$refreshToken)->where('expired_at','>',Carbon::now())->exists();
	}

	public static function delete($refreshToken){
		IchiRefreshTokenAuthentication::where('refresh_token',$refreshToken)->delete();
	}

}