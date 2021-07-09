<?php

function getTokenFromHeader($header){
	return str_replace("Bearer ","",$header);
}

function checkBearer($header){
	return substr($header, 0,7) === "Bearer ";
}