<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiAuthenticationTable{
    
	public function up()
    {
        Schema::create('api_authentications', function (Blueprint $table) {
            $table->id();
            $table->string('guard_name');
            $table->string('model_name');
            $table->integer('model_id');
            $table->text('token');
            $table->string('expired_at')
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_authentications');
    }
}