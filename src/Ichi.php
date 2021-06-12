<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
class Ichi{
	public $expired_at;

	public function setExpiredAt($expiredDate){
		$this->expired_at=$expiredDate;
		return $this;
	}

	public function getExpiredAt(){
		return $this->expired_at==null ? getStandardExpired() : $this->expired_at ;
	}
}