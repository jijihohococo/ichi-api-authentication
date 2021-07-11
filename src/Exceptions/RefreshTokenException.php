<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Exceptions;
use Illuminate\Auth\Access\AuthorizationException;
class RefreshTokenException extends AuthorizationException{

	public static function invalidToken(){
		return new static('The request refresh token is invalid');
	}

}