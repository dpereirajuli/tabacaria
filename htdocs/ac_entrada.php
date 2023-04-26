<?php

include('conexao.php');

///// quando inserir produto
if (isset($_POST['excluir-entrada']) && !empty($_POST['id_entrada'])){
    $id_entrada =  ($_POST['id_entrada']);
    $id_produto =  ($_POST['id_produto']);
    $quantidade =  ($_POST['quantidade']);
  
        $sql = "DELETE FROM `tb_entrada` WHERE id_entrada=$id_entrada"; 
        if(mysqli_query($conexao, $sql)){
            $sql2="UPDATE TB_PRODUTO
            SET quantidade = quantidade - $quantidade
            WHERE id_produto = $id_produto";

            if(mysqli_query($conexao, $sql2)){
            ?>
            <form action="painel.php" method="post" id="myForm">
                <input type="hidden" name="entrada" value="entrada">
            </form>

            <script>
            window.onload = function() {
                document.getElementById("myForm").submit();
            };
            </script>
            <?php
            }
        }

        else{
                echo "erro ao cadastrar produto";
            }
}
