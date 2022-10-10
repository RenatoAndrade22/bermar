@extends('layouts.layout')

@section('content')
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-12">
                <p class="col-lg-12 text-center h3 p-3 text-secondary">Selecione um estado para encontrar o representante mais próximo de você</p>
                <div class="col-lg-12 text-center">
                    <div class="fs-dropdown fs-light" id="fs-dropdown__1-dropdown" tabindex="0" role="listbox" aria-haspopup="true" aria-live="polite" aria-labelledby="fs-dropdown__1-dropdown-selected">
                        <select required="" name="estado" class="form-input dropdown-select fs-dropdown-element col-lg-4 p-3 borderStyle text-secondary" tabindex="-1">
                            <option class="option" value="AC" selected=""> ACRE</option>
                            <option value="AL"> ALAGOAS</option>
                            <option value="AP"> AMAPA</option>
                            <option value="AM"> AMAZONAS</option>
                            <option value="BA"> BAHIA</option>
                            <option value="CE"> CEARA</option>
                            <option value="DF"> DISTRITO FEDERAL</option>
                            <option value="ES"> ESPITÍRO SANTO</option>
                            <option value="GO"> GOIÁS</option>
                            <option value="MA"> MARANHÃO</option>
                            <option value="MT"> MATO GROSSO</option>
                            <option value="MS"> MATO GROSSO DO SUL</option>
                            <option value="MG"> MINAS GERAIS</option>
                            <option value="PA"> PARÁ</option>
                            <option value="PB"> PARAÍBA</option>
                            <option value="PR"> PARANA</option>
                            <option value="PE"> PERNANBUCO</option>
                            <option value="PI"> PIAUÍ</option>
                            <option value="RJ"> RIO DE JANEIRO</option>
                            <option value="RN"> RIO GRANDE DO NORTE</option>
                            <option value="RS"> RIO GRANDE DO SUL</option>
                            <option value="RO"> RONDONIA</option>
                            <option value="RR"> RORAIMA</option>
                            <option value="SC"> SANTA CATARINA</option>
                            <option value="SP"> SÃO PAULO</option>
                            <option value="SE"> SERGIPE</option>
                            <option value="TO"> TOCANTINS</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//newsletter -->
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-4 px-4">
                <div class="col-lg-12 p-4 boxStyle">
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5 borderBotton pb-2">São Paulo</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Representante</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 borderBotton pb-2">Paulo José da Silva</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Contato</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 borderBotton pb-2">(17) 98122-5539</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Endereço</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 pb-2">
                        RUA PREFEITO MANUEL REGUEIRA, 20, ALTO DA MINA, ALTO DA MINA, AL, Brasil</p>
                </div>
            </div>

            <div class="col-lg-4 px-4">
                <div class="col-lg-12 p-4 boxStyle">
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5 borderBotton pb-2">São Paulo</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Representante</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 borderBotton pb-2">Paulo José da Silva</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Contato</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 borderBotton pb-2">(17) 98122-5539</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Endereço</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 pb-2">
                        RUA PREFEITO MANUEL REGUEIRA, 20, ALTO DA MINA, ALTO DA MINA, AL, Brasil</p>
                </div>
            </div>

            <div class="col-lg-4 px-4">
                <div class="col-lg-12 p-4 boxStyle">
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5 borderBotton pb-2">São Paulo</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Representante</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 borderBotton pb-2">Paulo José da Silva</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Contato</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 borderBotton pb-2">(17) 98122-5539</p>
                    <p class="col-lg-12 text-center colorRed font-weight-bold h5">Endereço</p>
                    <p class="col-lg-12 text-secondary text-center colorRed font-weight-bold h6 pb-2">
                        RUA PREFEITO MANUEL REGUEIRA, 20, ALTO DA MINA, ALTO DA MINA, AL, Brasil</p>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .borderStyle {
        border-radius: 13px;
        border-color: #ec1c24;
    }

    .colorRed{
        color: #ec1c24;
    }

    .borderBotton{
        border-bottom: 1px solid #c1c1c1;
    }

    .boxStyle{
        border: 1px solid #ec1c24;
        border-radius: 15px;
    }

</style>
