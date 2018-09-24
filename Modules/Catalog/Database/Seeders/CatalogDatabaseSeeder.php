<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(CategoryTableSeeder::class);
        $this->call(TypeFileTableSeeder::class);
        $this->call(TnvedsTableSeeder::class);
        $this->call(TypeProductsTableSeeder::class);
        $this->call(ProducerTableSeeder::class);
        $this->call(LineProductTableSeeder::class);
        $this->call(AttributesTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(VibratorsTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(VibratorsFigureTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
