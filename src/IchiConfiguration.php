<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateInterval;
class IchiConfiguration{
	public $expiredAt;
	public function setExpiredAt(DateInterval $date){
		$this->expiredAt=$date;
	}

	public function getExpiredAt(){
		return $this->expiredAt;
	}
}