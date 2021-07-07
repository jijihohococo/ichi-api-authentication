<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Traits;
use Carbon\Carbon;

trait IchiCheckTokenAuthenticationTrait{


	private function checkAuthenticated($header,$guard){
        $token=str_replace("Bearer ","",$header);
        return IchiTokenAuthentication::where('token',$token)->where('revoke',0 )->where('api_authentication_id',
            IchiApiAuthentication::where('guard_name',$guard)
            ->first()->id
        )->where('expired_at','>', Carbon::now() )->first();
    }

}