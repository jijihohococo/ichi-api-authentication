<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;

class IchiConfiguration{
	public $expiredAt;
	public function setExpiredAt($date){
		$this->expiredAt=$date;
	}

	public function getExpiredAt(){
		return $this->expiredAt;
	}
}