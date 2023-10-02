
$(document).ready(function($){


    $("#itenscompra").createRepeater({
        showFirstItemToDefault: true,
        classRepeat: ".items",
        classBtnAdd: ".repeater-add-btn",
        classBtnRemove: ".remove-btn",
        resetValue: false,
        afterInsert: function(){
            $('.float').mask('9999999999,99');
            $('.money').mask('9999999999,99');
            calculaCompra();
        },
        afterRemove: 'calculaCompra(true);'

    });
    calculaCompra(true);

    $("#btn-save").click(function(e){
        e.preventDefault()
        var form = $("#form-cliente");
        var errorHtml=$('#display-errors ul').html('');
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
                    $("#form-cliente").each (function(){
                        this.reset();
                    });
                    $('#modalClientes').modal('hide');
                }
            },


        });

    });

    function calculaCompra(flag = false){

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
});
