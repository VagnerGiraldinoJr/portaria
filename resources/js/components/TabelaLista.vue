<template>
    <!--
    TEMPLATE USAGE PARAMS
    <tabela-lista
        v-bind:titulos="['#','Título','Descrição']"
        v-bind:itens="{{$listaArtigos}}"
        ordem="desc"
        ordemcol="1"
        criar="ROUTE_CRIAR"
        detalhe="ROUTE_DETALHE"
        editar="ROUTE_EDITAR"
        deletar="ROUTE_DELETAR"
        token="CRF_TOKEN"
    ></tabela-lista>

    -->
    <div class="card">
        <div class="card-header">
            <div class="row pb-2 t">
                <div class="col-12">
                    <h3 class="card-title font-weight-bold">{{ titulo }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <input type="search" class="form-control" placeholder="Buscar" v-model="buscar" >
                </div>
                <div class="col-6 text-right">
                    <a v-if="criar" v-bind:href="criar" class="btn btn-primary btn-xs"><span class="fas fa-plus"></span> Novo Cadastro</a>
                </div>
            </div>

        </div>


        <div  class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="cursor:pointer" v-on:click="ordenaColuna(index)" v-for="(titulo,index) in titulos"  v-bind:key="index">{{titulo}}</th>

                        <th v-if="detalhe || editar || deletar">Ação</th>
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="(item,index) in lista"  v-bind:key="index">
                        <td v-for="(i, index) in item"  v-bind:key="index">{{i}}</td>

                        <td v-if="detalhe || editar || deletar">
                            <form v-bind:id="index" v-if="deletar && token" v-bind:action="deletar" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" v-bind:value="token">

                            <a v-if="detalhe" v-bind:href="detalhe">Detalhe |</a>
                            <a v-if="editar" v-bind:href="editar"> Editar |</a>

                            <a href="#" v-on:click="executaForm(index)"> Deletar</a>

                            </form>
                            <span v-if="!token">
                            <a v-if="detalhe" v-bind:href="detalhe">Detalhe |</a>
                            <a v-if="editar" v-bind:href="editar"> Editar |</a>
                            <a v-if="deletar" v-bind:href="deletar"> Deletar</a>
                            </span>
                            <span v-if="token && !deletar">
                            <a v-if="detalhe" v-bind:href="detalhe">Detalhe |</a>
                            <a v-if="editar" v-bind:href="editar"> Editar</a>
                            </span>


                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
      props:['titulo','titulos','itens','ordem','ordemcol','criar','detalhe','editar','deletar','token'],
      data: function(){
        return {
          buscar:'',
          ordemAux: this.ordem || "asc",
          ordemAuxCol: this.ordemcol || 0
        }
      },
      methods:{
        executaForm: function(index){
          document.getElementById(index).submit();
        },
        ordenaColuna: function(coluna){
          this.ordemAuxCol = coluna;
          if(this.ordemAux.toLowerCase() == "asc"){
            this.ordemAux = 'desc';
          }else{
            this.ordemAux = 'asc';
          }
        }
      },
      computed:{
        lista:function(){

          let ordem = this.ordemAux;
          let ordemCol = this.ordemAuxCol;
          let lista = this.itens.data;
          ordem = ordem.toLowerCase();
          ordemCol = parseInt(ordemCol);

          if(ordem == "asc"){
            lista.sort(function(a,b){
              if (Object.values(a)[ordemCol] > Object.values(b)[ordemCol] ) { return 1;}
              if (Object.values(a)[ordemCol] < Object.values(b)[ordemCol] ) { return -1;}
              return 0;
            });
          }else{
            lista.sort(function(a,b){
              if (Object.values(a)[ordemCol] < Object.values(b)[ordemCol] ) { return 1;}
              if (Object.values(a)[ordemCol] > Object.values(b)[ordemCol] ) { return -1;}
              return 0;
            });
          }

          if(this.buscar){
            return lista.filter(res => {
              for(let k = 0;k < res.length; k++){
                if((res[k] + "").toLowerCase().indexOf(this.buscar.toLowerCase()) >= 0){
                  return true;
                }
              }
              return false;

            });
          }
          return lista;
        }
      }
    }
</script>
