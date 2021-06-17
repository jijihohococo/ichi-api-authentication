<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Carbon\Carbon;
use DateTimeInterface;
use DateInterval;
class Ichi{
	public static $expired_at;

	public static function setExpiredAt(DateTimeInterface $date=null){
		if($date==null){
			return	static::$expired_at !== null ?  Carbon::now()->diff(static::$expired_at ) :  new DateInterval('P5D');
		}
		self::$expired_at=$date;
		return new static;
	}
}