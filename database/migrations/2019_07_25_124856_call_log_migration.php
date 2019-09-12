<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CallLogMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('call_log', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('contact_name')->nullable();
          $table->string('contact_no');
          $table->string('subject')->nullable();
          $table->string('description');
          $table->string('status')->default('in-proggress');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_log');
    }
}
