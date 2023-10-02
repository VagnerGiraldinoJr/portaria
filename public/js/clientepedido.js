$(document).ready(function(){
	// Buscar Cliente

    var buscarCliente = (_params) => {

        var tmp = $("input[name=cpf_cnpj]."+_params).val();
        
        if(tmp != ''){
            var cpf_cnpj = $("input[name=cpf_cnpj]."+_params).serialize();
            if(cpf_cnpj != '' && cpf_cnpj != "cpf_cnpj=" ){
                var url = 'http://dominare.localhost/admin/cliente/buscar' ;
                $.ajax({
                        url: url,
                        data: cpf_cnpj,
                        method: 'GET',

                        dataType: 'json',
                        crossDomain: true,
                        contentType: "application/json",
                        error: function(data){
                            if( data.status === 422 ) {
                                var errors = data.responseJSON;
                                $.each( errors.errors, function( key, value ) {
                                    if(key == 'cpf_cnpj'){
                                        $(document).Toasts('create', {
                                            class: 'bg-danger',
                                            title: 'Atenção',
                                            subtitle: 'Erro',
                                            body: value,
                                            autohide:true,
                                            close: false,
                                        });


                                    }
                                });
                            }
                        },
                        success : function(json){

                            if(json !== null && (!jQuery.isEmptyObject(json)) ){
                                $("input[name=cliente_id]").val(json.id);
                                
                                $("input[name=nome_razaosocial]").val(json.nome_razaosocial);
                                $("input[name=data_nascimento]").val(json.data_nascimento);
                                $("input[name=cep]").val(json.cep);
                                $("input[name=complemento]").val(json.complemento);
                                $("input[name=numero]").val(json.numero);

                                $("input[name=email]").val(json.email);
                                $("input[name=telefone]").val(json.telefone);
                                $("input[name=celular]").val(json.celular);
                                $("input[name=recado]").val(json.recado);

                                $("input[name=observacoes]").val(json.observacoes);


                                $("input[name=logradouro]").val(json.logradouro);
                                $("input[name=bairro]").val(json.bairro);
                                $("input[name=localidade]").val(json.localidade);
                                $("input[name=uf]").val(json.uf);

                            /*  
                                'route' => [$params['main_route'].'.update',$data->id]
                                ,'id' => 'form-cliente'
                                ,'class' => 'form'
                                ,'method' => 'put'
                            */
                                var field = document.createElement("input");
                                $(field).attr('name','_method').attr('type','hidden').val('PUT');
                                $("form[id=form-cliente]").prepend(field);

                                $("form[id=form-cliente]").attr('action','http://dominare.localhost/admin/cliente/update/'+json.id);

                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Registro Encontrado',
                                    subtitle: '',
                                    body: 'Cliente <strong>Já Cadastrado</strong>',
                                    autohide:true,
                                    close: false,
                                });

                                return ;
                            }else{
                                $(document).Toasts('create', {
                                    class: 'bg-danger',
                                    title: 'Atenção',
                                    subtitle: 'Erro',
                                    body: 'Cliente <strong>Não Cadastrado</strong>',
                                    autohide:true,
                                    close: false,
                                });

                            }
                        }
                });

            }else{
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Atenção',
                    subtitle: 'Erro',
                    body: 'Preencha o <strong>CPF ou CNPJ</strong>',
                    autohide:true,
                    close: false,
                });
                
            }
        }

        $("input[name=cliente_id]").val('');

        $("input[name=cliente_id]").val('');
        $("input[name=nome_razaosocial]").val('');
        $("input[name=data_nascimento]").val('');
        $("input[name=cep]").val('');
        $("input[name=complemento]").val('');
        $("input[name=numero]").val('');

        $("input[name=email]").val('');
        $("input[name=telefone]").val('');
        $("input[name=celular]").val('');
        $("input[name=recado]").val('');

        $("input[name=observacoes]").val('');


        $("input[name=logradouro]").val('');
        $("input[name=bairro]").val('');
        $("input[name=localidade]").val('');
        $("input[name=uf]").val('');

        $("form[id=form-cliente] input[name=_method]").remove()

        $("form[id=form-cliente]").attr('method','post');
        $("form[id=form-cliente]").attr('action','http://dominare.localhost/admin/cliente/store');
    };



    var buscarOrcamento = function(params = null) {
        var id = params;

        if(id != null){
            var url = 'http://dominare.localhost/admin/orcamento/buscar/';
			$.ajax({
                    url: url,
                    data: {
                        'id' : id
                    }  ,
                    method: 'GET',

                    dataType: 'json',
                    crossDomain: true,
                    async: false,
                    contentType: "application/json",
                    success : function(json){

                    	if(json !== null && (!jQuery.isEmptyObject(json)) ){
                            return json;
                        }else{

                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Atenção',
                                body: 'Erro <strong>Orçamento não encontrado</strong>',
                                subtitle: 'Erro',
                            });
                        }
					}
            });
        }else{
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Atenção',
                body: 'Erro <strong>Orçamento não encontrado</strong>',
                subtitle: 'Erro',
            });
        }

    };

    $('#modalOrcamentos').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        if(id !== null){
            var url = 'http://dominare.localhost/admin/orcamento/buscar/';
            $.ajax({
                    url: url,
                    data: {
                        'id' : id
                    },
                    method: 'GET',
                    dataType: 'json',
                    crossDomain: true,
                    contentType: "application/json",
                    success : function(json){
                        if(json !== null && (!jQuery.isEmptyObject(json)) ){
                            var result = json[0];
                            $('#modalOrcamentos').find('p[data-orcamento]').each(function() {
                                var attr = $(this).attr('data-orcamento');
                                if($(this).attr('data-format') == "float"){
                                    $(this).html(parseFloat(result[attr]).toFixed(2).toString().replace(/\./g, ','));
                                }else{
                                    $(this).html(result[attr]);
                                }

                            });

                            $('#itens_pedido').html('');

                            $.each(result.itens, function( index, value ) {
                                var linha = $('<tr></tr>');
                                var fields = ['desc_produto','quantidade','valor'];
                                var float = ['quantidade','valor'];
                                var coluna = [];



                                $.each(value, function(i,v){
                                    if( $.inArray(i, fields) !== -1 ){
                                        if($.inArray(i, float) !== -1 ){
                                            coluna[i] = $('<td></td>').addClass("text-right").text(parseFloat(v).toFixed(2).toString().replace(/\./g, ','));
                                        }else{
                                            coluna[i] = $('<td></td>').text(v);
                                        }
                                    }
                                });

                                //preenche os campos

                                $.each(fields, function(i,v){
                                    linha.append(coluna[v]);
                                });


                                var coluna = $('<td></td>').addClass("text-right").text(parseFloat(value.quantidade * value.valor).toFixed(2).toString().replace(/\./g, ','));
                                linha.append(coluna);

/*
                                coluna = $('<td></td>').text(value.desc_produto);
                                linha.append(coluna);

                                coluna = $('<td></td>').text(value.quantidade);
                                linha.append(coluna);

                                coluna = $('<td></td>').text(value.valor);
                                linha.append(coluna);
*/



                              //  console.log(linha);
                                $('#itens_pedido').append(linha);
                            });


                        }else{
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Atenção',
                                body: 'Erro <strong>Orçamento não encontrado</strong>',
                                subtitle: 'Erro',
                            });
                        }
                    }
            });
        }else{
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Atenção',
                body: 'Erro <strong>Orçamento não encontrado</strong>',
                subtitle: 'Erro',
            });
        }
    });

    $("input[name=cpf_cnpj].orcamento").change(function(){
        buscarCliente(_params = "create");
    });
    
    $("input[name=cpf_cnpj]._modal").change(function(){
        buscarCliente(_params = "_modal");
    });

    $("#btn-buscar").on('click',function(){
        buscarCliente(_params = "create");
    });

});

