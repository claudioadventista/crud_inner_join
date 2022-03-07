<?php

require_once 'conexao.php';
   // Página index.php, Campo - Digite para buscar o cadastro
   if(isset($_GET['busca'])){
      $busca = $_GET['busca'];
      // Preenche o formulário de alteração
      $sql = mysqli_query(
         $conexao,"SELECT cadastro.id, 
         cadastro.ordem_servico cadastro_ordem, 
         cadastro.defeitoReclamado cadastro_defeitoReclamado,
         cadastro.dataEntrada cadastro_dataEntrada,
         cadastro.dataPronto cadastro_dataPronto,
         cadastro.dataSaida cadastro_dataSaida,
         cadastro.material cadastro_material,
         cadastro.obs cadastro_obs,
         cadastro.orcamento cadastro_orcamento,
         cadastro.acessorio cadastro_acessorio,
         cadastro.modelo cadastro_modelo,
         cadastro.numeroSerie cadastro_numeroSerie,
         cadastro.barra cadastro_barra,
         cliente.id cliente_id, 
         cliente.nome cliente_nome,
         cliente.telefone cliente_telefone,
         cliente.telefone2 cliente_telefone2,
         cliente.cpf cliente_cpf,
         cliente.endereco cliente_endereco,
         cliente.dataNascimento cliente_dataNascimento,
         cliente.dataCadastro cliente_dataCadastro,
         cliente.email cliente_email,
         cliente.barra cliente_barra,
         aparelho.id aparelho_id,
         aparelho.nome_aparelho aparelho_nome,
         marca.id marca_id,
         marca.nome_marca marca_nome,
         estado.id estado_id,
         estado.nome_estado estado_nome,
         defeito.id defeito_id,
         defeito.nome_defeito defeito_nome
         FROM cadastro cadastro 
         INNER JOIN cliente cliente ON cadastro.id_cliente = cliente.id 
         INNER JOIN aparelho aparelho ON cadastro.id_aparelho = aparelho.id 
         INNER JOIN marca marca ON cadastro.id_marca = marca.id
         INNER JOIN estado estado ON cadastro.id_estado = estado.id
         INNER JOIN defeito defeito ON cadastro.id_defeito = defeito.id  
         WHERE cadastro.id = '$busca' OR cadastro.barra = '$busca' OR cadastro.ordem_servico = '$busca'");


      $tot = mysqli_num_rows($sql);
      $cadastro = mysqli_fetch_array($sql);
      if($tot == 0){
         echo json_encode("zero");
      }else if($tot > 1){
         echo json_encode("mais_de_um");
         exit;
      }else{
         echo json_encode($cadastro);
      };
   };

    // Página index.php, Campo - Digite para buscar o cadastro
   if(isset($_GET['buscaCadastro'])){
      $busca = $_GET['buscaCadastro'];
      //$sql =  mysqli_query($conexao,"SELECT * FROM cadastro WHERE id = '$busca' OR barra = '$busca'");
      
      $sql = mysqli_query(
         $conexao,"SELECT cadastro.id, 
         cadastro.ordem_servico cadastro_ordem, 
         cadastro.dataEntrada cadastro_dataEntrada,
         cadastro.dataPronto cadastro_dataPronto,
         cadastro.dataSaida cadastro_dataSaida,
         cadastro.material cadastro_material,
         cadastro.obs cadastro_obs,
         cadastro.orcamento cadastro_orcamento,
         cadastro.acessorio cadastro_acessorio,
         cadastro.modelo cadastro_modelo,
         cadastro.numeroSerie cadastro_numeroSerie,
         cadastro.barra cadastro_barra,
         cliente.id cliente_id, 
         cliente.nome cliente_nome,
         cliente.telefone cliente_telefone,
         cliente.telefone2 cliente_telefone2,
         cliente.cpf cliente_cpf,
         cliente.endereco cliente_endereco,
         cliente.dataNascimento cliente_dataNascimento,
         cliente.dataCadastro cliente_dataCadastro,
         cliente.email cliente_email,
         cliente.barra cliente_barra,
         aparelho.id aparelho_id,
         aparelho.nome_aparelho aparelho_nome,
         marca.id marca_id,
         defeito.id defeito_id,
         marca.nome_marca marca_nome
         FROM cadastro cadastro 
         INNER JOIN cliente cliente ON cadastro.id_cliente = cliente.id 
         INNER JOIN aparelho aparelho ON cadastro.id_aparelho = aparelho.id 
         INNER JOIN marca marca ON cadastro.id_marca = marca.id
         INNER JOIN defeito defeito ON cadastro.id_defeito = defeito.id
         WHERE cadastro.id = '$busca' ");


      $tot = mysqli_num_rows($sql);
      $cadastro = mysqli_fetch_array($sql);
      if($tot == 0){
         echo json_encode("zero");
      }else{
         echo json_encode($cadastro);
      };
   };


   // seleção do cliente
   if(isset($_GET['cliente'])){
      $busca = $_GET['cliente'];
      $sql = mysqli_query($conexao,"SELECT * FROM cliente WHERE  id = '$busca'");
      $tot = mysqli_num_rows($sql);
      $buscaCliente = mysqli_fetch_array($sql);
         echo json_encode($buscaCliente);

   }
   if(isset($_GET['verifica'])){
      $busca = $_GET['verifica'];
     
      $query =  mysqli_query($conexao,"SELECT * FROM cliente WHERE nome = '$busca' OR cpf = '$busca' OR barra = '$busca' OR telefone = '$busca' OR email = '$busca' ");	
      $total = mysqli_num_rows($query);
      $linha = mysqli_fetch_array($query);
      if($total == 0){
         echo json_encode("zero");
      }else if($total >1){
         echo json_encode("Duplicado");
      }else{
         echo json_encode($linha);
      }
   }
   // pagina duplicados, verifica cpf digitado no formulário de alteração
   if(isset($_GET['buscaCad'])){
      $busca = $_GET['buscaCad'];
        $sql = mysqli_query($conexao,"SELECT *  FROM cliente WHERE  cpf = '$busca' ");     
        $num = mysqli_num_rows($sql);
        $buscaCpf = mysqli_fetch_array($sql);
        if($num == 0){
             echo json_encode($buscaCpf);
      
        }else{
            echo json_encode("CPF já é cadastrado");
        };
   };

   if(isset($_GET['buscaCPF'])){
      $busca = $_GET['buscaCPF'];
     
      $query =  mysqli_query($conexao,"SELECT * FROM cliente WHERE cpf = '$busca' ");	
      $total = mysqli_num_rows($query);
      $linha = mysqli_fetch_array($query);
      if($total >1){
         echo json_encode("Duplicado");
      }else if($total ==0){
         echo json_encode("zero");
      }else{
         echo json_encode($linha);
      }
   }
?>