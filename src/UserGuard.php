<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Illuminate\Contracts\Auth\{Guard,Authenticatable,UserProvider};
use Illuminate\Http\Request;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\IchiTokenAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\TokenRepository;
class UserGuard{
	/**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public $provider,$user;
    public function __construct(IchiUserProvider $provider){
        $this->provider=$provider;
    }

    public function check(){

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
        return $this->provider;
        if ($request->bearerToken() && $ichiToken=$this->checkAuthenticated($request->header('Authorization'))!==null ) {
            $this->user=$this->provider->retrieveById($ichiToken->user_id);
            return $this->user->withAccessToken(TokenRepository::updateOrCreate($ichiToken->apiAuthentication->guard_name,$ichiToken->user_id)->token);
        }
    }

    private function checkAuthenticated($header){
        $token=str_replace("Bearer ","",$header);
        return IchiTokenAuthentication::where('token',$token)->where('revoke',true)->first();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id(){
        return $this->user->id;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []){

    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    // public function setUser(Authenticatable $user){

    // }
}