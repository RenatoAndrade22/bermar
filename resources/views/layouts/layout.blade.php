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

    <script src="//code.jivosite.com/widget/BLIuNA7wkE" async></script>
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
    <div class="social-ficons">
        <ul>
            <li><a href="https://pt-br.facebook.com/BM.BERMAR/"><span class="fa fa-facebook"></span> Facebook</a></li>
            <li><a href="https://www.instagram.com/bermarindustria/"><span class="fa fa-instagram"></span> Instagram</a></li>
            <img src="{{ asset('site/images/flag-spain.png') }}" width="24" height="24" text-align="center">
            <img src="{{ asset('site/images/flag-usa.png') }}" width="24" height="24" text-align="center">
            <img src="{{ asset('site/images/flag-pt-br.png') }}" width="24" height="24" text-align="center">
        </ul>
    </div>

    <div class="main-sec">
        <!-- //header -->
        <header class="py-sm-3 pt-3 pb-2" id="home">
            <div class="container">
                <!-- nav -->
                <div class="top-w3pvt d-flex">
                    <div id="logo">
                        <a href="index.html"><img src="{{ asset('site/images/logo.png') }}" alt="Bermar" width="173" heigth="81">

                    </div>


                    <div class="forms ml-auto">
                        <a href="/login" class="btn"><span class="fa fa-user-circle-o"></span> ENTRAR </a>
                        <a href="shop.html" class="btn shop">COMPRE ONLINE<i class="fa fa-shopping-cart" aria-hidden="true"></i></a>              
                    </div>
                </div>
                <div class="nav-top-wthree">
                    <nav>
                        <label for="drop" class="toggle"><span class="fa fa-bars"></span></label>
                        <input type="checkbox" id="drop" />
                        <ul class="menu">
                            <li class="active"><a href="index.html">Início</a></li>
                            <li><a href="about.html">Empresa</a></li>
                            <li style="position: relative;">
                                <!-- First Tier Drop Down -->
                                <label for="drop-2" class="toggle">Produtos <span class="fa fa-angle-down" aria-hidden="true"></span>
                                </label>
                                <a href="#">Produtos <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                <input type="checkbox" id="drop-2" />
                                <ul style="left: 0;">
                                    <li><a href="categoria-catalogo.html" class="drop-text">Amaciador de Carnes</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Despolpadores</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Amassadeiras Basculantes</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Batedores de Milk Shake</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Ensacadeiras</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Cilindros para Massas</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Cortadores de Frios</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Liquidificadores Trituradores</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Despolpadeiras</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Extratores de Sucos</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Processador de Alimentos</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Masseira para Churros</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Misturadeira de Carnes</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Moedores</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Raladores</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Picadores de Carnes</a></li>
                                    <hr>
                                    <li><a href="categoria-catalogo.html" class="drop-text">Serras fita</a></li>
                                       
                                </ul>
                            </li>

                            <li><a href="representantes.html">Representantes</a></li>
                            <li><a href="assistencia.html">Assistência</a></li>
                            <li><a href="contact.html">Contato</a></li>
                        </ul>
                    </nav>
                    <!-- //nav -->
                    <div class="search-form ml-auto">
                        <div class="form-w3layouts-grid">
                            <form action="#" method="post" class="newsletter">
                                <input class="search" type="search" placeholder="O que está procurando?" required="">
                                <button class="form-control btn" value=""><span class="fa fa-search"></span></button>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </header>
        <!-- //header -->
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
    </div>


    @yield('content')
    
    
   <!-- footer -->
    
   <div class="cpy-right">
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
                            <a href="representantes.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Representantes</a>
                        </li>
                        <li>
                            <a href="revendas.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Revendas</a>
                        </li>
                        <li>
                            <a href="garantia.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Termos de Garantia</a>
                        </li>
                        <li>
                            <a href="recrutamento.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Trabalhe Conosco</a>
                        </li>

                    </ul>
                </div>
                <div class="col-lg-3 footer_wthree_gridf mt-md-0 mt-sm-4 mt-3">
                    <ul class="footer_wthree_gridf_list">
                        <p><h4>VEJA TAMBEM</h4></p>
                        <li>
                            <a href="boleto.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Solicitar Boleto</a>
                        </li>

                        <li>
                            <a href="assistencia.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Assistência Técnica</a>
                        </li>
                        <li>
                            <a href="shop.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Produtos</a>
                        </li>
                        <li>
                            <a href="contact.html"><span class="fa fa-angle-right" aria-hidden="true"></span> Contato</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 footer_wthree_gridf mt-md-0 mt-sm-4 mt-3">
                    <ul class="footer_wthree_gridf_list">
                        <h4>CONTATO</h4><br>
						<div class="address">
							<div class="address-grid">
								<div class="address-left">
									<i class="fa fa-phone" aria-hidden="true"> Ligue-nos:</i>
								</div>
								<div class="address-right">
                                  
									<p><h6>+55 (17) 3214-9600</h6></p>
								</div>
								<div class="clearfix"> </div>
							</div>
                            
                            <br>

							<div class="address-grid">
								<div class="address-left">
									<i class="fa fa-envelope" aria-hidden="true"> Nos mande um e-mail:</i>
								</div>
								<div class="address-right">
								
									<p><h6><a href="mailto:example@email.com">bermar@bermar.ind.br</a></h6></p>
								</div>
								<div class="clearfix"> </div>
							</div>

                            <br>

							<div class="address-grid">
                                <div class="address-left">
  
									<i class="fa fa-map-marker" aria-hidden="true"> Onde estamos:</i>
                                    								
									</p>
								</div>
								<div class="address-right">
								
									<p><h6>R. Francisco Curti, 245 - Distrito Industrial, São José do Rio Preto - SP, 15035-620</h6>

									</p>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
                    </ul>
                </div>
            </div>

        </div>
        </div>
        <div class="cpy-right text-center py-3">
            <p>© 2022 BERMAR. Todos os direitos reservados| Desenvolvido por
                <a href="https://consultoriacgs.com.br/"> CGS</a>
            </p>
    
        </div>
        
    
    
    <!-- //footer -->
    <!-- copyright -->
   
    <!-- //copyright -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script><script  src="./script.js"></script>

    <script src="{{ asset('site/script.js') }}" defer></script> 
    <script src="{{ asset('site/js/banner.js') }}" defer></script> 

</body>

</html>
