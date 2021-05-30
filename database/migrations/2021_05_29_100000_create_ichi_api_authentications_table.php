<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIchiApiAuthenticationTable extends Migration{

    protected $schema;

    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up()
    {
        $this->schema->create('ichi_api_authentications', function (Blueprint $table) {
            $table->id();
            $table->string('guard_name');
            $table->string('model_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('ichi_api_authentications');
    }

    public function getConnection()
    {
        return config('ichi.storage.database.connection');
    }
}