<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Repository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiApiAuthentication,IchiTokenAuthentication};
use JiJiHoHoCoCo\IchiApiAuthentication\Ichi;
class TokenRepository{

	public static function getApiId($guard){
		return IchiApiAuthentication::where('guard_name',$guard)->first()->id;
	}

	public static function updateOrCreate($guard,$userId){
		try{
			$apiId=self::getApiId($guard);
			if($apiId!==null ){
				return IchiTokenAuthentication::updateOrCreate(
					['user_id'=>$userId , 'api_authentication_id' => $apiId ],
					[
						'user_id' => $userId ,
						'token' => rand(),
						'expired_at' => "date",
						'api_authentication_id' => $apiId,
						'revoke' => false
					]);
			}
		}catch(\Exception $e){

		}
	}

	public function revoke($id){
		IchiTokenAuthentication::findOrFail($id)->update([
			'revoke' => true
		]);
	}

}