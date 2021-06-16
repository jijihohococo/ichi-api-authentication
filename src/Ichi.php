<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use DateTimeInterface;
class Ichi{
	public static $expired_at;

	public static function setExpiredAt(DateTimeInterface $date=null){
		if($date==null){
			return getStandardExpired();
		}
		self::$expired_at=$date;
		return new static;
	}
}