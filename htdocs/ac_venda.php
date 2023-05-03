<?php
include "conexao.php";


if(isset($_POST['finalizar-compra'])){    
///// juntando os itens em n_compra 
    $resultado = mysqli_query($conexao, "SELECT n_venda  as numero_venda FROM tb_venda ORDER BY n_venda DESC LIMIT 1");
    $linha = mysqli_fetch_assoc($resultado);
    $numero_venda = $linha['numero_venda'];
    $numero_venda = $numero_venda +1;

 ///// inserir venda em tabela de venda finalizada
    $sql = "INSERT INTO tb_venda (id_produto, data, usuario, valor_unitario, n_venda)
    SELECT id_produto, data, usuario, valor_unitario, $numero_venda 
    FROM tb_temp";

        if(mysqli_query($conexao, $sql)){
///// diminuindo a qtd na tabela tb_produto de acordo com a quantidade da tabela tb_temp          
            $sql2="UPDATE tb_produto 
            SET quantidade = quantidade - (
                SELECT COUNT(a.id_produto)
                FROM tb_temp a
                WHERE a.id_produto = tb_produto.id_produto
            )
            WHERE id_produto IN (
                SELECT id_produto FROM tb_temp)";
            
            if(mysqli_query($conexao, $sql2)){
  ///// deletando tudo na tb temp           
                $sql3 = "DELETE FROM `tb_temp`";

                    if(mysqli_query($conexao, $sql3)){

                        header("Location:painel.php");
                    }
                    else{
                        header('Location:painel.php');
                    }
            }
            else{
                echo "erro ao realizar a venda";
            }

        }
        else{
            header('Location:painel.php');
        }

}


///// excluir a venda da tabela temporaria
elseif(!empty($_POST['excluir_produto']) && isset($_POST['excluir'])){

    $id_venda = $_POST['excluir_produto'];  
    

    $sql = "DELETE FROM `tb_temp` 
                    WHERE id_venda=$id_venda";

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