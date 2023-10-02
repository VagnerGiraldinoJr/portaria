$(document).ready(function(){
	$("input[name=cep]").blur(function(){
        var cep = $(this).val().replace(/[^0-9]/, '');
        var data_class = $(this).attr('data-class');
//        console.log(data_class);
		if(cep){
			var url = 'https://viacep/ws/'+ cep + '/json/' ;
			$.ajax({
                    url: url,
                    dataType: 'jsonp',
                    crossDomain: true,
                    contentType: "application/json",
					success : function(json){
                        if(json !== null && (!jQuery.isEmptyObject(json)) ){
							$("input[name=logradouro][data-class="+data_class+"]").val(json.logradouro);
                            $("input[name=bairro][data-class="+data_class+"]").val(json.bairro);
                            $("input[name=localidade][data-class="+data_class+"]").val(json.localidade);
                            $("input[name=uf][data-class="+data_class+"]").val(json.uf);
                            $("input[name=numero][data-class="+data_class+"]").focus();
						}else{
                            $("input[name=logradouro][data-class="+data_class+"]").val('');
                            $("input[name=bairro][data-class="+data_class+"]").val('');
                            $("input[name=localidade][data-class="+data_class+"]").val('');
                            $("input[name=uf][data-class="+data_class+"]").val('');
                            $("input[name=numero][data-class="+data_class+"]").val('');
                            $("input[name=cep][data-class="+data_class+"]").focus();

                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Atenção',
                                subtitle: 'Erro',
                                body: 'Cliente <strong>CEP Não existe</strong>',
                                autohide:true,
                                close: false,
                            });
                        }
					}
			});
		}
    });

});

