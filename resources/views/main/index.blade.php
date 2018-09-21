@extends('layouts.main')

@section('title', "ПРОМВИБРАТОР.РУ. Площадочные вибраторы, глубинные вибраторы и пневматические вибраторы")

@section('sidebar')
   @foreach($typeProducts as $typeProduct)
      <div class="content-left-menu"><a class="partition" href="/{{$typeProduct->url_key}}/">{{$typeProduct->title}}</a></div>
   @endforeach
   <div class="content-left-menu"></div>
@stop

@section('content')
   <div id="content">
      <ul class="content-right-tab-ul content-right-tab-ul-a">
         @foreach($products as $product)
            <li>
               <div class="tab-li-stiker-hit"></div>
               @if($product->onsale)
                  <div class="tab-li-stiker-sale"></div>
               @endif
               <div class="tab-li-title">
                  <a href="/{{$product->type_product->url_key}}.php?id={{$product->old_id}}">{{$product->title}}</a>
               </div>
               <div class="tab-li-img">
                  <a href="/{{$product->url_key}}">
                     @foreach($product->files as $file)
                        @foreach($file->config as $filesItem)
                           @foreach($filesItem as $key=>$fileItem)
                              @if($key === "medium")
                                 <img src="{{asset('/storage/'.$fileItem["filename"])}}" alt="">
                              @endif
                           @endforeach
                        @endforeach
                     @endforeach
                  </a>
               </div>
               <div class="tab-li-info">
                 <?php $counter=1; ?>
                  @foreach($product->attributes as $attribute)
                     @if($attribute->pivot->value)
                        {{$attribute->title}}: <b> {{$attribute->pivot->value}}</b><br/>
                     <?php $counter++; if($counter>3) break;?>
                     @endif
                  @endforeach
               </div>
               <div class="tab-li-price">
                  @if($product->onsale)
                     {{$product->special_price}} &#8381;
                  @else
                     @if($typeProduct->title == 'Площадочные вибраторы')
                        {{Course::get_price($product->price,Config::get('course.value'))}} &#8381;
                     @else
                        {{Course::get_price($product->price,Config::get('course.value'),true)}} &#8381;
                     @endif
                  @endif
               </div>
               <div class="tab-li-button">
                  <input class="cart-submit" type="submit" value="В корзину" @click.prevent="addCart({{$product->id}})">
                  <input class="cart-col product_qty2" name="Name" id="prod-{{$product->id}}" type="text" value="1">
                  <div class="div-minus" @click.prevent="downQty({{$product->id}})">-</div>
                  <div class="div-plus" @click.prevent="upQty({{$product->id}})">+</div>
               </div>
            </li>
         @endforeach

      </ul>
   </div>
@endsection