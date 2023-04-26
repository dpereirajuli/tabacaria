<?php
include "conexao.php";

if(!empty($_POST['codigo_produto']) && $_POST['descricao_produto'] !="Produto não encontrado"){

    $codigo_produto = $_POST['codigo_produto'];
    $valor = $_POST['valor_produto'];
    $quantidade = $_POST['quantidade_produto'];
    
    

    $sql = "INSERT INTO tb_produto (descricao_produto, codigo_produto, categoria, valor_produto, quantidade_produto ) 
    VALUES (UPPER('$descricao_produto'), $codigo_produto, '$categoria', '$valor', $quantidade)";

    if(mysqli_query($conexao, $sql)){

        header("Location:painel.php");
    }
    else{
        header('Location:painel.php');
    }
}
else{
    header('Location:painel.php');
}
?>