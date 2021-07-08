<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use Illuminate\Contracts\Auth\{Guard,Authenticatable,UserProvider};
use Illuminate\Http\Request;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiTokenAuthentication,IchiApiAuthentication};
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\{TokenRepository,RefreshTokenRepository};
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
class UserGuard{
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

        if($request->bearerToken() && $this->checkExpired($request->header('Authorization') , $this->guard ) ){
            throw new AuthenticationException('Token is Expired');
        }

    
        $refreshTokenHeader=$request->header('Refresh Token');

        if($refreshTokenHeader!==null && RefreshTokenRepository::check($refreshTokenHeader)==FALSE){
            throw new AuthenticationException("Refresh Token is Invalid");
        }

        if($refreshTokenHeader!==null && RefreshTokenRepository::expired($refreshTokenHeader)==FALSE ){
            throw new AuthenticationException('Refresh Token is Expired');
        }
    }

    private function checkAuthenticated($header,$guard){
        $token=getTokenFromHeader($header);
        return IchiTokenAuthentication::where('token',$token)->where('revoke',0 )->where('api_authentication_id',
            $this->getApiAuthIdByGuard($guard)
        )->where('expired_at','>', Carbon::now() )->first();
    }

    private function getApiAuthIdByGuard($guard){
        return IchiApiAuthentication::where('guard_name',$guard)
        ->first()->id;
    }

    private function checkExpired($header,$guard){
        $token=getTokenFromHeader($header);
        $apiAuthId=$this->getApiAuthIdByGuard($guard);
        return IchiTokenAuthentication::where('token',$token)
        ->where('api_authentication_id', $apiAuthId)->count() > 0 && IchiTokenAuthentication::where('token',$token)
        ->where('api_authentication_id', $apiAuthId )->where('expired_at','<=',Carbon::now())->count()==0;
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