<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Illuminate\Contracts\Auth\{Guard,Authenticatable,UserProvider};
use Illuminate\Http\Request;
class UserGuard{
	/**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public $provider;
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

    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user(Request $request){
        if ($request->bearerToken()) {
            
        }
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id(){

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