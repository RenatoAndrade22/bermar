<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bermar Insdústria e Comércio</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <!-- //Meta tag Keywords -->
    <!-- Custom-Files -->
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap.css') }}">
    <!-- Bootstrap-Core-CSS -->
    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}" type="text/css" media="all" />
    <!-- Style-CSS -->
    <!-- font-awesome-icons -->
    <link href="{{ asset('site/css/font-awesome.css') }}" rel="stylesheet">
    <!-- //font-awesome-icons -->
    <!-- /Fonts -->
    <link href="//fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">

</head>

<body>
    @if(!Request::is('/'))
        <style>
            @media (max-width: 1366px){
                .main-sec {
                    background:none;
                    min-height: 8em;
                    position: relative;
                }
            }
        </style>
    @endif

    <div class="social-ficons">
        <div class='container'>
            <ul>
                <li><p><span class="fa fa-phone"></span> (17) 3214-9600</p></li>
                <a href="/login" id="entrar"><li><p><span class="fa fa-user"></span> Entrar</p></li></a>
            </ul>
        
        
        </div>
        <!--
        <ul>
            <li><a href="https://pt-br.facebook.com/BM.BERMAR/"><span class="fa fa-facebook"></span> Facebook</a></li>
            <li><a href="https://www.instagram.com/bermarindustria/"><span class="fa fa-instagram"></span> Instagram</a></li>
            <img src="{{ asset('site/images/flag-spain.png') }}" width="24" height="24" text-align="center">
            <img src="{{ asset('site/images/flag-usa.png') }}" width="24" height="24" text-align="center">
            <img src="{{ asset('site/images/flag-pt-br.png') }}" width="24" height="24" text-align="center">
        </ul>
        -->
    </div>

    <div class="main-sec">
        <!-- //header -->
        <header class="py-sm-3 pt-3 pb-2" id="home">
            <div class="container">
                
                <div class="d-flex">
                    <div id="logo">
                        <a href="{{ asset('/') }}"><img src="{{ asset('site/images/logo.png') }}" alt="Bermar" width="173" heigth="81">
                    </div>
<!-- nav 
                    <div class="forms ml-auto">
                        <a href="/login" class="btn"><span class="fa fa-user-circle-o"></span> ENTRAR </a>
{{--                        <a href="shop.html" class="btn shop">COMPRE ONLINE<i class="fa fa-shopping-cart" aria-hidden="true"></i></a>--}}
                    </div>
                    -->
                
                
                <div class="nav-top-wthree">
                    <nav>
                        <!--
                        <label for="drop" class="toggle"><span class="fa fa-bars"></span></label>
                        <input type="checkbox" id="drop" />
        -->
                        <ul class="menu">
                            <li class="{{ (request()-> is('/')) ? 'active' : '' }}"><a href="{{ url('/') }}">Início</a></li>
                            <li class="{{ (request()-> is('empresa')) ? 'active' : '' }}"><a href="{{ url('empresa') }}">Empresa</a></li>
                            <li class="{{ (request()-> is('produtos')) ? 'active' : '' }}"><a href="{{ url('produtos') }}" class="drop-text">Produtos</a></li>
{{--                            <li style="position: relative;">--}}
{{--                                <!-- First Tier Drop Down -->--}}
{{--                                <label for="drop-2" class="toggle">Produtos <span class="fa fa-angle-down" aria-hidden="true"></span>--}}
{{--                                </label>--}}
{{--                                <a href="#">Produtos <span class="fa fa-angle-down" aria-hidden="true"></span></a>--}}
{{--                                <input type="checkbox" id="drop-2" />--}}
{{--                                <ul style="left: 0;">--}}
{{--                                @foreach ($categories as $category)--}}
{{--                                    <li><a href="{{ url('categoria/'.$category['slug']) }}" class="drop-text">{{ $category['name'] }}</a></li>--}}
{{--                                    <hr>--}}
{{--                                @endforeach--}}

