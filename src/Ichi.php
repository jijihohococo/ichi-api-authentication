<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateTimeInterface;
class Ichi{
	public $expired_at;

	public function setExpiredAt(DateTimeInterface $date=null){
		if($date==null){
			$this->expired_at=getStandardExpired();
			return $this;
		}
		$this->expired_at=$date;
		return $this;
	}

	public function getExpiredAt(){
		return $this->expired_at;
	}
}