@extends('layouts.main')

@section('title', 'ПРОМВИБРАТОР.РУ.'.$typeProduct->title.' cписок.')

@section('sidebar')
    @foreach($typeProduct->line_products as $lineProduct)
        <div class="content-left-menu">
            <a href="/{{$lineProduct->url_key}}" class="partition">{{$lineProduct->title}}</a>
            @foreach($lineProduct->attributes as $attribute)
                @if($attribute->filterable)
                    <a href="{{$attribute->alias}}">
                        {{$attribute->title}}
                        <img src="{{asset('css/images/hover-menu.png')}}" alt="arrow"/>
                    </a>
                @endif
            @endforeach
        </div>
    @endforeach
    <div class="content-left-menu"></div>
    @include('main.sidebar',['articles' => $articles])
@stop

@section('content')
        <div>
            <div id="content">
                <div class="content-right-navtral">
                    @foreach($breadcrumbs as $key => $breadcrumb)
                        @if(!$loop->last)
                            <a href="{{$breadcrumb->slug}}">{{$breadcrumb->title}}</a>
                            <img src="{{asset('/css/images/arrow-right.png')}}" class="img-arrow"/>
                        @else
                            {{$breadcrumb->title}}
                        @endif
                    @endforeach
                </div>
                <br>
                <ul class="content-right-tab-ul content-right-tab-ul-a">
                    @foreach($products as $product)
                        <li>
                            <div class="tab-li-stiker-hit"></div>
                            @if($product->onsale)
                                <div class="tab-li-stiker-sale"></div>
                            @endif
                            <div class="tab-li-title">
                                <a href="/{{$typeProduct->url_key}}.php?id={{$product->old_id}}">{{$product->title}}</a>
                            </div>
                            <div class="tab-li-img">
                                <a href="/{{$product->url_key}}">
                                    @foreach($product->files as $file)
                                        @foreach($file->config as $filesItem)
                                            @foreach($filesItem as $key=>$fileItem)
                                                @if($key === "medium")
                                                    <img src="{{asset('/storage/'.$fileItem["filename"])}}" alt="">
                                                    @break
                                                @endif
                                            @endforeach
                                        @endforeach
                                        @break
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
                                <input class="cart-submit" type="submit" value="В корзину" @click.prevent="addCart({{$product->id}})" >
                                <input class="cart-col product_qty2" name="Name" id="prod-{{$product->id}}" type="text" value="1">
                                <div class="div-minus" @click.prevent="downQty({{$product->id}})">-</div>
                                <div class="div-plus" @click.prevent="upQty({{$product->id}})">+</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="content-links">
            {{ $products->links() }}
        </div>
@stop

@section('view.scripts')
@stop