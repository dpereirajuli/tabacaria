<?php

include('conexao.php');

///// quando inserir produto
if (isset($_POST['btn-cadastrar']) && !empty($_POST['descricao_produto'])){
    $descricao_produto =  ($_POST['descricao_produto']);
    $minimo =  ($_POST['minimo']);
    $valor_unitario =  ($_POST['valor_unitario']);
    $id_categoria =  ($_POST['id_categoria']);
    $quantidade =  ($_POST['quantidade']);

    if(empty($valor_unitario)){
        $valor_unitario=0;
    }
    if(empty($quantidade)){
        $quantidade=0;
    }
   
    ///////inserindo novo produto na tabela tb_produto
        $sql = "INSERT INTO TB_PRODUTO (descricao_produto,minimo, id_categoria, valor_unitario, quantidade) 
                VALUES (UPPER('$descricao_produto') , $minimo, $id_categoria,'$valor_unitario ', $quantidade)";

                if(mysqli_query($conexao, $sql)){

                    /// selecionando o produto criado acima
                    $sql2="SELECT * FROM `tb_produto` ORDER BY `id_produto` DESC LIMIT 1";
                    $result = mysqli_query($conexao,$sql2);
                    while($row = mysqli_fetch_assoc($result)){
                        $id_produto = $row['id_produto'];
                    }

                    /////criadno registro na tabela tb_entrada
                    date_default_timezone_set('America/Sao_Paulo');
                    $dataAtual = date("Y/m/d");
                    $usuario =  ($_POST['usuario']);
                    $sql3 = "INSERT INTO TB_ENTRADA (quantidade	, data_entrada , id_produto, usuario) 
                            VALUES ($quantidade,' $dataAtual', $id_produto , '$usuario')";
                            if(mysqli_query($conexao, $sql3)){
                                ?>
                                <form action="painel.php" method="post" id="myForm">
                                    <input type="hidden" name="produto" value="produto">
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

///// quando inserir quantidade de produto
if (isset($_POST['btn-inserir']) && !empty($_POST['quantidade']) && $_POST['descricao_produto'] != 'Produto não encontrado' ){
    $quantidade =  ($_POST['quantidade']);
    $codigo =  ($_POST['codigo']);
    $usuario =  ($_POST['usuario']);
    
///// adicionando a qtd + qtd digitada pelo usuario
    $sql="UPDATE TB_PRODUTO
    SET quantidade = quantidade + $quantidade
    WHERE id_produto = $codigo";

    if(mysqli_query($conexao, $sql)){
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date("Y/m/d");
        $sql2 = "INSERT INTO TB_ENTRADA (quantidade	, data_entrada , id_produto, usuario) 
                VALUES ($quantidade,' $dataAtual', $codigo , '$usuario')";
                   if(mysqli_query($conexao, $sql2)){
                    ?>
                    <form action="painel.php" method="post" id="myForm">
                        <input type="hidden" name="produto" value="produto">
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


///// excluir produto
elseif(isset($_POST['excluir_produto'])){
    $id_produto = $_POST['excluir_produto'];

    $sql = " DELETE FROM `TB_PRODUTO` WHERE id_produto = $id_produto ";
    mysqli_query($conexao, $sql);
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="produto" value="produto">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php

}

///// editar produto
elseif(isset($_POST['btn-atualizar'])){
    $id_produto = $_POST['id_produto'];
    $descricao_produto =  ($_POST['descricao_produto']);
    $minimo =  ($_POST['minimo']);
    $valor_unitario =  ($_POST['valor_unitario']);
    $id_categoria =  ($_POST['id_categoria']);

    if(empty($valor_unitario)){
        $valor_unitario=0;
    }
    if(empty($quantidade)){
        $quantidade=0;
    }

    $sql = "UPDATE `tb_produto` SET descricao_produto=UPPER('$descricao_produto'),valor_unitario='$valor_unitario', minimo = $minimo, id_categoria = $id_categoria
                                WHERE id_produto=$id_produto";
    mysqli_query($conexao, $sql);
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="produto" value="produto">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php

}


else{
    ?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="produto" value="produto">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
        <?php
}
