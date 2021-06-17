<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Carbon\Carbon;
use DateInterval;
class Ichi{
	public static $expired_at;

	public static function setExpiredAt(DateInterval $date=null){
		if($date==null){
			return	static::$expired_at !== null ?  Carbon::now()->diff(static::$expired_at ) :  getStandardExpired();
		}
		self::$expired_at=$date;
		return new static;
	}
}