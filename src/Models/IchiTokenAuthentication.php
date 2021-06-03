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

		public function user(){
			return $this->belongsTo($this->getUserModel($this->api_authentication_id)  , 'user_id')->default();
		}

		private function getUserModel($apiAuthenticationId){
			return IchiApiAuthentication::findOrFail($apiAuthenticationId)->model_name;
		}

		public function setExpiredAt($expired_at){
			$this->expired_at=$expired_at;
		}

		public function getExpiredAt(){
			return $this->expired_at;
		}

		public function apiAuthentication(){
			return $this->belongsTo('Models\IchiApiAuthentication','api_authentication_id')->withDefault();
		}


	}