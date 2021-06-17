<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IchiTokenAuthentication extends Model{

	use HasFactory;


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
			return $this->belongsTo('Models\IchiApiAuthentication','api_authentication_id')->withDefault();
		}


	}