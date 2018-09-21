<?php

namespace Modules\Files\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TypeFileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();
      DB::table('type_files')->insert([
        [
          'name' => 'image-wysiwyg',
          'config' => '{
            "resize": [
              {
			          "name": "medium",
                "width": "345",
                "height": "240",
                "absolute": true
              }
            ],
            "maxsize": "20000",
            "ext":"jpg,png,jpeg,gif"
          }',
        ],
        [
          'name' => 'image-product',
          'config' => '{
            "resize": [
              {
			          "name": "main",
                "width": "280",
                "height": "240",
                "absolute": false
              },
              {
			          "name": "medium",
                "width": "280",
                "height": "180",
                "absolute": false
              },
              {
                "name": "small",
                "width": "80",
                "height": "80",
                "absolute": false
              },
              {
                "name":"s-medium",
                "width": "180",
                "height": "100",
                "absolute": false
              }
            ],
            "maxsize": "20000",
            "ext":"jpg,jpeg,png"
          }',
        ],
        [
          'name' => 'image-type-product',
          'config' => '{
            "resize": [
              {
			          "name": "small",
                "width": "140",
                "height": "140",
                "absolute": false
              }
            ],
            "maxsize": "20000",
            "ext":"jpg,jpeg,png"
          }',
        ],
        [
          'name' => 'file',
          'config' => '{
            "maxsize":"20000"
          }'
        ]
      ]);
        // $this->call("OthersTableSeeder");
    }
}
