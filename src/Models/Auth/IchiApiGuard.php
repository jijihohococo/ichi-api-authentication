<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Models\Auth;
use Illuminate\Contracts\Auth\{Guard,Authenticatable};
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
class IchiApiGuard implements Guard{

     public $provider , $request ;
     public function __construct(UserProvider $provider,Request $request){
          $this->provider=$provider;
          $this->request=$request;
     }

	/**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
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
	public function user(){

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
	public function setUser(Authenticatable $user){

	}
}