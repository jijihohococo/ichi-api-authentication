<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateInterval;
class IchiConfiguration{
	public $expiredAt;
	public function setExpiredAt(DateInterval $date){
		$currentDate=date("Y-m-d H:i:s");
		$currentDate->add($date);
		$this->expiredAt=$currentDate->format('Y-m-d H:i:s');
	}

	public function getExpiredAt(){
		return $this->expiredAt;
	}
}