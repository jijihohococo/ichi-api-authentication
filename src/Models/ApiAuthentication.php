<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiAuthentication extends Model{
	
	use HasFactory;

	protected $fillable = [
	'guard_name',
	'model_name'];
}