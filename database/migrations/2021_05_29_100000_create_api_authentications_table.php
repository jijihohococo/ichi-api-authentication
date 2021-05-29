<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiAuthenticationTable{
    
    protected $schema;

    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

	public function up()
    {
        $this->schema->create('api_authentications', function (Blueprint $table) {
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
        $this->schema->dropIfExists('api_authentications');
    }
}