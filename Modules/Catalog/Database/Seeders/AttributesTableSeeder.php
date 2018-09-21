<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('attributes')->insert([
          [
            'title' => 'Вес',
            'sort' => 1,
          ],
          [
            'title' => 'Рабочий момент',
            'sort' => 1,
          ],
          [
            'title' => 'Вынуждающая сила',
            'sort' => 1,
          ],
          [
            'title' => 'Размер',
            'sort' => 1,
          ],
          [
            'title' => 'Мощность',
            'sort' => 1,
          ],
          [
            'title' => 'Максимальный ток',
            'sort' => 1,
          ],
          [
            'title' => 'Ia/In',
            'sort' => 1,
          ],
          [
            'title' => 'Температура',
            'sort' => 1,
          ],
          [
            'title' => '100% нагрузка',
            'sort' => 1,
          ],
          [
            'title' => '80% нагрузка',
            'sort' => 1,
          ],
          [
            'title' => '50% нагрузка',
            'sort' => 1,
          ],
          [
            'title' => 'Энергия',
            'sort' => 1,
          ],
          [
            'title' => '2 бара',
            'sort' => 1,
          ],
          [
            'title' => '3 бара',
            'sort' => 1,
          ],
          [
            'title' => '4 бара',
            'sort' => 1,
          ],
          [
            'title' => '6 бара',
            'sort' => 1,
          ],
          [
            'title' => 'Частота 2 бара',
            'sort' => 1,
          ],
          [
            'title' => 'Частота 4 бара',
            'sort' => 1,
          ],
          [
            'title' => 'Частота 6 бара',
            'sort' => 1,
          ],
          [
            'title' => '0.2 бара',
            'sort' => 1,
          ],
          [
            'title' => '0.8 бара',
            'sort' => 1,
          ],
          [
            'title' => 'Цвет мембраны',
            'sort' => 1,
          ],
          [
            'title' => 'Материал',
            'sort' => 1,
          ],
          [
            'title' => 'Минимальная температура',
            'sort' => 1,
          ],
          [
            'title' => 'Максимальная температура',
            'sort' => 1,
          ],
          [
            'title' => 'Частота вибрации',
            'sort' => 1,
          ],
          [
            'title' => 'Амплитуда',
            'sort' => 1,
          ],
          [
            'title' => 'Действие',
            'sort' => 1,
          ],
          [
            'title' => 'Производительность',
            'sort' => 1,
          ],
          [
            'title' => 'Центробежная сила',
            'sort' => 1,
          ],
          [
            'title' => 'Длина вала',
            'sort' => 1,
          ],
          [
            'title' => 'Вес вала',
            'sort' => 1,
          ],
          [
            'title' => 'Диаметр иглы',
            'sort' => 1,
          ],
          [
            'title' => 'Длина иглы',
            'sort' => 1,
          ],
          [
            'title' => 'Вес иглы',
            'sort' => 1,
          ],
          [
            'title' => 'Рабочее давление',
            'sort' => 1,
          ],
          [
            'title' => 'Макс. давление',
            'sort' => 1,
          ],
          [
            'title' => 'Статический момент',
            'sort' => 1,
          ],
          [
            'title' => '3000 гц',
            'sort' => 1,
          ],
          [
            'title' => '6000 гц',
            'sort' => 1,
          ],
        ]);
        // $this->call("OthersTableSeeder");
    }
}
