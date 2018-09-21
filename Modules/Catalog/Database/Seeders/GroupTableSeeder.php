<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('groups')->insert([
          [
            'title' => 'Характеристики',
          ],
          [
            'title' => 'Вал',
          ],
          [
            'title' => 'Игла (наконечник)',
          ],
          [
            'title' => 'Механические свойства',
          ],
          [
            'title' => 'SKF подшипник: 6202 2RS',
          ],
          [
            'title' => 'Электрические свойства',
          ],
          [
            'title' => 'SKF подшипник: NJ 2315 C3',
          ],
          [
            'title' => 'SKF подшипник: NJ 2317 C3',
          ],
          [
            'title' => 'SKF подшипник: NJ 2307 C3',
          ],
          [
            'title' => 'SKF подшипник: 6306 2RS',
          ],
          [
            'title' => 'SKF подшипник: NJ 306 C3',
          ],
          [
            'title' => 'SKF подшипник: 6305 2RS',
          ],
          [
            'title' => 'SKF подшипник',
          ],
          [
            'title' => 'SKF подшипник: 6303 2RS',
          ],
          [
            'title' => 'SKF подшипник: 6302 2RS',
          ],
          [
            'title' => 'Вибратор',
          ],
          [
            'title' => 'Динамический момент',
          ],
          [
            'title' => 'Вынуждающая сила (FC)',
          ],
          [
            'title' => 'Потребление воздуха',
          ],
          [
            'title' => 'SKF подшипник: 6304 2RS',
          ],
          [
            'title' => 'SKF подшипник: 6305 RS',
          ],
          [
            'title' => 'SKF подшипник: NJ 2308 C3',
          ],
          [
            'title' => 'SKF подшипник: NJ 2311 C3',
          ],
          [
            'title' => 'SKF подшипник: ',
          ],
          [
            'title' => 'Энергия',
          ],
          [
            'title' => 'Сила удара',
          ],
        ]);
        // $this->call("OthersTableSeeder");
    }
}
