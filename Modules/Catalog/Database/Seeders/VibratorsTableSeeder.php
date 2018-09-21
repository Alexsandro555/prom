<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Classes\Vibrators;
use Illuminate\Support\Facades\DB;

class VibratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $vibrators = new Vibrators;
        $vibrators->make();
        // $this->call("OthersTableSeeder");
    }
}
