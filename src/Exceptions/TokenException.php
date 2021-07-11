<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Exceptions;
use Illuminate\Auth\Access\AuthorizationException;
class TokenException extends AuthorizationException{

	public static function invalidToken(){
		return new static('The request token is invalid');
	}

}