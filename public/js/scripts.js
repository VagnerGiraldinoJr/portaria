function maskMercosul(selector) {
    var MercoSulMaskBehavior = function (val) {
        var myMask = 'AAA0A00';
        var mercosul = /([A-Za-z]{3}[0-9]{1}[A-Za-z]{1})/;
        var normal = /([A-Za-z]{3}[0-9]{2})/;
        var replaced = val.replace(/[^\w]/g, '');
        if (normal.exec(replaced)) {
            myMask = 'AAA-0000';
        } else if (mercosul.exec(replaced)) {
            myMask = 'AAA-0A00';
        }
        return myMask;
    },
    mercoSulOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(MercoSulMaskBehavior.apply({}, arguments), options);
        }
    };
    $(function() {
        $(selector).bind('paste', function(e) {
            $(this).unmask();
        });
        $(selector).bind('input', function(e) {
            $(selector).mask(MercoSulMaskBehavior, mercoSulOptions);
        });
});
}

$(document).ready(function($){
// $(document).ready(function(){
    // MASKS
    $('#cep').mask("00.000-000", {placeholder: "00.000-000"});
    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },

    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        },
        placeholder: "(00) 0000-0000"
    };

    $('#telefone').mask(SPMaskBehavior, spOptions);
    $('#celular').mask(SPMaskBehavior, spOptions);
    $('#recado').mask(SPMaskBehavior, spOptions);
    $('.acrescimo').mask('9999999999,99');
    $('.desconto').mask('9999999999,99');
    var options = {
        onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            $('.cpf_cnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
        }
    }
    $('.cpf_cnpj').length > 11 ? $('.cpf_cnpj').mask('00.000.000/0000-00', options) : $('.cpf_cnpj').mask('000.000.000-00#', options);
    /// itens de pedido
    $('#cep').mask("00.000-000", {placeholder: "00.000-000"});
    $('.quantidade').mask('9999999999,99');

   
});