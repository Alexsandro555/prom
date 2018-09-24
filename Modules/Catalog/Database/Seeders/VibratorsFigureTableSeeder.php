<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Classes\VibratorsFigureTable;

class VibratorsFigureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $vibratorsFigure = new VibratorsFigureTable;
        $vibratorsFigure->make();

        // $this->call("OthersTableSeeder");
    }
}
