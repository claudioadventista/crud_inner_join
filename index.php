<?php

require_once 'conexao.php';

   $query = mysqli_query(
   $conexao,"SELECT 
   cadastro.id, 
   cadastro.ordem_servico cadastro_ordem, 
   cadastro.barra cadastro_barra, 
   cliente.id cliente_id, 
   cliente.nome cliente_nome, 
   cliente.telefone cliente_telefone, 
   cliente.cpf cliente_cpf, 
   aparelho.nome_aparelho aparelho_nome,
   marca.nome_marca marca_nome,
   estado.nome_estado estado_nome
   FROM cadastro cadastro 
   INNER JOIN cliente cliente ON cadastro.id_cliente = cliente.id 
   INNER JOIN aparelho aparelho ON cadastro.id_aparelho = aparelho.id 
   INNER JOIN marca marca ON cadastro.id_marca = marca.id 
   INNER JOIN estado estado ON cadastro.id_estado = estado.id
   WHERE cadastro.excluir='' AND cliente.excluir=''
   ORDER BY cadastro.id ASC");
  

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>CRUD_inner_join_json </title>
    
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="referrer" content="default" id="meta_referrer" />
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Mon, 22 Jul 2002 11:12:01 GMT">
<link rel="stylesheet" type="text/css" href="estilo.css" />
</head>
<body>
    <div class="container">
        <div id="pesquisa" class="pesquisa">
            <b>Digite o nome, cpf, telefone, email ou codigo de barra </b>
            
            <!-- primeiro formulário de pesquisa --> 
            <form id="formulario" name="frmEnviaDados" class="form-horizontal" action="busca.php"  method="post">
                <input id="cpf" type="text" name="busca" placeholder="Digite aqui para novo cadastro" autocomplete="off" onkeyup="verificar()">
                <input  id="verifica" class="botao cadastro" type="submit" value="verificar" onclick="return buscar()">
                <a href="duplicado.php" class="botao but-azul" > página cliente </a>
                
            </form>
        
             <span class="texto">Digite para buscar o cadastro</span>
            <form id="buscaCadastro" name="frmEnviaDados" class="form-horizontal" action="busca.php"  method="post">
                <input id="buscaCad" type="text" name="buscaCad" placeholder="Digite o id ou codigo de barra" autocomplete="off" />
                <input  id="buscar" class="botao but-azul" type="submit" value="buscar" onclick="buscaNoBanco3();  return false;"> 
            </form>
        </div> 

        <?php
            require_once'formulario.php';
        ?>
        <div id="tabela_exibicao">
            <div class="titulo">todos os cadastros</div>
            <table class="tabela_menus" border="1" style="border-collapse: collapse" cellpadding="2" cellspacing="0">
                <thead>
                    <tr>
                        <th class="tabela1">
                            Tab cadastro
                        </th>
                        <th  class="tabela1">
                            
                        </th>
                        <th  class="tabela1">
                            
                        </th>
                        <th  class="tabela2">
                            Tab cliente
                        </th>
                        <th  class="tabela2">
                            
                        </th>
                        <th  class="tabela2">
                            
                        </th>	
                        <th  class="tabela3">
                            Tab aparelho
                        </th>
                        <th  class="tabela4">
                            Tab marca
                        </th>
                        <th  class="tabela5">
                            Tab estado
                        </th>
                        <th  class="funcoes">
                        
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela1">
                            ID cadastro
                        </th>
                        <th  class="tabela1">
                            O. S. cadastro
                        </th>
                        <th  class="tabela1">
                            Barra cadastro
                        </th>
                        <th  class="tabela2">
                            Nome cliente
                        </th>
                        <th  class="tabela2">
                            Telefone cliente
                        </th>
                        <th  class="tabela2">
                            CPF cliente
                        </th>	
                        <th  class="tabela3">
                            nome do Aparelho
                        </th>
                        <th  class="tabela4">
                            nome da Marca
                        </th>
                        <th  class="tabela5">
                            nome do Estado
                        </th>
                        <th class="funcoes">
                            Funções<br>
                        </th>
                    </tr>
                </thead>  
                <tbody>
                    <?php
                    while ($categoria = mysqli_fetch_array($query,MYSQLI_ASSOC)) {; ?>
                        <tr>
                            <td class="td tdCenter"><?php echo $categoria['id']; ?></td>
                            <td class="tdCenter"><?php echo $categoria['cadastro_ordem']; ?></td>
                            <td class="tdCenter"><?php echo $categoria['cadastro_barra']; ?></td>
                            <td><?php echo $categoria['cliente_nome']; ?></td>
                            <td><?php echo $categoria['cliente_telefone']; ?></td>
                            <td><?php echo $categoria['cliente_cpf']; ?></td>
                            <td><?php echo $categoria['aparelho_nome']; ?></td>
                            <td><?php echo $categoria['marca_nome']; ?></td>
                            <td><?php echo $categoria['estado_nome']; ?></td>
                            <td >
                                <span class="botao but-azul" onclick="buscaCad.value='<?php echo $categoria['id']; ?>'; desabilitaCampos(); buscaNoBanco3()" >alt</span>
                                <a href="excluir_cadastro.php?codigo=<?= $categoria['id']; ?>" class="botao but-vermelho"  OnClick="return confirm('Confirma Exclusão da OS <?php echo $categoria['cadastro_ordem']; ?>' +'\n'+'<?php echo $categoria['cliente_nome']; ?>')" >exc</a>
                            </td>
                        </tr>
                    <?php };?>
                </tbody>
            </table>
        </div>            
    </div>
    <?php
        require_once 'js.php';
    ?>
    <script>

        // Valida o cpf digitado na entrada
        function verificar(){
            let cpf =  document.getElementById('cpf');
            // conta o número de caracteres até chegar o valor para fazer a validação
            if(cpf.value.length < 3 || cpf.value.trim() ==''){
                    document.getElementById("verifica").style.visibility="hidden";
            } else {
                    document.getElementById("verifica").style.visibility="visible";
            }
                if(cpf.value.length == 11){
                    // verifica se todos os caracers do campo são números
                    if (!isNaN(cpf.value)){
                        // faz a validação
                        var resultado = isValidCPF(cpf.value);
                        // mostra o resultado
                        if(resultado ===true){  
                            cpf2.value = cpf.value;
                            //cpf2.disabled = "true";
                            buscaNoBanco();
                        }else{
                            cpf.style.background = "#f00";
                            cpf.style.color ="#fff";     
                        } 
                    }
                }else{
                    cpf.style.background = "#fff";
                    cpf.style.color ="#000";
            }
        }; 

        // Chama essa função quando clica no botão VERIFICAR
        function buscar(){
            // retira os espaços da string com a função trim(), e conta os caracteres que sobrarem
            var buscar =  document.getElementById('cpf').value.trim();
            if(buscar.length < 3){
                cpf.value = buscar; 
                cpf.focus();
                alert("Digite pelo menos três caracteres para pesquisar");
                return false;
            };
                buscaNoBanco();
                return false;
        };

        // Campo - Digite o nome, cpf, telefone, email ou codigo de barra
        // verifica no banco, se o cpf, ou o nome, ou o código de barras digitado 
        // na entrada já foi cadastrado.
        function buscaNoBanco(){
            let texto = document.getElementById('cpf').value;
            fetch('http://localhost:80/inner_join_mysql_tres_tabelas/buscaCadastro.php?verifica=' + texto)
            .then(response => {// retorna a requisição fetch
                if (response.ok) {// se reornar ok
                return response.json();// converte num objeto json
                }
            })

            .then(json => {
                if(json == "Duplicado"){
                    alert(json);
                }

                if(json == "zero"){
                    pesquisa.style.display="none";
                    tabela_exibicao.style.display="none";
                    submitCadastro.value ="NOVO";
                    document.getElementById("form-cadastro").innerHTML="novo cadastro";
                    div_formulario.style.display="block";
                    cpf.disabled = "true";
                    botaoExcluir.style.visibility="hidden";
                    document.getElementById('verifica').style.visibility="hidden";
                }
            
                if(json.nome == texto || json.cpf == texto || json.telefone == texto || json.barra == texto){
                    pesquisa.style.display="none";
                    tabela_exibicao.style.display="none";
                    submitCadastro.value ="EXISTENTE";
                    document.getElementById("form-cadastro").innerHTML="novo cadastro existente";
                    div_formulario.style.display="block";
                    botaoExcluir.style.visibility="hidden";
                    id_cliente.value = json.id;
                    cpf2.value = json.cpf;
                    barraCliente.value = json.barra;
                    telefone.value = json.telefone;
                    telefone2.value = json.telefone2;
                    nome.value = json.nome;
                    email.value = json.email;
                    endereco.value = json.endereco;
                    dtCadCliente.value = json.dataCadastro;
                    dtNascimento.value = json.dataNascimento;
                    desabilitaExistente();
                    verifica.style.visibility="hidden";
                } 
            })

            .catch(error => {
                document.getElementById('verifica').style.visibility="hidden";
                
            });   
        };

            // Valida o cpf digitado no formulário 
            function verificar2(){
                let cpf2 =  document.getElementById('cpf2');  
                if(cpf2.value.length >0){
                    submitCadastro.disabled ="true";
                    submitCadastro.style.background ="#f1f1f1";
                    submitCadastro.style.color ="#aaa";
                    submitCadastro.style.borderColor ="#aaa";
                    submitCadastro.style.cursor ="default";

                    if(cpf2.value.length == 11){
                        // verifica se todos os caracers do campo são números
                        if (!isNaN(cpf2.value)){
                            // faz a validação
                            var resultado2 = isValidCPF(cpf2.value);
                            // mostra o resultado
                            if(resultado2 ===true){
                                buscaNoBanco2();
                            }else{
                                cpf2.style.background = "#f00";
                                cpf2.style.color ="#fff";           
                            } 
                        }
                    }else{
                        cpf2.style.background = "#fff";
                        cpf2.style.color ="#000";
                    };
                }else{
                    submitCadastro.disabled ="";
                    submitCadastro.style.background ="lightgreen";
                    submitCadastro.style.color ="#000";
                    submitCadastro.style.borderColor ="#999";
                    submitCadastro.style.cursor ="pointer";
                }
            };

             
            // Verifica no banco, se o cpf válido digitado no formuário já esta cadastrado
            function buscaNoBanco2(){
                let texto2 = document.getElementById('cpf2').value;
                fetch('http://localhost:80/inner_join_mysql_tres_tabelas/buscaCadastro.php?buscaCPF=' + texto2)
                .then(response => {// retorna a requisição fetch
                    if (response.ok) {// se reornar ok
                    return response.json();// converte num objeto json
                    }
                })

                .then(json => {
                    if(json.cpf == texto2){
                        alert("CPF já cadastrado");
                    };
                    if(json == "zero"){
                        submitCadastro.disabled ="";
                        submitCadastro.style.background ="lightgreen";
                        submitCadastro.style.color ="#000";
                        submitCadastro.style.borderColor ="#999";
                        submitCadastro.style.cursor ="pointer"; 
                    };
                })

                .catch(error => {
                    alet("Erro ao consultar o cpf no banco");
                }); 
            };// fim da função buscar banco

    </script>
</body>
</html>
           



