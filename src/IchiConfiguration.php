<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateInterval,DateTime;
class IchiConfiguration{
	public $expiredAt;
	public function setExpiredAt(DateInterval $date){
		$currentDate=new DateTime(date("Y-m-d H:i:s"));
		$currentDate->add($date);
		$this->expiredAt=$currentDate->format('Y-m-d H:i:s');
	}

	public function getExpiredAt(){
		return $this->expiredAt;
	}
}