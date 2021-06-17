<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Carbon\Carbon;
use DateTimeInterface;
class Ichi{
	public static $expired_at;

	public static function setExpiredAt(DateTimeInterface $date=null){
		if($date==null){
			return	static::$expired_at ! == null ?  Carbon::now()->diff(static::$expired_at ) :  getStandardExpired();
		}
		self::$expired_at=$date;
		return new static;
	}
}