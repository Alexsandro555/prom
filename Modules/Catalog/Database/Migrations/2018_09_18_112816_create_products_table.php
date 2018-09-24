<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    $tableName = 'products';

    Schema::create($tableName, function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->comment('Идентефикатор');
      $table->integer('remote_id')->nullable();
      $table->string('title', 255)->comment('Название продукта');
      $table->string('url_key', 255)->comment('url');
      $table->decimal('price',10,2)->comment('Цена');
      $table->text('description')->nullable()->comment('Описание');
      $table->integer('qty')->nullable()->comment('количество');
      $table->boolean('active')->default(false)->nullable()->comment('Актив.');
      $table->integer('sort')->nullable()->comment('Сорт.');
      $table->boolean('onsale')->nullable()->comment('Скидка');
      $table->boolean('special')->nullable()->comment('Спецпредложение');
      $table->boolean('need_order')->nullable()->comment('Необходимо заказывать');
      $table->integer('type_product_id')->unsigned()->nullable()->comment('Тип продукта');
      $table->string('vendor')->nullable()->comment('Артикул');
      $table->string('IEC')->nullable()->comment('IEC');
      $table->integer('line_product_id')->unsigned()->nullable()->comment('Линейка продукции');
      $table->boolean('storage')->default(false)->nullable();
      $table->string('guarantee',255)->nullable();
      $table->integer('old_id')->nullable();
      $table->integer('figureid')->nullable();
      $table->integer('typeid')->nullable();
      $table->string('dima')->nullable();
      $table->string('dimb')->nullable();
      $table->string('dimc')->nullable();
      $table->string('dimd')->nullable();
      $table->string('dime')->nullable();
      $table->string('dimf')->nullable();
      $table->string('dimh')->nullable();
      $table->string('dimg')->nullable();
      $table->string('dimi')->nullable();
      $table->string('diml')->nullable();
      $table->string('dimm')->nullable();
      $table->string('dimn')->nullable();
      $table->decimal('special_price',10,2)->nullable();
      $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      $table->softDeletes();
      $table->foreign('type_product_id')->references('id')->on('type_products')->onDelete('cascade');
      $table->foreign('line_product_id')->references('id')->on('line_products')->onDelete('cascade');
    });

    DB::statement("ALTER TABLE `$tableName` comment 'Продукция'");
  }


  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('products', function (Blueprint $table) {
      $table->dropForeign('products_line_product_id_foreign');
      $table->dropForeign('products_type_product_id_foreign');
    });
    Schema::dropIfExists('products');
  }
}
