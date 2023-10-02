
$(document).ready(function($){


    $("#itenspedido").createRepeater({
        showFirstItemToDefault: true,
        classRepeat: ".items",
        classBtnAdd: ".repeater-add-btn",
        classBtnRemove: ".remove-btn",
        resetValue: false,
        afterInsert: function(){
            $('.float').mask('9999999999,99');
            $('.money').mask('9999999999,99');
            calculaPedido();
        },
        afterRemove: 'calculaPedido(true);'

    });
    calculaPedido(true);

    $("#btn-save").click(function(e){
        e.preventDefault()
        var form = $("#form-cliente");
       
        $.ajax({
            method: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            timeout: 9000,
            error: function(data){
                if( data.status === 422 ) {
                    var errors = data.responseJSON;

                    $.each( errors.errors, function( key, value ) {
                        errorHtml.append('<li>' + value + '</li>');
                    });
                    $('#display-errors').removeClass('d-none');
                    $('#display-errors').addClass('d-block');
                }else{
                    $('#modalClientes').modal('hide');
                }
            },


        });

    });

    function calculaPedido(flag = false){

        /*FLAG*/
        if(flag == false){
            $('.qtd, .vlr_unitario, .acrescimo, .desconto').on('change blur keyup',function(){
                var tmp_total = parseFloat('0.0');
                $('.items').each(function(){//percorre todos os campos de quantidade
                    //quantidade
                    var qtd = parseFloat(($(this).find('.qtd').val() == '') ? 0.00 : $(this).find('.qtd').val().toString().replace(/\./g, '').replace(/\,/g, '.'));
                    //pega o valor unitário
                    var vlr = parseFloat(($(this).find('.vlr_unitario').val() == '') ? 0.00 : $(this).find('.vlr_unitario').val().toString().replace(/\./g, '').replace(/\,/g, '.'));
                    // coloca o resultado no valor total

                    tmp_total= parseFloat(parseFloat(tmp_total) + parseFloat(qtd * vlr));
                });

                var desconto = parseFloat($('.desconto').val() == '' ? 0.00 : $('.desconto').val().toString().replace(/\./g, '').replace(/\,/g, '.'));
                var acrescimo = parseFloat($('.acrescimo').val() == '' ? 0.00 : $('.acrescimo').val().toString().replace(/\./g, '').replace(/\,/g, '.'));

                $('.sub_total').val(parseFloat(tmp_total).toFixed(2).toString().replace(/\./g, ','));
                $('.valor_total').val(parseFloat(tmp_total + acrescimo - desconto).toFixed(2).toString().replace(/\./g, ','));
            });
        }else{
            var tmp_total = parseFloat('0.0');
            $('.items').each(function(){//percorre todos os campos de quantidade
                //quantidade
                var qtd = parseFloat(($(this).find('.qtd').val() == '') ? 0.00 : $(this).find('.qtd').val().toString().replace(/\./g, '').replace(/\,/g, '.'));
                //pega o valor unitário
                var vlr = parseFloat(($(this).find('.vlr_unitario').val() == '') ? 0.00 : $(this).find('.vlr_unitario').val().toString().replace(/\./g, '').replace(/\,/g, '.'));
                // coloca o resultado no valor total

                tmp_total= parseFloat(parseFloat(tmp_total) + parseFloat(qtd * vlr));
            });

            var desconto = parseFloat($('.desconto').val() == '' ? 0.00 : $('.desconto').val().toString().replace(/\./g, '').replace(/\,/g, '.'));
            var acrescimo = parseFloat($('.acrescimo').val() == '' ? 0.00 : $('.acrescimo').val().toString().replace(/\./g, '').replace(/\,/g, '.'));

            $('.sub_total').val(parseFloat(tmp_total).toFixed(2).toString().replace(/\./g, ','));
            $('.valor_total').val(parseFloat(tmp_total + acrescimo - desconto).toFixed(2).toString().replace(/\./g, ','));
        }

    }

    $('#modalClientes').on('shown.bs.modal', function () {
        $("input[name=cliente_id]").val('');

        $("input[name=cpf_cnpj]").val('');
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
    });
    
    $('#modalClientes').on('hidden.bs.modal', function (e) { 
        $("input[name=cpf_cnpj].create").val( $("input[name=cpf_cnpj][data-class=cliente]").val());
        $("input[name=cpf_cnpj].create").change();
        $("#form-cliente").each (function(){
            this.reset();
        });
    });

    
});
