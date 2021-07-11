<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JiJiHoHoCoCo\IchiApiAuthentication\Traits\TokenTrait;
class IchiTokenAuthentication extends Model{

	use HasFactory,TokenTrait;

	public $refreshToken , $refreshTokenExpiredTime ;


	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ichi_token_authentications';

	/**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];


		/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
		protected $dates = [
			'expired_at',
		];

		public function user(){
			return $this->belongsTo($this->getUserModel($this->api_authentication_id)  , 'user_id')->withDefault();
		}

		private function getUserModel($apiAuthenticationId){
			return IchiApiAuthentication::findOrFail($apiAuthenticationId)->model_name;
		}

		public function apiAuthentication(){
			return $this->belongsTo('JiJiHoHoCoCo\IchiApiAuthentication\Models\IchiApiAuthentication','api_authentication_id')->withDefault();
		}

		public function setRefreshToken($refreshToken){
			$this->refreshToken=$refreshToken;
		}

		public function setRefreshTokenExpiredTime($refreshTokenExpiredTime){
			$this->refreshTokenExpiredTime=$refreshTokenExpiredTime;
		}

		public function getToken(){
			return $this->token;
		}

		public function getTokenId(){
			return $this->id;
		}


	}