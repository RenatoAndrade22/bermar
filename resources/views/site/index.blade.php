@extends('layouts.layout')

@section('content')

<!--/banner-bottom -->
{{--    <section class="banner-bottom py-5">--}}
{{--        <div class="container py-md-3">--}}
{{--            <div class="row grids-wthree-info text-center">--}}
{{--                <div class="col-lg-4 ab-content">--}}
{{--                    <div class="ab-info-con">--}}
{{--                        <img src="{{ asset('site/images/icone assistencia.png') }}" width="127" height="136">--}}
{{--                        <h3>Assistência Técnica <br> em todo o Brasil</h3><br>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 ab-content">--}}
{{--                    <div class="ab-info-con">--}}
{{--                        <img src="{{ asset('site/images/icone atendimento.png') }}" width="153" height="136">--}}
{{--                        <h3>Atendimento <br> Rápido</h3><br>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 ab-content">--}}
{{--                    <div class="ab-info-con">--}}
{{--                        <img src="{{ asset('site/images/icone transporte.png') }}" width="256" height="136">--}}
{{--                        <h3>Entrega ágil <br> e eficiente</h3><br>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- /banner-bottom -->
    <!--/banner-bottom -->
    <section>
        <div class="row">
            <div class="col-md-8 ab-content text-rigth p-lg-5 p-3 my-lg-5">
                <h4>Conheça nossos produtos</h4>
                <p>A Bermar oferece uma linha completa de produtos para atender as mais diversas demandas, aliando praticidade e modernidade ao seu negócio.
                    A Bermar produz qualidade associada a beleza, e traz inovações para que você produza cada vez  mais.
                    Agora você tem a facilidade de conhecer e comprar nossos produtos de forma rápida e pratica atravez de nosso site.</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('site/images/banner-catalogo.jpg') }}" alt="Baggage" class="img-fluid mt-4">
            </div>
        </div>
    </section>

    <section class="collections">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 ab-content-img">

                </div>
                <div class="col-md-4 ab-content text-center p-lg-5 p-3 my-lg-5">
                    <h4>Catálogo de Produtos</h4>
                    <p>Baixe agora a última versão do catálogo Bermar.</p>
                    <a href="shop.html" class="btn shop mt-3">DOWNLOAD</a>

                </div>
            </div>
        </div>
    </section>
    <!-- /banner-bottom -->
    <!--/collections -->
<!--
    <div class="container">

    <img src="{{ asset('site/images/c1.jpg') }}" width="100%" height="100%" align-content="">

        <div class="row">
          <div class="col">
            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/6xfs4CY5cqY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
          <div class="col">
            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/-hTwpgmEats" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
          <div class="col">
            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/3gPcLlj3TOo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
          </div>


        <br><br>

        <div class="row">
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/7UEa0Z6lUJI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/7UEa0Z6lUJI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/G-DXS7Wbuus" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
            </div>


        <br><br>

        <div class="row">
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/_JixiSTZIlY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/dXFgu-Smh50" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/7AiQysNRg3g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
            </div>


        <br><br>

        <div class="row">
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/JKOCZlCfiuk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>         </div>
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/vIp26dg84sk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
            <div class="col">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/rOAj4wAntcI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>          </div>
            </div>

    </div>


    <section class="banner-bottom py-5">
        <div class="container py-md-5">

        </div>
    </section>


    <section class="mid-section">

    </section>


-->
    <section class="newsletter-w3pvt py-5">
        <div id="categories" class="container py-md-5">
            <div align= "center">
                <h3>Conheça nossas linhas de prosutos!</h3>
            </div>

            <div class="row">
                <div align = "center">
                    <div class="col-lg-12 gallery-content">
                        <div class="row">
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="{{url('categoria/cat1')}}"><img src="{{ asset('site/images/amaciador-de-carne.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Amaciador de Carnes</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="{{url('categoria/cat2')}}"><img src="{{ asset('site/images/despolpadores.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Despolpadores</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/amassadeiras-basculantes.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Amassadeiras Basculantes</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/batedores-de-milk-shake.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Batedores de Milk Shake</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/ensacadeiras.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Ensacadeiras</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/cilindros-para-massas.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Cilindros para Massas</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/cortadores-de-frios.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Cortadores de Frios</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/liquidificadores-e-trituradores.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Liquidificadores e Trituradores</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/despolpadeiras.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Despolpadeiras</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/extratores-de-sucos.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Extratores de Sucos</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/processador-de-alimentos.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Processador de Alimentos</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/masseiras-para-churros.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Masseiras para  Churros</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/misturadeira-de-carne.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Misturadora de Carne</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/moedores.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Moedores</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/raladores.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Raladores</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/picadores-de-carne.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Picadores de Carnes</h5>
                            </div>
                            <div class="col-md-2 col-sm-6 gal-img">
                                <a href="categoria-catalogo.html"><img src="{{ asset('site/images/serras-fita.png') }}" alt="" class="img-fluid mt-4"></a>
                                <h5>Serra Fita</h5>
                            </div>
                        </div>
                    </div>


                    <!-- gallery popups -->

                    <!-- popup-->

                    <!-- //popup -->
                    <!-- popup-->
                    <div id="gal3" class="popup-effect">
                        <div class="popup">
                            <img src="#" alt="Popup image" class="img-fluid mt-4" />
                            <a class="close" href="#gallery">&times;</a>
                        </div>
                    </div>
                    <!-- //popup -->
                    <!-- //gallery popups -->

                </div>
            </div>

        </div>


{{--            <div id="categories"class="row">--}}
{{--                <div class="col-lg-4 gallery-content-info text-center mt-lg-5">--}}
{{--                    <br><br><br><br><br>--}}
{{--                    <h3 class="title-wthree mb-lg-5 mb-4">CONHEÇA<br>NOSSA LINHA<br>DE PRODUTO</h3>--}}

{{--                </div>--}}
{{--                <div class="col-lg-8 gallery-content">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-4 col-sm-6 gal-img">--}}
{{--                            <a href="{{ url('categoria/cat1') }}"><img src="{{ asset('site/images/g1.jpg') }}" alt="Baggage" class="img-fluid mt-4"></a>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-sm-6 gal-img">--}}
{{--                            <a href="{{ url('categoria/cat2') }}"><img src="{{ asset('site/images/g2.jpg') }}" alt="Baggage" class="img-fluid mt-4"></a>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-sm-6 gal-img">--}}
{{--                            <a href="{{ url('categoria/cat3') }}"><img src="{{ asset('site/images/g3.jpg') }}" alt="Baggage" class="img-fluid mt-4"></a>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-sm-6 gal-img">--}}
{{--                            <a href="{{ url('categoria/cat4') }}"><img src="{{ asset('site/images/g4.jpg') }}" alt="Baggage" class="img-fluid mt-4"></a>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-sm-6 gal-img">--}}
{{--                            <a href="{{ url('categoria/cat5') }}"><img src="{{ asset('site/images/g5.jpg') }}" alt="Baggage" class="img-fluid mt-4"></a>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-sm-6 gal-img">--}}
{{--                            <a href="{{ url('categoria/cat6') }}"><img src="{{ asset('site/images/g6.jpg') }}" alt="Baggage" class="img-fluid mt-4"></a>--}}
{{--                        </div>--}}

{{--                    </div>--}}


{{--                    <!-- gallery popups -->--}}
{{--                    <!-- popup-->--}}
{{--                    <div id="gal1" class="popup-effect">--}}
{{--                        <div class="popup">--}}
{{--                            <img src="{{ asset('site/images/g1.jpg') }}" alt="Popup image" class="img-fluid mt-4" />--}}
{{--                            <a class="close" href="#gallery">&times;</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- //popup -->--}}
{{--                    <!-- popup-->--}}
{{--                    <div id="gal2" class="popup-effect">--}}
{{--                        <div class="popup">--}}
{{--                            <img src="{{ asset('site/images/g2.jpg') }}" alt="Popup image" class="img-fluid mt-4" />--}}
{{--                            <a class="close" href="#gallery">&times;</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- //popup -->--}}
{{--                    <!-- popup-->--}}
{{--                    <div id="gal3" class="popup-effect">--}}
{{--                        <div class="popup">--}}
{{--                            <img src="{{ asset('site/images/g3.jpg') }}" alt="Popup image" class="img-fluid mt-4" />--}}
{{--                            <a class="close" href="#gallery">&times;</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- //popup -->--}}
{{--                    <!-- //gallery popups -->--}}

{{--                </div>--}}
{{--            </div>--}}

    </section>
    <!-- //gallery-->


@endsection
