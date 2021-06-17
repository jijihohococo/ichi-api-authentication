<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateInterval;
class IchiConfiguration{
	public $expiredAt;
	public function setExpiredAt(DateInterval $date){
		$this->expiredAt=$date->format("P%yY%mM%dDT%hH%iM%sS");
	}

	public function getExpiredAt(){
		return $this->expiredAt;
	}
}