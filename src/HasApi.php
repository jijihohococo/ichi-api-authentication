<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication;
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\TokenRepository;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiApiAuthentication,IchiTokenAuthentication};
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use JiJiHoHoCoCo\IchiApiAuthentication\Traits\IchiCheckTokenAuthenticationTrait;
trait HasApi{

	use IchiCheckTokenAuthenticationTrait;

	public $accessToken;

	public function getAllTokens(){
		return IchiTokenAuthentication::where('api_authentication_id',
			$this->getApiId() )
		->where('user_id',$this->id)
		->get();
	}

	public function revoke(){
		TokenRepository::revoke(
			IchiTokenAuthentication::select('id')
			->where('api_authentication_id', $this->getApiId() )
			->where('user_id',$this->id)
			->first()
			->id
		);
	}
	
	public function withAccessToken($accessToken){
		$this->accessToken=$accessToken;
		return $this;
	}

	public function accessToken(){
		return $this->accessToken;
	}

	public function ichiToken(){
		return $this->checkGuard() > 0 ? 
		Container::getInstance()->make(TokenRepository::class)
		->make($this->getGuard(),[
		'id' =>	$this->id ,
		'email' =>	$this->email ,
		'password' =>	$this->password
		]) : null ;
	}

	public function checkGuard(){
		return IchiApiAuthentication::where('model_name',get_class($this))->count();
	}

	public function getGuard(){
		return IchiApiAuthentication::select('guard_name')->where('model_name', get_class($this) )->first()->guard_name;
	}

	public function getApiId(){
		return IchiApiAuthentication::select('id')->where('model_name',get_class($this))->first()->id;
	}

	public function expired(Request $request){
		$providers=(array)collect(config('auth.providers'))->where('model', get_class($this) );
        $selectedProvider=array_keys($providers[array_key_first($providers)])[0];
        $guards=(array)collect(config('auth.guards'))->where('driver','ichi')->where('provider',$selectedProvider);
        $selectedGuard=array_keys($guards[array_key_first($guards)])[0];
        return $this->checkAuthenticated($request->header('Authorization') , $selectedGuard);
	}
}