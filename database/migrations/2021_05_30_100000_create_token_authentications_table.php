<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenAuthenticationTable{
    
    protected $schema;

    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up()
    {
        $this->schema->create('token_authentications', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('token');
            $table->string('expired_at');
            $table->integer('api_authentication_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('token_authentications');
    }
}