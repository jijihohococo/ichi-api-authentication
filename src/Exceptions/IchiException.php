<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Exceptions;
use Illuminate\Auth\Access\AuthorizationException;
class IchiException extends AuthorizationException{

	public static function invalid(){
		return new static('User Guard is unavailable');
	}

}