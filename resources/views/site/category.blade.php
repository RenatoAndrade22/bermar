@extends('layouts.layout')

@section('content')

<!--/banner-bottom -->
<section>
        <div class="container py-5">

        @if(isset($category_name))
            <h3 class="title-wthree mb-lg-5 mb-4 text-center">{{ $category_name }}</h3>
        @endif
            <!--/row-->
            <div class="row shop-wthree-info text-center">
                <div class="col-xl-2 categories">
          
                    <div class='menu'>
                        <p style="font-weight: 600;">Categorias</p>
                        @foreach ($categories as $category)
                            <a href="{{ url('categoria/'.$category['slug']) }}"><p>{{ $category['name'] }}</p></a>
                        @endforeach
                    </div>             
                </div>
                <div class="col-xl-10">
                    <div class="row" style="    margin-top: -27px;">
                        
                        @foreach ($products as $product)
                            <div class="col-lg-3 shop-info-grid text-center mb-4">
                                <div class="product-shoe-info shoe">
                                    <div class="men-thumb-item">
                                        @if(count($product['productImages']))
                                        <a href="{{ url('produto/'.$product['slug']) }}">
                                            <img src="{{ asset($product['productImages'][0]['url']) }}" class="img_product img-fluid" alt="">
                                        </a>
                                        @endif
                                    </div>
                                    <div class="item-info-product">
                                        <h4>
                                            <a href="{{ url('produto/'.$product['slug']) }}">{{ $product['name'] }}</a>
                                        </h4>
                                        <!--
                                        <div class="product_price">
                                            <div class="grid-price">
                                                <span class="money">{{ $product['price'] }}</span>
                                            </div>
                                        </div>
                                        -->
                                       
                                    </div>
                                </div>
                            </div>
        
                        @endforeach

                    </div>
                </div>
            </div>
  
            
        </div>
    </section>
    <!-- /banner-bottom -->
    <!--/newsletter -->
    <!--//newsletter -->
   
    <!--/shipping-->
    <section class="shipping-wthree">
        <div class="shiopping-grids d-lg-flex">
            <div class="col-lg-4 shiopping-w3pvt-gd text-center">
                <div class="icon-gd"><span class="fa fa-truck" aria-hidden="true"></span>
                </div>
                <div class="icon-gd-info">
                    <h3>ENTREGAMOS PARA TODO O BRASIL</h3>
                    <p></p>
                </div>
            </div>
            <div class="col-lg-4 shiopping-w3pvt-gd sec text-center">
                <div class="icon-gd"><span class="fa fa-lock" aria-hidden="true"></span></div>
                <div class="icon-gd-info">
                    <h3>SITE SEGURO</h3>
                    <p></p>
                </div>
            </div>
            <div class="col-lg-4 shiopping-w3pvt-gd text-center">
                <div class="icon-gd"> <span class="fa fa-wrench" aria-hidden="true"></span></div>
                <div class="icon-gd-info">
                    <h3>CONTE COM NOSSA ASSISTÊNCIA</h3>
                    <p></p>
                </div>

            </div>
        </div>

    </section>
    <!--//shipping-->

@endsection