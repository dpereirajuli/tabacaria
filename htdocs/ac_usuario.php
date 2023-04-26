<?php
include "conexao.php";

if(!empty($_POST['nome']) && ($_POST['sobrenome']) && ($_POST['senha']) && ($_POST['nivel'])){

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];
    $primeiro = substr($nome, 0, 3); 
    $ultimo = substr($sobrenome, 0, 3); 
    $usuario = $primeiro.$ultimo;
    

    $sql = "INSERT INTO tb_usuario (usuario, senha, nivel) 
    VALUES (UPPER('$usuario'), '$senha', '$nivel')";
    echo $sql;

    if(mysqli_query($conexao, $sql)){

        header("Location:painel.php");
    }
    else{
        header('Location:painel.php');
    }
}


elseif(isset($_POST['excluir_produto'])){
    $id_usuario = $_POST['excluir_produto'];

    $sql = " DELETE FROM `tb_usuario` WHERE id_usuario = $id_usuario ";
    mysqli_query($conexao, $sql);
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="usuario" value="usuario">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php


}

