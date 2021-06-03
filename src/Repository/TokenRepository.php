<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Repository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{ApiAuthentication,TokenAuthentication};
use JiJiHoHoCoCo\IchiApiAuthentication\Ichi;
class TokenRepository{

	public static function getApiId($guard){
		return ApiAuthentication::where('guard_name',$guard)->first()->id;
	}

	public static function updateOrCreate($guard,$userId){
		try{
			$apiId=self::getApiId($guard);
			if($apiId!==null ){
				return TokenAuthentication::updateOrCreate(
					['user_id'=>$userId , 'api_authentication_id' => $apiId ],
					[
						'user_id' => $userId ,
						'token' => random(),
						'expired_at' => "date",
						'api_authentication_id' => $apiId,
						'revoke' => false
					]);
			}
		}catch(\Exception $e){

		}
	}

	public function revoke($id){
		TokenAuthentication::findOrFail($id)->update([
			'revoke' => true
		]);
	}

}