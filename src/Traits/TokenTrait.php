<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Traits;
use Carbon\Carbon;
trait TokenTrait{
	
	public function scopeRemoveRevokedTokens($query){
		return $query->where('revoke',true)->delete();
	}

	public function scopeWhereExpiredTokens($query){
		return $query->where('expired_at','<=',Carbon::now());
	}

	public function scopeWhereNonExpiredTokens($query){
		return $query->where('expired_at','>',Carbon::now());
	}


}

