<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateTimeInterface;
class IchiConfiguration{
	public $expiredAt;
	public function setExpiredAt(DateTimeInterface $date){
		$this->expiredAt=$date;
	}

	public function getExpiredAt(){
		return $this->expiredAt;
	}
}