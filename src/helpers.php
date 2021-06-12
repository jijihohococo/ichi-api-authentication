<?php
use Carbon\Carbon;

function getStandardExpired(){
	return Carbon::now()->addDays(5);
}