<div id="modalClientes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Cadastro de Clientes</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <!-- /.card-header -->
          <div class="card-body ">
            <div id="display-errors" class="alert alert-danger d-none">
                <ul class="m-0 ">

                </ul>
            </div>

            {{ Form::open(['id'=>'form-cliente', 'route' => 'admin.cliente.store','method' =>'post', 'data-remote' => 'true']) }}
            <div class="row">
                {{--
                    id, tipo, cpf_cnpj, data_nascimento, nome_razaosocial,
                    cep, logradouro, complemento, bairro, localidade, uf,
                    email, telefone, celular, recado, observacoes
                    --}}

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('cpf_cnpj', 'CPF / CNPJ')}}
                    {{Form::text('cpf_cnpj',null,['class' => 'form-control cpf_cnpj', 'data-class' => 'cliente', 'placeholder' => 'CPF / CNPJ'])}}
                 </div>
                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('data_nascimento', 'Data de Nascimento')}}
                    <br>
                    {{Form::date('data_nascimento',(isset($data->data_nascimento)? \Carbon\Carbon::parse($data->data_nascimento) : null ),['class'=>'form-control', 'data-class' => 'cliente'])}}
                </div>
                <div class="form-group col-12 col-md-12 col-lg-12">
                    {{Form::label('nome_razaosocial', 'Nome / Razão Social')}}
                    {{Form::text('nome_razaosocial',null,['class' => 'form-control', 'data-class' => 'cliente', 'placeholder' => 'Nome / Razão Social'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('cep', 'CEP')}}
                    {{Form::text('cep',null,['class' => 'form-control buscarcep', 'data-class' => 'cliente', 'placeholder' => '00.000-000'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('logradouro', 'Logradouro')}}
                    {{Form::text('logradouro',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('localidade', 'Cidade')}}
                    {{Form::text('localidade',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('uf', 'UF')}}
                    {{Form::text('uf',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('bairro', 'Bairro')}}
                    {{Form::text('bairro',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>
                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('numero', 'Número')}}
                    {{Form::text('numero',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>
                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('complemento', 'Complemento')}}
                    {{Form::text('complemento',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('email', 'E-mail')}}
                    {{Form::text('email',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('telefone', 'Telefone Principal')}}
                    {{Form::text('telefone',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('celular', 'Celular')}}
                    {{Form::text('celular',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('recado', 'Recado')}}
                    {{Form::text('recado',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>

                <div class="form-group col-12 col-md-12 col-lg-6">
                    {{Form::label('observacoes', 'Observações')}}
                    {{Form::text('observacoes',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                </div>
            </div>

        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Sair</button>
            {{Form::submit('Salvar',['id'=> 'btn-save', 'class'=>'btn btn-success btn-sm'])}}
        </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
