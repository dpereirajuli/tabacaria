
<?php
include('conexao.php');

if (isset($_POST['btn-cadastrar']) && !empty($_POST['descricao_categoria'])){
    $descricao_categoria =  ($_POST['descricao_categoria']);
 
    $sql = "INSERT INTO tb_categoria (descricao_categoria) 
            VALUES (UPPER('$descricao_categoria'))";

    if(mysqli_query($conexao, $sql)){
        header("Location:painel.php");
        die();
    }

}
    

elseif(isset($_POST['excluir_produto'])){
    $id_cliente = $_POST['excluir_produto'];

    $sql = " DELETE FROM `TB_CLIENTE` WHERE id_cliente = $id_cliente ";
    mysqli_query($conexao, $sql);
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="cliente" value="cliente">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php


}



