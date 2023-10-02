<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3 class="card-title">{{params['subtitulo']}}</h3>
                </div>
                <div class="col-6 text-right">
                    <a v-bind:href="params['main_route']" class="btn btn-primary btn-xs"><span class="fas fa-plus"></span> Novo Cadastro</a>
                </div>
            </div>

        </div>
        <!-- /.card-header -->
        <div v-if="(data != null)" class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CPF / CNPJ</th>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Telefone</th>
                        <th>Operação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in item" :key="item.id">
                        <td>{{ item['cpf_cnpj']}}</td>
                        <td>{{ item['nome_razaosocial']}}</td>
                        <td>{{ item['logradouro'] }}, {{ item['numero'] }}, {{ item['bairro'] }}</td>
                        <td>{{ item['telefone'] }}</td>
                        <td>
                            <a v-bind:href="params['main_route']" class="btn btn-info btn-xs"><span class="fas fa-edit"></span> Editar</a>
                            <a v-bind:href="params['main_route']" class="btn btn-danger btn-xs"><span class="fas fa-trash"></span> Ver / Deletar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="alert alert-success m-2" role="alert">
            Nenhuma informação cadastrada.
        </div>
        <!-- /.card-body -->
        <!-- /.card-body -->
        <div class="card-footer">
            {{ data['links'] }}
        </div>
    </div>
</template>

<script>
export default {
    props: ['params','data']

}
</script>

<style>

</style>
