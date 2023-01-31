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
    <section class='container'>
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
                    <a href="{{ $catalog }}" target="_blank" class="btn shop mt-3">DOWNLOAD</a>

                </div>
            </div>
        </div>
    </section>
   
    <!-- //gallery-->


@endsection
