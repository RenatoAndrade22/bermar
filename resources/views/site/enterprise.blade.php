@extends('layouts.layout')

@section('content')
    <section class="banner-bottom py-5">
        <div class="container py-md-5">
            <div class="row grids-wthree-info mb-5">
                <div class="col-lg-3 bag-img">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="" />
                </div>
                <div class="col-lg-9 text-left">
                    <h4>Sobre A Empresa</h4>
                    <p>A BERMAR foi criada em 1986, trazendo consigo uma mistura única dos sobrenomes dos seus fundadores. Valdemir Fernandes Martines (conhecido como Poli) e João Roberto de Abreu Berton uniram suas habilidades e visões empresariais para dar vida a este empreendimento. A escolha do nome BERMAR foi inspirada nesses fundadores, combinando as primeiras sílabas dos seus sobrenomes, Berton e Martines. Desde então, a BERMAR tem se expandido e consolidado como uma empresa respeitada no mercado, graças à sua dedicação e paixão pelo trabalho bem feito.</p>
                </div>
            </div>
            <div class="row grids-wthree-info text-center">
                <div class="col-lg-4 ab-content">
                    <div class="ab-info-con">
                        <h4>OBJETIVO</h4>
                        <p>Do objetivo A sociedade formou-se com o objetivo de produzir máquinas que pudessem suprir as necessidades dos clientes, pois até aquele momento não existia no mercado máquinas com qualidade suficiente e com o custo razoável para os consumidores.</p>
                    </div>
                </div>
                <div class="col-lg-4 ab-content">
                    <div class="ab-info-con">
                        <h4>EMPRESA</h4>
                        <p>Da empresa Sem a menor pretensão de ser os únicos no mercado, fomos conquistando nossa fatia através de parcerias sólidas e honestas com nossos clientes que nos solicitaram a fabricação de outros produtos já existentes no mercado mas que não os atendiam satisfatoriamente. </p>
                    </div>
                </div>
                <div class="col-lg-4 ab-content">
                    <div class="ab-info-con">
                        <h4>EXPANSÃO</h4>
                        <p>Hoje nossa empresa atua em todo território nacional e exporta para alguns países da América Central e do Sul. Com investimentos em tecnologia e capacitação humana, estamos nos preparando com muito trabalho e conquistando novos parceiros.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
