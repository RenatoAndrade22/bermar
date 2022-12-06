@extends('layouts.layout')

@section('content')
    <section class="banner-bottom py-5">
        <div class="container py-md-5">

            <h3 class="title-wthree mb-lg-5 mb-4 text-center">Fale Conosco</h3>
            <div class="row contact_information">
                <div class="col-md-6">
                    <div class="contact_right p-lg-5 p-4">
                        <form action="#" method="post">
                            <div class="field-group">

                                <div class="content-input-field">
                                    <input name="text1" id="text1" type="text" value="" placeholder="Nome" required="">
                                </div>
                            </div>
                            <div class="field-group">

                                <div class="content-input-field">
                                    <input name="text1" id="text1" type="email" value="" placeholder="Email" required="">
                                </div>
                            </div>
                            <div class="field-group">

                                <div class="content-input-field">
                                    <input name="text1" id="text3" type="text" value="" placeholder="Telefone/Celular" required="">
                                </div>
                            </div>
                            <div class="field-group">

                            </div>
                            <div class="field-group">
                                <div class="content-input-field">
                                    <textarea placeholder="Digite sua mensagem..." required=""></textarea>
                                </div>
                            </div>
                            <div class="content-input-field">
                                <button type="submit" class="btn">Enviar</button>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-md-6 contact_left p-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14917.601905031019!2d-49.4135818!3d-20.8155288!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7794fc42b7cc08f3!2sBermar%20Ind%C3%BAstria%20Com%C3%A9rcio!5e0!3m2!1spt-BR!2sbr!4v1650969956913!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                </div>

                <div class="col-lg-4 col-md-6 mt-lg-4 contact-inn-w3pvt">
                    <div class="mt-5 information-wthree">
                        <h5 class="text-uppercase mb-4"><span class="fa fa-map"></span> Rua Francisco Curti, 245 <br>
                            Distrito Industrial <br>
                            São José do Rio Preto - SP<br>
                            CEP: 15035-620</h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-lg-4 contact-inn-w3pvt">
                    <div class="mt-5 information-wthree">
                        <h5 class="text-uppercase mb-4"><span class="fa fa-phone"></span> +55 (17) 3214-9600 </h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-lg-4 contact-inn-w3pvt">
                    <div class="mt-5 information-wthree">
                        <h5 class="text-uppercase mb-4"><span class="fa fa-envelope"></span> bermar@bermar.ind.br </h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

