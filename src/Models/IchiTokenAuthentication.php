<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IchiTokenAuthentication extends Model{

	use HasFactory;

	protected $fillable = [
		'user_id',
		'token',
		'expired_at',
		'revoke',
		'api_authentication_id'];


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