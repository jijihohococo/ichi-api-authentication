<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Carbon\Carbon;
use DateTimeInterface,DateInterval;
class Ichi{

	public static $expired_at , $refresh_expired_at;

	public static function setExpiredAt(DateTimeInterface $date=null){
		if($date==null){
			return	static::$expired_at !== null ?  Carbon::now()->diff(static::$expired_at ) :  new DateInterval('P1Y');
		}
		self::$expired_at=$date;
		return new static;
	}

	public static function setRefreshExpiredAt(DateTimeInterface $date=null){
		if($date==null){
			return	static::$refresh_expired_at !== null ?  Carbon::now()->diff(static::$refresh_expired_at ) :  new DateInterval('P1Y');
		}
		self::$refresh_expired_at=$date;
		return new static;
	}
}