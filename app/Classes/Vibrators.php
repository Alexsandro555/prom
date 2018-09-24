<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 15.02.18
 * Time: 9:15
 */

namespace App\Classes;

use Modules\Catalog\Entities\LineProduct;
use App\PneumaticVibratorTypes;
use App\PneumaticVibrator;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\AttributeProduct;
use App\VibratorParentType;
use App\VibratorType;
use App\Vibrator;
use App\ConcreteVibratorType;
use App\ConcreteVibrator;
use Illuminate\Support\Facades\DB;
use App\Group;

class Vibrators
{
  public function make() {
    $lineProduct = new LineProduct;


    //==============================Пневматиеские вибраторы=================================================
    $pneumaticVibratorTypes = PneumaticVibratorTypes::All();
    $arrPneumaticVibratorTypes = [];
    foreach ($pneumaticVibratorTypes as $pneumaticVibratorType) {
      $result = $lineProduct->where('title',$pneumaticVibratorType->name)->first();
      $item["old_id"] = $pneumaticVibratorType->id;
      $item["name"] = $pneumaticVibratorType->name;
      $item['id'] = $result->id;
      $arrPneumaticVibratorTypes[] = $item;
    }

    $pneumaticVibrator = new PneumaticVibrator;
    foreach ($arrPneumaticVibratorTypes as $arrPneumaticVibratorType) {
      $pneumaticVibrators = $pneumaticVibrator->where('typeid',$arrPneumaticVibratorType["old_id"])->get();
      foreach ($pneumaticVibrators as $pneumaticVibrator) {
        $product = new Product;
        $product->title = $pneumaticVibrator->name;
        $product->url_key = \Slug::make($pneumaticVibrator->name);
        $product->price = $pneumaticVibrator->price;
        $product->active = 1;
        $product->type_product_id = $pneumaticVibrator->id>50?3:2;
        $product->line_product_id = $arrPneumaticVibratorType["id"];
        //$product->producer_id = 1;
        $product->storage = true;
        $product->guarantee = '12 месяцев';
        $product->old_id = $pneumaticVibrator->id;
        $product->qty = $pneumaticVibrator->onstock;
        $product->figureid = $pneumaticVibrator->figureid;
        //$product->category_id = 1;
        $product->typeid = $pneumaticVibrator->typeid;
        $product->dima = $pneumaticVibrator->dima;
        $product->dimb = $pneumaticVibrator->dimb;
        $product->dimc = $pneumaticVibrator->dimc;
        $product->dimd = $pneumaticVibrator->dimd;
        $product->dime = $pneumaticVibrator->dime;
        $product->dimf = $pneumaticVibrator->dimf;
        $product->dimg = $pneumaticVibrator->dimg;
        $product->dimh = $pneumaticVibrator->dimh;
        $product->diml = $pneumaticVibrator->diml;
        $product->dimm = $pneumaticVibrator->dimm;
        $product->dimn = $pneumaticVibrator->dimxy;
        $product->save();

      //===============Завершение пневматических вибраторов=======================




        // аэрация
        if($pneumaticVibrator->id > 50) {
          $group = DB::table('groups')->where('title','Вибратор')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->weight;
          if($val) {
            $attribute = DB::table('attributes')->where('title','Вес')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val." кг";
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }

          $val = $pneumaticVibrator->fc;
          if($val) {
            $attribute = DB::table('attributes')->where('title','Цвет мембраны')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val;
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }

          $val = $pneumaticVibrator->vpm;
          if($val) {
            $attribute = DB::table('attributes')->where('title','Материал')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val;
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }

          $val = $pneumaticVibrator->workmoment;
          if($val) {
            $val = substr($val,0,strpos($val,'/'));
            $attribute = DB::table('attributes')->where('title','Минимальная температура')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val." °С";
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }

          $val = $pneumaticVibrator->workmoment;
          if($val) {
            $val = substr($val,strpos($val,'/')+1,strlen($val));
            $attribute = DB::table('attributes')->where('title','Максимальная температура')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val." °С";
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }

          $group = DB::table('groups')->where('title','Потребление воздуха')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->airconsump;
          if($val) {
            $arrVals = explode('/',$val);

            if(isset($arrVals[0]))
            {
              $attribute = DB::table('attributes')->where('title','2 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[0]." л/мин";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[1]))
            {
              $attribute = DB::table('attributes')->where('title','4 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[1]." л/мин";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[2]))
            {
              $attribute = DB::table('attributes')->where('title','6 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[2]." л/мин";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[3]))
            {
              $attribute = DB::table('attributes')->where('title','0.8 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[3];
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }

          }
        }
        if($pneumaticVibrator->id <30 || ($pneumaticVibrator->id>40 && $pneumaticVibrator->id<51)) {
          $group = DB::table('groups')->where('title','Вибратор')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->weight;
          if($val) {
            $attribute = DB::table('attributes')->where('title','Вес')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val." кг";
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }

          $val = $pneumaticVibrator->vpm;
          if($val) {
            $arrVals = explode('/',$val);

            if(isset($arrVals[0]))
            {
              $attribute = DB::table('attributes')->where('title','Частота 2 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[0]." Гц";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[1]))
            {
              $attribute = DB::table('attributes')->where('title','Частота 4 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[1]." Гц";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[2]))
            {
              $attribute = DB::table('attributes')->where('title','Частота 6 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[2]." Гц";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
          }


          $group = DB::table('groups')->where('title','Динамический момент')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->workmoment;
          if($val) {
            $arrVals = explode('/',$val);

            if(isset($arrVals[0]))
            {
              $attribute = DB::table('attributes')->where('title','Частота 2 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[0]." кг*см";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[1]))
            {
              $attribute = DB::table('attributes')->where('title','Частота 4 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[1]." кг*см";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[2]))
            {
              $attribute = DB::table('attributes')->where('title','Частота 6 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[2]." кг*см";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
          }



          $group = DB::table('groups')->where('title','Вынуждающая сила (FC)')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->fc;
          if($val) {
            $arrVals = explode('/',$val);

            if(isset($arrVals[0]))
            {
              $attribute = DB::table('attributes')->where('title','2 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $expr = (int)$arrVals[0]/100;
              $attributeProduct->value = $expr." kH";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[1]))
            {
              $attribute = DB::table('attributes')->where('title','4 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $expr = (int)$arrVals[1]/100;
              $attributeProduct->value = $expr." kH";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[2]))
            {
              $attribute = DB::table('attributes')->where('title','6 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $expr = (int)$arrVals[2]/100;
              $attributeProduct->value = $expr." kH";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
          }

          $group = DB::table('groups')->where('title','Потребление воздуха')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->airconsump;
          if($val) {
            $arrVals = explode('/',$val);

            if(isset($arrVals[0]))
            {
              $attribute = DB::table('attributes')->where('title','2 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[0]." л/мин";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[1]))
            {
              $attribute = DB::table('attributes')->where('title','4 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[1]." л/мин";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[2]))
            {
              $attribute = DB::table('attributes')->where('title','6 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[2]." л/мин";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
          }
        }
        if($pneumaticVibrator->id>30 && $pneumaticVibrator->id<41) {
          $group = DB::table('groups')->where('title','Вибратор')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->weight;
          if($val) {
            $attribute = DB::table('attributes')->where('title','Вес')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val." кг";
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }

          $group = DB::table('groups')->where('title','Энергия')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->fc;
          if($val) {
            $arrVals = explode('/',$val);

            if(isset($arrVals[0]))
            {
              $attribute = DB::table('attributes')->where('title','3 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[0]." Дж.";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[1]))
            {
              $attribute = DB::table('attributes')->where('title','6 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[1]." Дж.";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
          }


          $group = DB::table('groups')->where('title','Сила удара')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->workmoment;
          if($val) {
            $arrVals = explode('/',$val);

            if(isset($arrVals[0]))
            {
              $attribute = DB::table('attributes')->where('title','3 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[0]." H";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[1]))
            {
              $attribute = DB::table('attributes')->where('title','6 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[1]." H";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
          }


          $group = DB::table('groups')->where('title','Потребление воздуха')->first();
          $groupId = $group->id;

          $val = $pneumaticVibrator->airconsump;
          if($val) {
            $arrVals = explode('/',$val);

            if(isset($arrVals[0]))
            {
              $attribute = DB::table('attributes')->where('title','3 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[0]." л/мин";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
            if(isset($arrVals[1]))
            {
              $attribute = DB::table('attributes')->where('title','6 бара')->first();
              $attributeProduct = new AttributeProduct;
              $attributeProduct->product_id = $product->id;
              $attributeProduct->attribute_id = $attribute->id;
              $attributeProduct->value = $arrVals[1]." л/мин";
              $attributeProduct->group_id = $groupId;
              $attributeProduct->save();
            }
          }
        }
      }
    }

    //=============================Площадочные вибраторы=================================================
    $vibratorParentTypes = VibratorParentType::All();
    $arrVibratorsTypes = [];
    foreach ($vibratorParentTypes as $vibratorParentType) {
      $result = $lineProduct->where('title',$vibratorParentType->name)->first();
      $vibratorTypes = VibratorType::where('typeid',$vibratorParentType->id)->get();
      foreach ($vibratorTypes as $vibratorType) {
        $item["old_id"] = $vibratorType->id;
        $item["name"] = $vibratorParentType->name;
        $item['id'] = $result->id;
        $arrVibratorsTypes[] = $item;
      }
    }
    $vibrator = new Vibrator;
    foreach ($arrVibratorsTypes as $arrVibratorsType) {
      $Vibrators = $vibrator->where('typeid',$arrVibratorsType["old_id"])->get();
      foreach ($Vibrators as $Vibrator) {
        $product = new Product;
        $product->title = $Vibrator->name;
        $product->url_key = \Slug::make($Vibrator->name);
        $product->price = $Vibrator->price;
        //$product->active = $Vibrator->disabled?0:1;
        $product->active = 1;
        $product->type_product_id = 1;
        $product->line_product_id = $arrVibratorsType["id"];
        //$product->producer_id = 1;
        $product->storage = true;
        $product->guarantee = '12 месяцев';
        $product->old_id = $Vibrator->id;
        //$product->category_id = 1;
        $product->qty  = $Vibrator->onstock;
        $product->figureid = $Vibrator->figureid;
        $product->typeid = $Vibrator->typeid;
        $product->dima = $Vibrator->dima;
        $product->dimb = $Vibrator->dimb;
        $product->dimc = $Vibrator->dimc;
        $product->dimd = $Vibrator->dimd;
        $product->dime = $Vibrator->dime;
        $product->dimf = $Vibrator->dimf;
        $product->dimg = $Vibrator->dimg;
        $product->dimh = $Vibrator->dimh;
        $product->dimi = $Vibrator->dimi;
        $product->diml = $Vibrator->diml;
        $product->dimm = $Vibrator->dimm;
        $product->dimn = $Vibrator->dimn;
        $product->save();

        $group = DB::table('groups')->where('title','Механические свойства')->first();
        $groupId = $group->id;

        $val = $Vibrator->workmoment;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Рабочий момент')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." кгсм";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $Vibrator->fc;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Вынуждающая сила')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $expr = (int)$val/100;
          $attributeProduct->value = $expr." кН";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $Vibrator->weight;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Вес')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." кг";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $Vibrator->size;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Размер')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val;
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $group = DB::table('groups')->where('title','Электрические свойства')->first();
        $groupId = $group->id;

        $val = $Vibrator->powerkw;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Мощность')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." кВт";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $Vibrator->current;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Максимальный ток')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." А";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $Vibrator->iain;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Ia/In')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val;
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $Vibrator->temperatureid;
        if($val) {
          if($val == 1) { $val = 100; }
          if($val == 2) { $val = 135; }
          if($val == 3) { $val = 150; }
          $attribute = DB::table('attributes')->where('title','Температура')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val;
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $groupName = "SKF подшипник: ".$Vibrator->scf;
        if($groupName) {
          $group = DB::table('groups')->where('title',$groupName)->first();
          if(!$group) {
            $group = new Group;
            $group->title = $groupName;
            $group->save();
          }
          $groupId = $group->id;
          $val = $Vibrator->life100;
          if($val) {
            $attribute = DB::table('attributes')->where('title','100% нагрузка')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val." часов.";
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }
          $val = $Vibrator->life80;
          if($val) {
            $attribute = DB::table('attributes')->where('title','80% нагрузка')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val." часов.";
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }
          $val = $Vibrator->life50;
          if($val) {
            $attribute = DB::table('attributes')->where('title','50% нагрузка')->first();
            $attributeProduct = new AttributeProduct;
            $attributeProduct->product_id = $product->id;
            $attributeProduct->attribute_id = $attribute->id;
            $attributeProduct->value = $val." часов.";
            $attributeProduct->group_id = $groupId;
            $attributeProduct->save();
          }
        }

      }
    }

    //=============================Глубинные вибраторы=====================================================
    $concreteVibratorTypes = ConcreteVibratorType::All();
    $arrConcreteVibratorTypes = [];
    foreach ($concreteVibratorTypes as $concreteVibratorType) {
      $result = $lineProduct->where('title',$concreteVibratorType->name)->first();
      $item["old_id"] = $concreteVibratorType->id;
      $item["name"] = $concreteVibratorType->name;
      $item['id'] = $result->id;
      $arrConcreteVibratorTypes[] = $item;
    }

    $concreteVibrator = new ConcreteVibrator;
    foreach ($arrConcreteVibratorTypes as $arrConcreteVibratorType) {
      $concreteVibrators = $concreteVibrator->where('typeid',$arrConcreteVibratorType["old_id"])->get();
      foreach ($concreteVibrators as $concreteVibrator) {
        $product = new Product;
        $product->title = $concreteVibrator->name;
        $product->url_key = \Slug::make($concreteVibrator->name);
        $product->price = $concreteVibrator->price;
        $product->active = $concreteVibrator->disabled?0:1;
        $product->type_product_id = 4;
        $product->line_product_id = $arrConcreteVibratorType["id"];
        //$product->producer_id = 1;
        $product->storage = true;
        $product->guarantee = '12 месяцев';
        $product->old_id = $concreteVibrator->id;
        //$product->category_id = 1;
        $product->qty = $concreteVibrator->onstock;
        $product->typeid = $concreteVibrator->typeid;
        $product->save();

        $group = DB::table('groups')->where('title','Характеристики')->first();
        $groupId = $group->id;

        $val = $concreteVibrator->vibrations;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Частота вибрации')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." Гц";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $concreteVibrator->amplitude;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Амплитуда')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val;
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $concreteVibrator->action;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Действие')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." см";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $concreteVibrator->power;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Производительность')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." м3/час.";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $concreteVibrator->centrifugal;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Центробежная сила')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." kH.";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $group = DB::table('groups')->where('title','Вал')->first();
        $groupId = $group->id;

        $val = $concreteVibrator->shaftlength;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Длина вала')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." м.";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $concreteVibrator->shaftweight;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Вес вала')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." кг.";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $group = DB::table('groups')->where('title','Игла (наконечник)')->first();
        $groupId = $group->id;

        $val = $concreteVibrator->needle;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Диаметр иглы')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." мм.";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $concreteVibrator->needlelength;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Длина иглы')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." мм.";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $val = $concreteVibrator->needleweight;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Вес иглы')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." кг.";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

        $group = DB::table('groups')->where('title','Механические свойства')->first();
        $groupId = $group->id;

        $val = $concreteVibrator->weight;
        if($val) {
          $attribute = DB::table('attributes')->where('title','Вес')->first();
          $attributeProduct = new AttributeProduct;
          $attributeProduct->product_id = $product->id;
          $attributeProduct->attribute_id = $attribute->id;
          $attributeProduct->value = $val." кг.";
          $attributeProduct->group_id = $groupId;
          $attributeProduct->save();
        }

      }
    }

    return "Успешно выполнилось";
  }
}