{{--                                </ul>--}}
{{--                            </li>--}}

                            <li class="{{ (request()-> is('representantes')) ? 'active' : '' }}"><a href="{{ url('representantes') }}">Representantes</a></li>
                            <li class="{{ (request()-> is('assistencia')) ? 'active' : '' }}"><a href="{{ url('assistencia') }}">Assistência</a></li>
                            <li class="{{ (request()-> is('revendas')) ? 'active' : '' }}"><a href="{{ url('revendas') }}">Revendas</a></li>
                            <li class="{{ (request()-> is('exportacao')) ? 'active' : '' }}"><a href="{{ url('exportacao') }}">exportação</a></li>
                            <li class="{{ (request()-> is('contato')) ? 'active' : '' }}"><a href="{{ url('contato') }}">Contato</a></li>
                        </ul>
                    </nav>
                    <!-- //nav -->
                    <!-- 
                    <div class="search-form ml-auto">
                        <div class="form-w3layouts-grid">

                            <form action="#" method="post" class="newsletter">
                                <input class="search" type="search" placeholder="O que está procurando?" required="">
                                <button class="form-control btn" value=""><span class="fa fa-search"></span></button>
                            </form>
                        </div>
                    </div>
                     -->
                    <div class="clearfix"></div>
             
            </div>
        </header>
        <!-- //header -->

        @if(Request::is('/'))
        <!--/banner-->
        <div>
           <div class="banner">
            <div class="slider">
                <div class="slide">
                  <h3 class="slide-title">Soluções de Alta tecnologia<br>para sua empresa</h3>
                  <p class="slide-desc"></p>
                </div>
                <div class="slide">
                  <h2 class="slide-title">Produzindo Qualidade<br>e associando a beleza</h2>
                  <p class="slide-desc"></p>
                </div>
                <div class="slide">
                  <h2 class="slide-title">Produtos Certificados<br>Internacionalmente</h2>
                  <p class="slide-desc"></p>
                </div>
                <button class="arrow prev"><</button>
                <button class="arrow next">></button>
                  <ul class="slide-nav"></ul>
               </div>
           </div>
        </div>
        <style>

        </style>
        @endif
    </div>


    @yield('content')


   <!-- footer -->

    <div class="cpy-right" style="float: left; width:100%;display: inline;">
        <div class="container py-md-5">
            <div class="row">
                <div class="col-lg-3 footer_wthree_gridf mt-lg-5">
                    <h2><a href="http://lgpd.consultoriacgs.com.br/"><span>LGPD</span>
                        </a> </h2>
                    <label class="sub-des2">Saiba mais</label>
                </div>
                <div class="col-lg-3 footer_wthree_gridf mt-md-0 mt-4">
                    <ul class="footer_wthree_gridf_list">
                        <p><h4>INSTITUCIONAL</h4></p>
                        <li>
                            <a href="{{ url('representantes') }}"><span class="fa fa-angle-right" aria-hidden="true"></span> Representantes</a>
                        </li>
                        <li>
                            <a href="{{ url('revendas') }}"><span class="fa fa-angle-right" aria-hidden="true"></span> Revendas</a>
                        </li>
                        <!-- <li>
                            <a href="garantia.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Termos de Garantia</a>
                        </li> -->
                    </ul>
                </div>
                <div class="col-lg-3 footer_wthree_gridf mt-md-0 mt-sm-4 mt-3">
                    <ul class="footer_wthree_gridf_list">
                        <p><h4>VEJA TAMBÉM</h4></p>
                        <!-- <li>
                            <a href="boleto.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Solicitar Boleto</a>
                        </li> -->

                        <li>
                            <a href="{{ url('assistencia') }}"><span class="fa fa-angle-right" aria-hidden="true"></span> Assistência Técnica</a>
                        </li>
                        <li>
                            <a href="{{ url('produtos') }}"><span class="fa fa-angle-right" aria-hidden="true"></span> Produtos</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 footer_wthree_gridf mt-md-0 mt-sm-4 mt-3">
                    <ul class="footer_wthree_gridf_list">
                        <h4>CONTATO</h4>
                        <li>
                            <a><span class="fa fa-phone" aria-hidden="true"></span><span style="color:#ffffff;">+55 (17) 3214-9600</span></a>
                        </li>

                        <li>
                            <a><span class="fa fa-envelope" aria-hidden="true"></span><span style="color:#ffffff;">bermar@bermar.ind.br</span></a>
                        </li>

                        <li>
                            <a><span class="fa fa-map-marker" aria-hidden="true"></span><span style="color:#ffffff;">CEP: 15035-620</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="cpy-right text-center py-3" style="float: left; width:100%;">
        <p style="color:#ffffff;">© 2022 BERMAR. Todos os direitos reservados| Desenvolvido por
            <a style="color:#ffffff;" href="https://consultoriacgs.com.br/"> CGS</a>
        </p>
    </div>



    <!-- //footer -->
    <!-- copyright -->

    <!-- //copyright -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script><script  src="./script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'></script>
    <script>
        $("#cep").inputmask({"mask": "99999-999"});
    </script>

    <script src="{{ asset('site/script.js') }}" defer></script>
    <script src="{{ asset('site/js/banner.js') }}" defer></script>


</body>

</html>
