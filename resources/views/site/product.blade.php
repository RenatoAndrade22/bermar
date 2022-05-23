@extends('layouts.layout')

@section('content')

    <!--/banner-bottom -->
    <section class="banner-bottom py-5">
        <div class="container py-md-5">
            <!-- product right -->
            <div class="left-ads-display wthree">
                <div class="row">
                    <div class="desc1-left col-md-6">
                        <img src="images/BM-115-CINZA.jpg" class="img-fluid" alt="">
                
                    </div>
                    <div class="desc1-right col-md-6 pl-lg-3">
                        <h2>{{ $product['name'] }}</h2>
                        <h3>{{ $product['description'] }}</h3>
                        <!-- <p><a href="220v.html"><span class="fa fa-bolt" aria-hidden="true"></span> TENSÃO 220 V</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="220v.html"><span class="fa fa-cogs" aria-hidden="true"></span> 1/2 HP 760 w</a></p> -->
                        <br>

                        <h5>R$ {{ $product['price'] }} <span></span> <a href="#"></a></h5>
                        <div class="available mt-3">
                            <form action="#" method="post" class="w3pvt-newsletter subscribe-sec">
                               
                                <button class="btn submit">COMPRAR</button>&nbsp;&nbsp;<button class="btn submit">LOJA FÍSICA</button>

                            </form>
                            <span><a href="#">Adicionar a Lista de Dejesos</a></span>
                            <p>Com um motor de 1/2 Hp 760w com 60Hz tem um consumo de 0,76 kw/h. Sendo alimentado na voltagem: 127 / 220 V Monofásico com chave seletora possui capacidade de produção de até 400 kg/h.<br>
                            </p><br><br>
                            <p>Informe o CEP para calcular o frete:</p>
                            <div class="content-input-field">
                                <input name="text1" id="text1" type="email" value="" placeholder="CEP" required="">
                            </div>
                        </div>
                        <div class="share-desc mt-5">
                            <div class="share text-left">
                                <h4>COMPARTILHAR PRODUTO:</h4>
                                <div class="social-ficons mt-4">
                                    <ul>
                                        <li><a href="https://pt-br.facebook.com/"><span class="fa fa-facebook"></span> Facebook</a></li>
                                        <li><a href="https://www.instagram.com/"><span class="fa fa-instagram"></span> Instagram</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="available mt-3">
                                <form action="#" method="post" class="w3pvt-newsletter subscribe-sec">
                                   
                                    <button class="btn submit">DOWNLOAD MANUAL</button>
        
                                </form>
                                
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    

                </div>
                <div class="container py-md-5">
                    <!-- product right -->
                    <div class="left-ads-display wthree">
                        <iframe width="1120" height="630" src="https://www.youtube.com/embed/JKOCZlCfiuk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="row">
                            <div class="desc1-left col-md-6">
                                <br>
                                <p>
                                <h4>Característifcas Técnicas:</h4>
                                - motor de 1/2 HP 760 w - 60 Hz *consumo: 0,76 kw/h
                                <br>
                                - voltagem: 127/220V * monofásico
                                <br>
                                - com chave seletora
                                <br>
                                - com dispositivos de segurança Nr12
                                <br>
                                - estrutura totalmente em aço inox
                                <br>
                                - engrenagens em carter de óleo 
                                <br>
                                <h5>Dimensões da Máquina:</h5>
                                - comprimento: 480mm * largura: 230mm
                                <br>
                                - altura: 500mm * peso líq: 25,5 Kg
                                <br> 
                                <h5>Dimensões da embalgem:</h5>
                                - profundidade: 600mm * altura: 420mm
                                <br>
                                - largura: 340mm * peso bruto: 31 Kg
                                <br> 
                                - cubagem: 0,07 m3 
                                <br>
                                <h5>Utilidade:</h5>
                                - amaciar carnes                                    
                            </p>
                            </div>
                            <div class="desc1-right col-md-6 pl-lg-3">
                                
                                
                                <div class="share-desc mt-5">
                                    <div class="share text-left">
                                       
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
        
                

                <!--/row-->
                <h3 class="title-wthree-single my-lg-5 my-4 text-left">CONHEÇA TAMBÉM</h3>
                <div class="row shop-wthree-info text-center">
                    <div class="col-md-3 shop-info-grid text-center mt-4">
                        <div class="product-shoe-info shoe">
                            <div class="men-thumb-item">
                                <img src="images/b1.jpg" class="img-fluid" alt="">

                            </div>
                            <div class="item-info-product">
                                <h4>
                                    <a href="bm33nr.html">Serra Fita de Coluna 2,20M </a>
                                </h4>

                                <div class="product_price">
                                    <div class="grid-price">
                                        <span class="money"><span class="line"></span>R$ 9999</span>
                                    </div>
                                </div>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 shop-info-grid text-center mt-4">
                        <div class="product-shoe-info shoe">
                            <div class="men-thumb-item">
                                <img src="images/b2.jpg" class="img-fluid" alt="">

                            </div>
                            <div class="item-info-product">
                                <h4>
                                    <a href="bm118nr.html">Extrator de Suco 1/2 HP</a>
                                </h4>

                                <div class="product_price">
                                    <div class="grid-price">
                                        <span class="money"><span class="line"></span>R$ 9999</span>
                                    </div>
                                </div>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 shop-info-grid text-center mt-4">
                        <div class="product-shoe-info shoe">
                            <div class="men-thumb-item">
                                <img src="images/BM-71-72-FUNDO-CINZA.jpg" class="img-fluid" alt="">

                            </div>
                            <div class="item-info-product">
                                <h4>
                                    <a href="bm71nr127v.html">Batedor de Milk Shake</a>
                                </h4>

                                <div class="product_price">
                                    <div class="grid-price">
                                        <span class="money"><span class="line"></span>R$ 9999</span>
                                    </div>
                                </div>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 shop-info-grid text-center mt-4">
                        <div class="product-shoe-info shoe">
                            <div class="men-thumb-item">
                                <img src="images/BM-127-128-FUNDO-CINZA.jpg" class="img-fluid" alt="">

                            </div>
                            <div class="item-info-product">
                                <h4>
                                    <a href="bm128.html">Despolpadeira de 20 litros</a>
                                </h4>

                                <div class="product_price">
                                    <div class="grid-price">
                                        <span class="money"><span class="line"></span>R$ 9999</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
                <!--//row-->

            </div>
        </div>
    </section>
    <!-- /banner-bottom -->
    <!--/newsletter -->
    
    <!--//newsletter -->
    <!--/shipping-->

    <!--//shipping-->
    @endsection