<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIchiRefreshTokenAuthenticationsTable extends Migration{
    
    protected $schema;

    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up()
    {
        $this->schema->create('ichi_refresh_token_authentications', function (Blueprint $table) {
            $table->id();
            $table->text('refresh_token');
            $table->string('token_id');
            $table->boolean('revoke');
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('ichi_refresh_token_authentications');
    }

    public function getConnection()
    {
        return config('ichi.storage.database.connection');
    }
}