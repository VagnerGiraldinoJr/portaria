$(document).ready(function(){
    reload_tipo($('#tipo_referencia').val());
    
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('input[name="pedido"]').mask('999999999999');

    function reload_tipo(value){
        if(value == 1){
            $('#label_descricao').html('Nº Pedido');

            $('input[name="pedido"]').removeClass('d-none');
            $('input[name="referencia"]').val('');
            $('input[name="referencia"]').addClass('d-none');
        }else{
            $('#label_descricao').html('Descrição');

            $('input[name="referencia"]').removeClass('d-none');
            $('input[name="pedido"]').val('');
            $('input[name="pedido"]').addClass('d-none');
        }
        $('#response').addClass('d-none');
        $('#response').html('');
    }

    $('#tipo_referencia').change(function() {
        reload_tipo(this.value);
    });


    $('input[name="pedido"]').change(function() {
        buscarPedido();
    });

    function buscarPedido(){
        
        var url = 'http://dominare.localhost/admin/entradas/buscarpedido/';
       
        var id = $('input[name="pedido"]').val();
        $.ajax({
            url: url + id,
            method: 'GET',
            dataType: 'json',
            contentType: "application/json",

            dataType: 'json',
            crossDomain: true,
            async: false,

            error: function(data){
                if( data.status === 422 ) {
                    $('#response').removeClass('d-none');
                    $('#response').val('Pedido Não encontrado!');
                }
            },
            success : function(json){
                if(json !== null && (!jQuery.isEmptyObject(json)) ){
                    console.log(json);
                    $('#response').removeClass('d-none');
                    $('input[name="pedido_id"]').val(json.id);
                    let valor_total = parseFloat(json.valor_total).toFixed(2).toString().replace(/\./g, ',')
                    $('#response').html('<strong>Pedido:</strong> '+json.id+' <strong>Cliente:</strong> '+json.cpf_cnpj+' - ' + json.nome_razaosocial+'<strong> Valor Total: </strong>'+valor_total);
                }else{
                    $('input[name="pedido_id"]').val('');
                    $('#response').removeClass('d-none');
                    $('#response').html('Pedido Não encontrado!');
                }
            }
        });
    }



});
