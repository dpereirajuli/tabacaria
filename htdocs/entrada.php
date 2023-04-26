<?php


    
 if(isset($_POST['select-pesquisa'])){
    $select = $_POST['select-pesquisa'];
    $pesquisar = $_POST['pesquisa'];
    
    $sql = "SELECT * 
    FROM TB_CLIENTE  
    WHERE $select 
    LIKE '%$pesquisar%'";
    $result = mysqli_query($conexao,$sql);
}

else{
    $sql="SELECT a.id_entrada,
                a.quantidade,
                a.data_entrada,
                a.usuario,
                a.id_produto,
                b.descricao_produto
            FROM tb_entrada a,
            tb_produto b
            WHERE a.id_produto=b.id_produto
            ORDER BY id_entrada ASC";
    $result = mysqli_query($conexao,$sql);
}

?>

<link rel="stylesheet" href="estoque.css">

<div class="container-fluid menu-cadastro">
    <h2>Entrada de produtos</h2>

        <div class="container-fluid menu-pesquisa">
            <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Pesquisa" name="pesquisa">

            <input type="hidden" name="cliente" value="cliente">

                <select class="form-select" name="select-pesquisa">
                    <option value="id_cliente" selected>ID</option>
                    <option value="nome">NOME</option>
                    <option value="cnpj">CNPJ</option>
                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>

        <div class="div-tabela">
            <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th style="width:05%" scope="col">DATA</th>
                        <th style="width:05%" scope="col">QTD</th>
                        <th style="width:05%" scope="col">PRODUTO</th>
                        <th style="width:05%" scope="col">USUARIO</th>
                        <th style="width:01%" scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($result) && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                $id_entrada = $row['id_entrada'];
                                $quantidade = $row['quantidade'];
                                $data_entrada = $row['data_entrada'];
                                $usuario = $row['usuario'];
                                $descricao_produto = $row['descricao_produto'];
                                $id_produto = $row['id_produto'];

                        ?>
                                <td>  <?php echo $data_entrada;  ?> </td>
                                <td>  <?php echo $quantidade;  ?> </td>
                                <td>  <?php echo $descricao_produto;  ?> </td>
                                <td>  <?php echo $usuario;  ?> </td>
                                  <td> 
                                    <form action="ac_entrada.php" method="post">
                                    <input type="hidden" name="id_entrada" value="<?php echo $id_entrada; ?>"> 
                                    <input type="hidden" name="quantidade" value="<?php echo $quantidade; ?>"> 
                                    <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>"> 
                                        <button type="submit" class="btn btn-danger btn-sm" name="excluir-entrada">EXCLUIR</button>
                                    </form> 
                                </td>
                    </tr>
                        <?php
                        }
                            }
                        else{
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
       
    
</div>