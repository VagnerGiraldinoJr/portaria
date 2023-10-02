<div id="modalOrcamentos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Cadastro de Orçamentos</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <!-- /.card-header -->
          <div class="card-body ">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <p class="w-100 p-0 m-0 text-center font-weight-bold">Identificação do Cliente</p>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <label>CPF / CNPJ</label><br>
                    <p data-orcamento="cpf_cnpj" ></p>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <label>Data Nascimento</label><br>
                    <p data-orcamento="data_nascimento_br" ></p>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <label>Nome / Razão Social</label><br>
                    <p data-orcamento="nome_razaosocial" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>CEP</label><br>
                    <p data-orcamento="cep" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>Logradouro</label><br>
                    <p data-orcamento="logradouro" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>Localidade</label><br>
                    <p data-orcamento="localidade" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>UF</label><br>
                    <p data-orcamento="uf" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>Bairro</label><br>
                    <p data-orcamento="bairro" ></p>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <label>Numero</label><br>
                    <p data-orcamento="numero" ></p>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <label>Complemento</label><br>
                    <p data-orcamento="complemento" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>E-mail</label><br>
                    <p data-orcamento="email" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>Telefone</label><br>
                    <p data-orcamento="telefone" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>Celular</label><br>
                    <p data-orcamento="celular" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>Recado</label><br>
                    <p data-orcamento="recado" ></p>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <label>Observacoes</label><br>
                    <p data-orcamento="observacoes" ></p>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <label></label><br>
                    <p  ></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <p class="w-100 p-0 m-0 text-center font-weight-bold">Itens do Pedido</p>
                </div>

                <div class="col-12 col-md-12 p-0">
                    <div class="table-responsive p-0">
                        <table id="table-itens" class="table table-sm p-0">
                            <thead>
                                <tr>
                                <th scope="col">Produtos/Serviços</th>
                                <th scope="col" data-format="float" class="text-right">Qtidade</th>
                                <th scope="col" data-format="float" class="text-right" >Valor</th>
                                <th scope="col" data-format="float" class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody id="itens_pedido">

                            </tbody>
                            </table>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3 ">
                    <label>Valor</label>
                    <p data-orcamento="valor" data-format="float"></p>
                </div>
                <div class="col-12 col-md-6 col-lg-3 text-center">
                    <label>Acréscimo</label>
                    <p data-orcamento="acrescimo" data-format="float" class="text-center"></p>
                </div>
                <div class="col-12 col-md-6 col-lg-3 text-center">
                    <label>Desconto</label>
                    <p data-orcamento="desconto" data-format="float" class="text-center"></p>
                </div>
                <div class="col-12 col-md-6 col-lg-3 text-right">
                    <label>Valor Total</label>
                    <p data-orcamento="valor_total" data-format="float" class="text-right"></p>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <label>Forma Pagamento</label>
                    <p data-orcamento="desc_forma_pagamento"></p>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <label>Data Entrega</label>
                    <p data-orcamento="data_entrega_br"></p>
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Sair</button>
        </div>
        </div>

    </div>
</div>
@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop
