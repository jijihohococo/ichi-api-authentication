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
			'revoke' => false ,
			'expired_at' => $ichiConfiguration->getRefreshExpiredAt()
		]);
		return $refreshToken;
	}

	public static function expired($refreshToken){
		return	IchiRefreshTokenAuthentication::where('refresh_token',$refreshToken)->whereNonExpiredTokens()->exists();
	}

	public static function check($refreshToken){
		return IchiRefreshTokenAuthentication::where('refresh_token',$refreshToken)->where('revoke',false)->exists();
	}

	public static function delete($refreshToken){
		IchiRefreshTokenAuthentication::where('refresh_token',$refreshToken)->delete();
	}

	private static function getRefreshToken($refreshToken){
		return IchiRefreshTokenAuthentication::where('refresh_token',$refreshToken)->first();
	}

	public static function getUser($refreshToken){
		return self::getRefreshToken($refreshToken)->token->user;
	}

	public static function checkParentTokenRevoke($refreshToken){
		return self::getRefreshToken($refreshToken)->token->revoke == false ;
	}

	public static function revokeByParentToken($tokenId){
		IchiRefreshTokenAuthentication::where('token_id',$tokenId)
		->update([
			'revoke' => true
		]);
	}

	public static function revokeByRefreshToken($refreshToken){
		IchiRefreshTokenAuthentication::where('refresh_token',
			$refreshToken)->first()->update([
				'revoke' => true
			]);
		}

		public static function revokeByTokens($tokens){
			IchiRefreshTokenAuthentication::wherein('token_id',$tokens)->update([
				'revoke' => true
			]);
		}

	}