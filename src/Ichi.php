<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Carbon\Carbon;
class Ichi{
	public $expired_at;

	public function setExpiredAt($expiredDate){
		$this->expired_at=$expiredDate;
	}

	public function getExpiredAt(){
		return $this->expired_at==null ? Carbon::now()->addDays(5) : $this->expired_at ;
	}
}