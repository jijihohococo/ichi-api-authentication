<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{ApiAuthentication,TokenAuthentication};
trait Token{

	public function getApiId($guard){
		return ApiAuthentication::where('guard_name',$guard)->first()->id;
	}

	public function generate($guard,$userId){
		try{
			$apiId=$this->getApiId($guard);
			if($apiId!==null ){
				return TokenAuthentication::updateOrCreate(
					['user_id'=>$userId , 'api_authentication_id' => $apiId ],
					[
						'user_id' => $userId ,
						'token' => random(),
						'expired_at' => "date",
						'api_authentication_id' => $apiId
					]);
			}
		}catch(\Exception $e){

		}
	}

}