<?php

    include('conexao.php');

if (isset($_POST['id']) && isset($_POST['col']) && isset($_POST['value'])) {
    $id = $_POST['id'];
    $col = $_POST['col'];
    $value = $_POST['value'];

    // atualiza o registro correspondente no banco de dados
    $sql = "UPDATE tb_morador SET morador='$value' WHERE id='$id'";
    if(mysqli_query($conexao, $sql)){
      echo "Registro atualizado com sucesso!";
    } else {
      echo "Erro ao atualizar registro: " ;
    }
  } else {
    echo "Parâmetros inválidos.";
  }
