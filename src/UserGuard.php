<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Illuminate\Contracts\Auth\{Guard,Authenticatable,UserProvider};
use Illuminate\Http\Request;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiTokenAuthentication,IchiApiAuthentication};
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\TokenRepository;
use Carbon\Carbon;
use JiJiHoHoCoCo\IchiApiAuthentication\Traits\IchiCheckTokenAuthenticationTrait;
class UserGuard{

    use IchiCheckTokenAuthenticationTrait;
	/**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public $provider,$user,$guard;
    public function __construct(IchiUserProvider $provider,$guard){
        $this->provider=$provider;
        $this->guard=$guard;
    }

    public function check(){
        return $this->user == null ? false : true ;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(){
        return $this->user == null ? true : false;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user(Request $request){
        if ($request->bearerToken() && ($ichiToken=$this->checkAuthenticated($request->header('Authorization') , $this->guard ))!==null ) {
            $this->user=$this->provider->retrieveById($ichiToken->user_id);
            return $this->user->withAccessToken(TokenRepository::getToken($this->guard ,$ichiToken->user_id));
        }
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id(){
        return $this->user !== null ? $this->user->id : null ;
    }
}