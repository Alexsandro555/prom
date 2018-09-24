<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVibratorsFigureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vibrators_figure', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 10);
          $table->string('dimc', 255)->nullable();
          $table->string('dimm', 255)->nullable();
          $table->string('dima', 255)->nullable();
          $table->string('dimb', 255)->nullable();
          $table->string('dimg', 255)->nullable();
          $table->string('dimd', 255)->nullable();
          $table->string('dime', 255)->nullable();
          $table->string('dimf', 255)->nullable();
          $table->string('dimh', 255)->nullable();
          $table->string('dimi', 255)->nullable();
          $table->string('diml', 255)->nullable();
          $table->string('dimn', 255)->nullable();
          $table->string('dimxy', 255)->nullable();
          $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vibrators_figure');
    }
}
