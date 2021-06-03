<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Carbon\Carbon;
class Ichi{
	public $expired_at = Carbon::now();

	public function setExpiredAt($expiredDate){
		$this->expired_at=$expiredDate;
	}

	public function getExpiredAt(){
		return $this->expired_at;
	}
}