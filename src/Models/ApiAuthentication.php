<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiAuthentication extends Model{
	
	use HasFactory;

	protected $fillable = [
	'guard_name',
	'model_name',
	"model_id",
	"token",
	"expired_at"];

	public function setExpiredAt($expired_at){
		$this->expired_at=$expired_at;
	}

	public function getExpiredAt(){
		return $this->expired_at;
	}
}