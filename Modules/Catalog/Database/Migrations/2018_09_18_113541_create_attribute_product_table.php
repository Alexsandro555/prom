<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeProductTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('attribute_product', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('product_id')->length(11)->unsigned();
      $table->integer('attribute_id')->length(11)->unsigned();
      $table->string('value', 255);
      $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('attribute_product', function (Blueprint $table) {
      $table->dropForeign('attribute_product_product_id_foreign');
      $table->dropForeign('attribute_product_attribute_id_foreign');
    });
    Schema::dropIfExists('attribute_product');
  }
}
