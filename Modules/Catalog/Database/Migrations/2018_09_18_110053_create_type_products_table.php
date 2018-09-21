<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('type_products', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('remote_id')->nullable();
      $table->integer('category_id')->length(11)->unsigned();
      $table->string('title');
      $table->bigInteger('tnved_id')->length(11)->unsigned();
      $table->integer('sort');
      $table->text('description')->nullable();
      $table->string('url_key', 255)->unique();
      $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
    Schema::table('type_products', function (Blueprint $table) {
      $table->dropForeign('type_products_category_id_foreign');
    });
    Schema::dropIfExists('type_products');
  }
}
