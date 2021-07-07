<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateInterval,DateTime;
class IchiConfiguration{
	
	public $expiredAt , $refreshExpiredAt ;

	public function setExpiredAt(DateInterval $date){
		$this->expiredAt=$this->changeCurrentDateFormat($date);
	}

	public function changeCurrentDateFormat(DateInterval $date){
		$currentDate=new DateTime(date("Y-m-d H:i:s"));
		$currentDate->add($date);
		return $currentDate->format('Y-m-d H:i:s');
	}

	public function setRefreshExpiredAt(DateInterval $date){
		$this->refreshExpiredAt=$this->changeCurrentDateFormat($date);
	}

	public function getExpiredAt(){
		return $this->expiredAt;
	}

	public function getRefreshExpiredAt(){
		return $this->refreshExpiredAt;
	}
}