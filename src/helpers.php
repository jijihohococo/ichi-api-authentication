<?php

function getTokenFromHeader($header){
	return str_replace("Bearer ","",$header);
}