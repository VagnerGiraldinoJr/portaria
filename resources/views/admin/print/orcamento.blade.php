<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orçamento - Grupo Dominare</title>
   
</head>
<body>
        <div id="printOrcamento" >
            <table class="table table-print ">
                <tr>
                    <td class="logo-colunas text-center p-2">
                        <div class="p-2 float-none">
                             <img src="png/logoMarca.png"  alt="Grupo Dominare">
                        </div>
                    </td>
                    <td  class="cabecalho-colunas">
                        <p class="text-center h3  pt-2">ORÇAMENTO Nº {{$data['id']}}</p><BR>
                        <p class="text-center "> <span class="font-weight-bold">  GRUPO DOMINARE</span><br>Rua Bárbara Steiw, 377 - Olarias, Ponta Grossa</p>
                    </td>
                </tr>
            </table>
            <table class="table table-print ">
                <tr>
                    <td class="text-center font-weight-bold">Identificação do Cliente</td>
                </tr>
            </table>
            <table class="table table-print ">
                <tr>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >CPF / CNPJ</label><br>
                        <p >{{ $data['cpf_cnpj'] }}</p>
                    </td>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Data Nascimento</label><br>
                        <p >{{ $data['data_nascimento_br'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Nome / Razao Social</label><br>
                        <p >{{ $data['nome_razaosocial'] }}</p>
                    </td>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >CEP</label><br>
                        <p >{{ $data['cep'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Logradouro</label><br>
                        <p >{{ $data['logradouro'] }}</p></td>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Localidade</label><br>
                        <p >{{ $data['localidade'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >UF</label><br>
                        <p >{{ $data['uf'] }}</p>
                    </td>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Bairro</label><br>
                        <p >{{ $data['bairro'] }}</p>
                    </td>

                </tr>
                <tr>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Numero</label><br>
                        <p >{{ $data['numero'] }}</p>
                    </td>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Complemento</label><br>
                        <p >{{ $data['complemento'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >E-mail</label><br>
                        <p >{{ $data['email'] }}</p>
                    </td>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Telefone</label><br>
                        <p >{{ $data['telefone'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Celular</label><br>
                        <p >{{ $data['celular'] }}</p>
                    </td>
                    <td  class="duas-colunas">
                        <label class="font-weight-bold" >Recado</label><br>
                        <p >{{ $data['recado'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="font-weight-bold" >Observações</label><br>
                        <p >{{ $data['observacoes'] }}</p>
                    </td>
                </tr>
            </table>
            <br>
            <table class="table table-print table-itens ">
                <tr>
                    <td colspan="4">
                        <p class="w-100  m-0 text-center font-weight-bold">Itens do Pedido</p>
                    </td>
                </tr>
                <tr>
                    <th scope="col" class="produto">Produto/Serviço</th>
                    <th scope="col" data-format="float" class="valores text-right">Quantidade</th>
                    <th scope="col" data-format="float" class="valores text-right" >Valor</th>
                    <th scope="col" data-format="float" class="valores text-right">Total</th>
                </tr>
                @foreach ($data['itens'] as $item)
                <tr>
                    <td>{{ $item['desc_produto'] }}</td>
                    <td class="text-right">{{ str_replace('.', ',',$item['quantidade']) }}</td>
                    <td class="text-right">{{ str_replace('.', ',',$item['valor']) }}</td>
                    <td class="text-right">{{ str_replace('.', ',',number_format(($item['quantidade'] * $item['valor']),2,'.','')) }}</td>
                </tr>
                @endforeach
            </table>
            <br>
            <table class="table table-print ">

                <tr>
                    <td  class="quatro-colunas">
                        <label class="font-weight-bold" >Valor</label>
                        <p >{{ str_replace('.', ',',$data['valor']) }}</p>
                    </td>
                    <td  class="quatro-colunas text-center">
                        <label class="font-weight-bold text-center" >Acréscimo</label>
                        <p class="text-center"> {{ str_replace('.', ',',$data['acrescimo']) }}</p>
                    </td>
                    <td  class="quatro-colunas  text-center">
                        <label class="font-weight-bold text-center" >Desconto</label>
                        <p class="text-center" >{{ str_replace('.', ',',$data['desconto']) }}</p>
                    </td>
                    <td  class="quatro-colunas text-right">
                        <label class="font-weight-bold" >Valor Total</label>
                        <p >{{ str_replace('.', ',',$data['valor_total']) }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"  class="duas-colunas text-center">
                        <label class="font-weight-bold" >Forma Pagamento</label>
                        <p > {{ $data['desc_forma_pagamento'] }}</p>
                    </td>
                    <td colspan="2"  class="duas-colunas text-center">
                        <label class="font-weight-bold" >Data Entrega</label>
                        <p > {{ $data['data_entrega_br'] }}</p>
                    </td>
                </tr>
            </table>
      </div>

</body>
</html>

<style>
    *{
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
    }
    
    .text-right{
        text-align: right;
    }
    .text-center{
        text-align: center;
    }
    .text-left{
        text-align: left;
    }
    .font-weight-bold{
        font-weight: bold;
    }
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #000;
        border-collapse: collapse !important;
    }

    .table th, .table td {
        padding: 0.25rem;
        vertical-align: top;
        border-top: 1px solid #000;
        
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #000;
    }

    .table tbody + tbody {
        border-top: 2px solid #000;
    }


    #printOrcamento {
        max-width: 794px;
        width: 100%;
        height: auto;
        padding: 40px;
    }


    .cabecalho-colunas{
        width: 70%;
    }
    .logo-coluna{
        width:30%
    }
    .quatro-colunas{
        width: 25%;
        padding: 0;
        margin: 0;
    }

    p, label{
        border: 0;
        margin: 0;
    }

    .table-print{
        border: 2px solid;
        padding: 0;
        margin: 2px;
    }
    
    *{
        line-height: 18px;
    }

    .table-print tr td, .table-print tr th{
        border: 1px solid #000;
        border-collapse: collapse;
    }

    .table-print-itens{
        border: 2px solid #000;
    }

    .produto{
        width: 40%;
    }

    .valores{
        width: 20%;
    }

    .table .duas-colunas{
        width: 50%;
    }
    #printOrcamento .row, #printOrcamento .row > div{
        padding: 0;
        margin: 0;
        border: 1px solid #000;
        border-collapse: collapse;
    }

    #printOrcamento .table-sm td, #printOrcamento .table-sm th{
        border-color: black !important;
    }

    
</style>
