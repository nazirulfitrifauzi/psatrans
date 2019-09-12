<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskListMigration extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('task_list', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('subject');
        $table->string('description')->nullable();
        $table->DateTime('deadline');
        $table->string('remarks')->nullable();
        $table->string('assign_to')->nullable();
        $table->string('request_by');
        $table->integer('priority');
        $table->string('status')->length(2)->default('I');
        $table->DateTime('delete_on')->nullable();
        $table->string('delete_by')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::dropIfExists('task_list');
  }
}
