@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('site/slide-product/style.css') }}">

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
  <script  src="{{ asset('site/slide-product/script.js') }}"></script>
  
  
    <!--/banner-bottom -->
    <section class="banner-bottom py-5">
        <div class="container">
            <!-- product right -->
            <div class="left-ads-display wthree">
                <div class="row">
                    <div class="desc1-left col-md-6">
                        <div class="wrapper">
                            <div class="container">
                              <div class="row">
                                <div class="col-md-12 product">
                                  <div class="row">
                                    <div class="col-md-7">
                                      <div class="product-image">

                                        @if(count($product['productImages']) > 0)
                                            <div class="image" style="background-image: url({{ asset('products-images/'.$product['productImages'][0]['name']) }})"></div>
                                        @endif

                                      </div>
                                      <div class="row product-thumbnails">
                                        @foreach ($product['productImages'] as $image)
                                            <img src="{{ asset('products-images/'.$image['name']) }}" alt="" class="img-thumbnail col-md-3" />
                                        @endforeach
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="desc1-right col-md-6 pl-lg-3">
                        <h2>{{ $product['name'] }}</h2>

                        {!! nl2br($product['description'])!!}
                        <!-- <p><a href="220v.html"><span class="fa fa-bolt" aria-hidden="true"></span> TENSÃO 220 V</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="220v.html"><span class="fa fa-cogs" aria-hidden="true"></span> 1/2 HP 760 w</a></p> -->
                        
                        <!--
                        <br>

                        <h5>R$ {{ $product['price'] }} <span></span> <a href="#"></a></h5>
                        
                        <div class="available mt-3">
                            <p>Informe o CEP para calcular o frete:</p>
                            <div class="content-input-field">
                                <input id="cep" type="text" style="width: 170px;float: left;" />
                                <button class="btn submit" style="width: 200px;margin-left: 10px;margin-top: -3px; border-radius: 0.25rem !important;">Calcular frete</button>
                            </div>
                            <form action="#" method="post" class="w3pvt-newsletter subscribe-sec" style="width: 100%;float: left;margin-bottom: 30px;">
                            </form>
                        </div>
                        -->
                        <div class="share-desc mt-5">
                            <div class="available mt-3">
                                <form action="#" method="post" class="w3pvt-newsletter subscribe-sec">
                                   
                                    <button type="button" onclick="btnlinks()" class="btn submit">Comprar</button>
        
                                </form>

                                <div class="links mt-4">
                                    <h6>Links para compra</h6>
                                    @foreach ($product['links'] as $link)
                                    <p style="color: cornflowerblue;"><a target=”_blank” href="{{ $link['link'] }}" >{{ mb_strimwidth($link['link'], 0, 35, "...") }}</a></p>
                                    @endforeach
                                </div>
                                
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    

                </div>
                <div class="container py-md-5">
                    <!-- product right -->
                    <div class="left-ads-display wthree">
                        @if ($product['video'])
                            <iframe width="1120" height="630" src="{{ $product['video'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @endif
                        <div class="row">
                            <div class="desc1-left col-md-6 mt-3">
                                {!! nl2br($product['datasheet']) !!}
                            </div>
                            <div class="desc1-right col-md-6 pl-lg-3">
                                
                                
                                <div class="share-desc mt-5">
                                    <div class="share text-left">
                                       
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                
                @if(count($products_related) > 0)
                <!--/row-->
                <h3 class="title-wthree-single my-lg-5 my-4 text-left">CONHEÇA TAMBÉM</h3>
                <div class="row shop-wthree-info text-center">
                    
                        @foreach ($products_related as $related)

                            <div class="col-md-3 shop-info-grid text-center mt-4">
                                <div class="product-shoe-info shoe">
                                    <div class="men-thumb-item">
                                        @if(count($related['productImages']))
                                        <a href="{{ url('produto/'.$related['slug']) }}">
                                            <img src="{{ asset('products-images/'.$related['productImages'][0]['name']) }}" class="img-fluid" alt="">
                                        </a>
                                        @endif
                                    </div>
                                    <div class="item-info-product">
                                        <h4>
                                            <a href="{{ url('produto/'.$related['slug']) }}">{{ $related['name'] }}</a>
                                        </h4>

                                        <div class="product_price">
                                            <div class="grid-price">
                                                <span class="money"><span class="line"></span>R$ {{ $related['price'] }}</span>
                                            </div>
                                        </div>
                                        
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    
                </div>
                <!--//row-->
                @endif
            </div>
        </div>
    </section>
    <script>
        function btnlinks(){
            $('.links').show()
        }
        
    </script>
    <style>
        .links{
            display: none;
        }
    </style>
    <!-- /banner-bottom -->
    <!--/newsletter -->
    
    <!--//newsletter -->
    <!--/shipping-->

    <!--//shipping-->
    @endsection
    