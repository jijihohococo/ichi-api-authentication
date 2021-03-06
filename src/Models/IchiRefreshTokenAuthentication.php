<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JiJiHoHoCoCo\IchiApiAuthentication\Traits\TokenTrait;
class IchiRefreshTokenAuthentication extends Model{
	
	use HasFactory,TokenTrait;

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'ichi_refresh_token_authentications';

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

		public function token(){
			return $this->belongsTo('JiJiHoHoCoCo\IchiApiAuthentication\Models\IchiTokenAuthentication','token_id')->withDefault();
		}
	}