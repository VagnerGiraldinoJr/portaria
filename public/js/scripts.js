$(document).ready(function($){
// $(document).ready(function(){
    // MASKS
    $('#cep').mask("00.000-000", {placeholder: "00.000-000"});
    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '00000000000' : '00000000000';
        },

    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        },
        placeholder: "(00) 0000-0000"
    };
    
    $('.telefone').mask(SPMaskBehavior, spOptions);
    $('.celular').mask(SPMaskBehavior, spOptions);
    var options = {
        onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            $('.cpf_cnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
        }
    }
    $('.cpf_cnpj').length > 11 ? $('.cpf_cnpj').mask('00.000.000/0000-00', options) : $('.cpf_cnpj').mask('000.000.000-00#', options);
    /// itens de pedido
    $('.cep').mask("00.000-000", {placeholder: "00.000-000"});
    $('.rg').mask("00000000000000");
    $(".placa").mask('AAA-XXXX');
});