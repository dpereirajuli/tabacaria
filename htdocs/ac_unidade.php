
<?php

include('conexao.php');

if (isset($_POST['unidade'])):
    
    $descricao =  ($_POST['descricao']);
    $unidade =  ($_POST['unidade']);
  
    
 
$sql = "INSERT INTO TB_UNIDADE (descricao, unidade) 
        VALUES (UPPER('$descricao'), UPPER('$unidade'))";
if(mysqli_query($conexao, $sql)):
    header("Location:painel.php");
    die();
    
else:
       header('Location:painel.php');
       die();
endif;

    
endif;

