<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateInterval;
class IchiConfiguration{
	public $expiredAt;
	public function setExpiredAt(DateInterval $date){
		$this->expiredAt=$date->format('Y-m-d H:i:s');
	}

	public function getExpiredAt(){
		return $this->expiredAt;
	}
}