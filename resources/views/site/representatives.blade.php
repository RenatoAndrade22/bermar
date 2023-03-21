@extends('layouts.layout')

@section('content')
    <div id="loading">
        <img src="https://media.tenor.com/On7kvXhzml4AAAAi/loading-gif.gif" alt="">
    </div>
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <h4 class="col-lg-12 mt-3 mb-3  text-center ">Busque o representante por Estado.</h4>
                <div class="col-lg-12 text-center">
                    <div class="fs-dropdown fs-light" id="fs-dropdown__1-dropdown" tabindex="0" role="listbox" aria-haspopup="true" aria-live="polite" aria-labelledby="fs-dropdown__1-dropdown-selected">
                        <select id="select_state" onchange="selectState()" style="border-radius:20px;" required="" name="estado" class="form-input dropdown-select fs-dropdown-element col-lg-3 p-3 text-secondary" tabindex="-1">
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
        <div class="row" id="list-representatives">
        </div>
    </section>
@endsection

<script>
    function selectState() {

        var uf = document.getElementById("select_state").value;
        document.getElementById("loading").style.display = "block";

        $.ajax({
            url: "/api/get-companies-state/representantes/"+uf,
            cache: false,
            success: function(resp){
                document.getElementById("loading").style.display = "none";

                console.log('resp', resp);
                console.log('count', resp.length);
                if(resp.length > 0){

                    var html = '<ul>';

                    for (let i = 0; i < resp.length; i++) {
                        html = html+'<li><h5>'+resp[i].city+' - '+resp[i].state+'</h5><p>Endereço<br>'+resp[i].street+', '+resp[i].number+', '+resp[i].district+', '+resp[i].complement+'<br>(17) 98122-5539</p></li>';
                    }
                    
                    html = html+'</ul>';

                    console.log('teste', html)

                }else{
                    var html = '<p>Nenhuma empresa encontrada</p>';
                }
                
                $('#list-representatives').html(html);
            }
        });
        
    }

</script>

<style>

    #list-representatives{
  
    }

    #list-representatives ul{
        width: 100%;
        float: left;
    }

    #list-representatives ul li{
        width: 410px;
        margin: 20px;
        float: left;
        border: 1px solid #efeeee;
        border-radius: 15px;
        -webkit-box-shadow: 0px 0px 22px 0px rgb(239 238 238);
        -moz-box-shadow: 0px 0px 22px 0px rgba(239,238,238,1);
        box-shadow: 0px 0px 22px 0px rgb(239 238 238);
    }

    #list-representatives p{
        text-align: center;
        font-size: 13px;
    }
    
    #list-representatives h5{
        padding: 13px 0px;
        text-align: center !important;
        font-weight: 700 !important;
        border-bottom: 1px solid #c1c1c1;
    }

    #loading {
        text-align: center;
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 100;
        width: 100vw;
        height: 100vh;
        background-color: rgba(192, 192, 192, 0.5);
        background-repeat: no-repeat;
        background-position: center;
    }
    #loading img{
        height: 66px;
        margin-top: 128px;
    }
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
        border: 1px solid #efeeee;
        border-radius: 15px;
        -webkit-box-shadow: 0px 0px 22px 0px rgb(239 238 238);
        -moz-box-shadow: 0px 0px 22px 0px rgba(239,238,238,1);
        box-shadow: 0px 0px 22px 0px rgb(239 238 238);
    }

</style>
