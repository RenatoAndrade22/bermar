@extends('layouts.layout')

@section('content')

<!--/banner-bottom -->
<section class="banner-bottom py-5">
        <div class="container py-5">
            <h3 class="title-wthree mb-lg-5 mb-4 text-center">{{ $category_name }}</h3>
        
            <!--/row-->
            <div class="row shop-wthree-info text-center">
                <div class="col-xl-2 categories" style="background: #efeeee;">
                    <br>
                    <h3>Categorias</h3>
                    <br>
                    <div class='menu'>
                        @foreach ($categories as $category)
                            <a href="{{ url('categoria/'.$category['slug']) }}"><p>{{ $category['name'] }}</p></a>
                        @endforeach
                    </div>             
                </div>
                <div class="col-xl-10">
                    <div class="row">
                        
                        @foreach ($products as $product)
                            <div class="col-lg-3 shop-info-grid text-center mt-4">
                                <div class="product-shoe-info shoe">
                                    <div class="men-thumb-item">
                                        <a href="{{ url('produto/'.$product['slug']) }}">
                                            <img src="{{ asset('products-images/'.$product['productImages'][0]['name']) }}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="item-info-product">
                                        <h4>
                                            <a href="{{ url('produto/'.$product['slug']) }}">{{ $product['name'] }}</a>
                                        </h4>
                                        <div class="product_price">
                                            <div class="grid-price">
                                                <span class="money">{{ $product['price'] }}</span>
                                            </div>
                                        </div>
                                       
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
                    <h3>CONTE COM NOSSA ASSIST??NCIA</h3>
                    <p></p>
                </div>

            </div>
        </div>

    </section>
    <!--//shipping-->

@endsection