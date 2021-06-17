<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIchiTokenAuthenticationsTable extends Migration{
    
    protected $schema;

    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up()
    {
        $this->schema->create('ichi_token_authentications', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('token');
            $table->dateTime('expired_at')->nullable();
            $table->integer('api_authentication_id');
            $table->boolean('revoke');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('ichi_token_authentications');
    }

    public function getConnection()
    {
        return config('ichi.storage.database.connection');
    }
}