@extends('layouts.layout')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        #busca_bloco{
            display: none;
        }
    </style>
    <div id="loading">
        <img src="https://media.tenor.com/On7kvXhzml4AAAAi/loading-gif.gif" alt="">
    </div>
    <section class="mb-5">
        <div>
            <div>
                <br>

                <h4 class=" mt-3 mb-3  text-center ">Busque representantes por Estado.</h4>

                <div class=" text-center">
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
        
        <div class="container" id="busca_bloco">
            <div>
                <div class="col-md-6 mx-auto">
                    <div class="input-group mb-3">
                        <input type="text" id="texto_busca" class="form-control" placeholder="Buscar por nome ou cidade">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="buscar">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="list-representatives" class="mt-4">
        </div>

        <div id="links-pages">
        </div>

    </section>
    <script>

    var pagina_atual = 1;
    var first = true;
    var search = null;
    var ultima_pagina = null;

    // Captura o evento de clique no botão
    document.getElementById("buscar").addEventListener("click", function () {
            // Obtém o valor do input
            var valorDoInput = document.getElementById("texto_busca").value;

            document.getElementById("loading").style.display = "block";

            pagina_atual = 1;
            first = true;
    
            search = valorDoInput;

            selectState(valorDoInput, pagina_atual);

    });

    function selectState(texto_busca = null, paginacao = 0) {

        var uf = document.getElementById("select_state").value;
        document.getElementById("loading").style.display = "block";

        var url = "/api/get-companies-state/representantes/"+uf+'?page='+paginacao;
        if(texto_busca){
            var url = "/api/get-companies-state/representantes/"+uf+"/"+texto_busca+'?page='+paginacao;
        }

        $.ajax({
            url: url,
            cache: false,
            success: function(resp){
                document.getElementById("loading").style.display = "none";
          
                if (resp.links.length >= 2) {
                    // Obtém o penúltimo objeto
                    var item = resp.links[resp.links.length - 2];

                    ultima_pagina = item.label;
                }

                if(resp.data.length > 0){

                    var html = '<div class="container"><ul><div class="row">';

                    // listando o conteúdo
                    for (let i = 0; i < resp.data.length; i++) {

                        var complement = resp.data[i].complement ? resp.data[i].complement+', ' : '';
                        var name = resp.data[i].name ? resp.data[i].name+', ' : '';
                        var street = resp.data[i].street ? resp.data[i].street+', ' : '';
                        var number = resp.data[i].number ? resp.data[i].number+', ' : '';
                        var district = resp.data[i].district ? resp.data[i].district+', ' : '';
                        var city = resp.data[i].city ? resp.data[i].city : '';                        
                        var state = resp.data[i].state ? '-'+resp.data[i].state : '';
                        var phone = resp.data[i].phone ? resp.data[i].phone+', ' : '';
                        
                        html = 
                            html+'<div class="col-md-4"><li><h5>'+name+'</h5><p>Endereço<br>'+street+number+district+complement+city+state+' <br>'+phone+'</p></li></div>';
                    }
                    
                    html = html+'</ul></div>';

                    // listando a paginação
                    var pages = '<div class="container"><ul>';

                    for (let i = 0; i < resp.links.length; i++) {
                        var class_active = resp.links[i].active ? 'active' : ' ';
                        pages = pages+'<li class="'+class_active+'" data-label="' + resp.links[i].label + '">'+resp.links[i].label+'</li>';
                    }

                    pages = pages+'</ul></div>'
                    

                }else{
                    var html = '<p>Nenhuma empresa encontrada</p>';
                }

                document.getElementById("busca_bloco").style.display = "block";

                $('#list-representatives').html(html);
                $('#links-pages').html(pages);
            }
        });

    }

        // pega o click na paginação
        $('#links-pages').on('click', 'li', function() {
                        
                        // Obtém o índice associado a esta li
                        var paginacao = $(this).data('label');

                        // verifica se clicou em proximo ou anterior
                        if(typeof paginacao === "string" && paginacao.includes("Anterior")){
                           
                            if(pagina_atual != 1){
                                paginacao = pagina_atual - 1;
                            }else{
                                paginacao = 1;
                            }
                        }

                        if(typeof paginacao === "string" && paginacao.includes("Próximo")){

                            if(ultima_pagina != pagina_atual){
                                paginacao = pagina_atual + 1
                            } else{
                                paginacao = ultima_pagina;
                            }
                           
                           
                        }

                        pagina_atual = paginacao;


                        selectState(search, paginacao)
                        first = false;
    });

     
</script>
@endsection



