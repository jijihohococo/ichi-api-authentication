<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Repository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiApiAuthentication,IchiTokenAuthentication};
use JiJiHoHoCoCo\IchiApiAuthentication\Ichi;
use Illuminate\Support\Facades\Hash;
class TokenRepository{

	public static function getApiId($guard){
		return IchiApiAuthentication::where('guard_name',$guard)->first()->id;
	}

	public static function updateOrCreate($guard,$userId){
		
			$apiId=self::getApiId($guard);
		
				return IchiTokenAuthentication::updateOrCreate(
					['user_id'=>$userId , 'api_authentication_id' => $apiId ],
					[
						'user_id' => $userId ,
						'token' => Hash::make($guard. $userId . time()) ,
						'expired_at' => "date",
						'api_authentication_id' => $apiId,
						'revoke' => false
					]);
			
	}

	public function revoke($id){
		IchiTokenAuthentication::findOrFail($id)->update([
			'revoke' => true
		]);
	}

}