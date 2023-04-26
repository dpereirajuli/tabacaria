
<?php
include('verifica_login.php');
include('conexao.php');

if (isset($_POST['nome'])){
    $nome =  ($_POST['nome']);
    $nome_fantasia =  ($_POST['nome_fantasia']);
    $cnpj =  ($_POST['cnpj']);
    $cep =  ($_POST['cep']);
    $endereco =  ($_POST['rua']);
    $numero =  ($_POST['numero']);
    $bairro =  ($_POST['bairro']);
    $cidade =  ($_POST['cidade']);
    $estado =  ($_POST['uf']);
    $telefone =  ($_POST['telefone']);
    $email =  ($_POST['email']);
 
$sql = "INSERT INTO TB_FORNECEDORES (nome,nome_fantasia,cnpj,cep,endereco,numero,bairro,cidade,estado,telefone, email) 
        VALUES (UPPER('$nome'),UPPER('$nome_fantasia'),UPPER('$cnpj'),UPPER('$cep'),UPPER('$endereco'),UPPER('$numero'),UPPER('$bairro'),
        UPPER('$cidade'),UPPER('$estado'),UPPER('$telefone'),lower('$email'))";


    if(mysqli_query($conexao, $sql)){
        header("Location:painel.php");
        die();
    }


}
    
elseif(isset($_POST['excluir_produto'])){
    $id_fornecedor = $_POST['excluir_produto'];

    $sql = " DELETE FROM `TB_FORNECEDORES` WHERE id_fornecedor = $id_fornecedor ";
    mysqli_query($conexao, $sql);
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="fornecedor" value="fornecedor">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php


}
