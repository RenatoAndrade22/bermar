@extends('layouts.layout')

@section('content')

<section class="search">
    <div class="container">
            
        <div class="box-search">
            <input type="text" placeholder="Buscar produto" id="text-search" class="search-text" />
            <input value="Buscar" type="button" class="search-button" onclick="searchProduct()" />                    
        </div>
            
    </div>
</section>

<!--/banner-bottom -->
<section>
        <div class="container py-5">

        @if(isset($category_name))
            <h3 class="title-wthree mb-lg-5 mb-4 text-center">{{ $category_name }}</h3>
        @endif
            <!--/row-->
            <div class="row shop-wthree-info text-center">
                <div class="col-xl-3 categories">
          
                    <div class='menu'>
                        <p style="font-weight: 600; font-size: 16px; text-align:left;">Categorias</p>
                        @foreach ($categories as $category)
                            
                            <a href="{{ url('categoria/'.$category['slug']) }}"><p class="categories">{{ $category['name'] }}</p></a>
                           
                            @foreach ($category['categories'] as $sub_categ)
                                <a href="{{ url('categoria/'.$sub_categ['slug']) }}"><p class="sub_categories">&nbsp&nbsp- {{ $sub_categ['name'] }}</p></a>
                            @endforeach
                           
                        @endforeach
                    </div>             
                </div>
                <div class="col-xl-9">
                    <div class="row" style="    margin-top: -27px;">
                        
                        @if(count($products) == 0)
                            <h4>Nenhum produto encontrado.</h4>
                        @endif

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

    <script>
        function searchProduct(){
            let value = document.getElementById('text-search').value

            if(value){
                location.replace("/busca/produtos/"+value)
            }
        }
    </script>

@endsection