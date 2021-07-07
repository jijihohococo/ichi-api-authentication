<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Repository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\IchiRefreshTokenAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\IchiConfiguration;
use Illuminate\Support\Facades\Hash;
class RefreshTokenRepository{

	public function make(IchiConfiguration $ichiConfiguration , $tokenId,array $userData){
		$refreshToken=IchiRefreshTokenAuthentication::create([
			'refresh_token' => Hash::make($tokenId. $userData['id'] . $userData['email'] . $userData['password'] .  time()) ,
			'token_id' => $tokenId ,
			'expired_at' => $ichiConfiguration->getRefreshExpiredAt()
		]);
		return $refreshToken;
	}

}