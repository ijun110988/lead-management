<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->text('error_message');
            $table->string('endpoint');
            $table->integer('status_code');
            $table->timestamp('timestamp');
        });
    }

    public function down()
    {
        Schema::dropIfExists('error_logs');
    }
};
