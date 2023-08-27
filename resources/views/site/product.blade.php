@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('site/slide-product/style.css') }}">

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
  <script  src="{{ asset('site/slide-product/script.js') }}"></script>
  
    <!--/banner-bottom -->
    <section class="banner-bottom py-5">
        <div class="container">
            <p style="    padding: 0;margin: 0;margin-top: -37px;margin-bottom: 16px;margin-left: 18px;"><a href="{{ url('/') }}">Home</a> - <a href="{{ url('produtos') }}">Produtos</a> - {{ $product['name'] }}</p>
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
                                            <div class="image" style="background-image: url({{ asset($product['productImages'][0]['url']) }})"></div>
                                        @endif

                                      </div>
                                      <div class="row product-thumbnails">
                                        @foreach ($product['productImages'] as $image)
                                            <img src="{{ asset($image['url']) }}" alt="" class="img-thumbnail col-md-3" />
                                        @endforeach
                                      </div>
                                        
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          @if($product['manual'])
                            <button type="button" style="margin: 25px 10px;" onclick="openManual('{{$product['manual']}}')" class="btn btn-danger">Manual</button>
                          @endif

                            
                          <button type="button" style="margin: 25px 10px;" class="btn btn-danger" id="open-modal-text">Ficha Técnica</button>
                        
                        @if ($product['video'])
                          <button type="button" style="margin: 25px 10px;" class="btn btn-danger" id="open-modal">Assista o vídeo do produto</button>
                        @endif
                            <div class="modal-background" id="modal-background">
                                <div class="modal">
                                    <div>
                                        <button id="close-modal" type="button" class="btn btn-light mb-3">Fechar</button>
                                    </div>
                                    <iframe width="700" height="400" src="{{ $product['video'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>

                            <div class="modal-background-text" id="modal-background-text">
                                <div class="modal-text">
                                    <div>
                                        <button id="close-modal-text" type="button" class="btn btn-light mb-3">Fechar</button>
                                    </div>
                                    <div class="text">
                                        <p>{!! nl2br($product['datasheet']) !!}</p>
                                        
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
                                   
                                <button type="button" onclick="btnlinks()" class="btn submit mb-4">Comprar</button>
                                
                                <p style="color: #000;">* Preço, venda e a entrega é de responsabilidade da Revenda.</p>
                                
                                </form>

                                <div class="links mt-4">
                                    <h6>Links para compra</h6>

                                    @foreach ($links as $key => $link)
                                       <h4 style=margin-bottom: 0;margin-top: 18px;>{{ $key }} </h4>
                                       @foreach ($link as $l)
                                        <div style="margin-bottom: 0; margin-bottom: 0;border-bottom: 2px solid #9999;padding: 10px 0px;">
                                            <p style="margin-bottom: 0;">{{ $l['enterprise']['name'] }} | {{ $l['enterprise']['phone'] }} <br /> {{ $l['enterprise']['address'][0]['city']}} - {{ $l['enterprise']['address'][0]['state']}} </p>
                                            <button style="margin: 8px 8px 8px 0px;background: forestgreen;" type="button" onclick="openManual('{{$l['link']}}')" class="btn submit">Loja Virtual</button>
                                        </div>
                                       @endforeach

                                    @endforeach

                                   

                                    @if(count($product['links']) == 0)
                                        <p><a href="/revendas">Clique aqui para buscar a revenda mais próxima</a></p>
                                    @endif
                                </div>
                                
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
        
                
                @if(count($products_related) > 0)
                <!--/row-->
                <h4 style="margin-bottom: 0;margin-left: 15px;border-top: 1px solid #ddd;padding-top: 39px;font-weight: 900;">CONHEÇA TAMBÉM</h4>
                <div class="row shop-wthree-info text-center">
                    
                        @foreach ($products_related as $related)

                            <div class="col-md-3 shop-info-grid text-center mt-4">
                                <div class="product-shoe-info shoe">
                                    <div class="men-thumb-item">
                                        @if(count($related['productImages']))
                                        <a href="{{ url('produto/'.$related['slug']) }}">
                                            <img src="{{ asset($related['productImages'][0]['url']) }}" class="img-fluid" alt="">
                                        </a>
                                        @endif
                                    </div>
                                    <div class="item-info-product">
                                        <h4>
                                            <a href="{{ url('produto/'.$related['slug']) }}">{{ $related['name'] }}</a>
                                        </h4>
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

        function openManual(url){
            window.open(url, '_blank').focus()
        }

        const openModalButton = document.getElementById("open-modal");
        const closeModalButton = document.getElementById("close-modal");
        const modalBackground = document.getElementById("modal-background");

        openModalButton.addEventListener("click", function() {
            modalBackground.style.display = "block";
        });

        closeModalButton.addEventListener("click", function() {
            modalBackground.style.display = "none";
        });







        const openModalButtonText = document.getElementById("open-modal-text");
        const closeModalButtonText = document.getElementById("close-modal-text");
        const modalBackgroundText = document.getElementById("modal-background-text");

        openModalButtonText.addEventListener("click", function() {
            modalBackgroundText.style.display = "block";
        });

        closeModalButtonText.addEventListener("click", function() {
            modalBackgroundText.style.display = "none";
        });

        
    </script>
    <style>
        .product{
            margin-top: -24px;
        }
        .ql-align-justify{
            margin-bottom: 0px;
            line-height: inherit !important;
        }
        .links{
            display: none;
        }
        .modal-background {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal {
            text-align: center;
            top: 61%;
            display: block !important;
            position: fixed;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border-radius: 5px;
            z-index: 2;
        }

        .modal h2 {
            margin-top: 0;
        }

        .modal p {
            margin-bottom: 20px;
        }

        .modal-background-text {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-text {
            text-align: center;
            top: 52%;
            display: block !important;
            position: fixed;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border-radius: 5px;
            z-index: 2;
        }

        .modal-text h2 {
            margin-top: 0;
        }

        .modal-text .text {
            margin-bottom: 20px;
            background: #fff;
            overflow: auto;
            padding: 35px;
            height: 350px;
        }


    </style>
    <!-- /banner-bottom -->
    <!--/newsletter -->
    
    <!--//newsletter -->
    <!--/shipping-->

    <!--//shipping-->
    @endsection
    