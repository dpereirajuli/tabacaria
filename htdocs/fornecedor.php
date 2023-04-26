<?php
    
 if(isset($_POST['select-pesquisa'])){
    $select = $_POST['select-pesquisa'];
    $pesquisar = $_POST['pesquisa'];
    
    $sql = "SELECT * 
    FROM TB_FORNECEDORES  
    WHERE $select 
    LIKE '%$pesquisar%'";
    $result = mysqli_query($conexao,$sql);
}

else{
    $sql="SELECT * 
            FROM TB_FORNECEDORES  
            ORDER BY nome ASC";
    $result = mysqli_query($conexao,$sql);
}

?>

<link rel="stylesheet" href="estoque.css">

<div class="container-fluid menu-cadastro">
    <h2>Consulta Fornecedor</h2>

        <div class="container-fluid menu-pesquisa">
            <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Pesquisa" name="pesquisa">

            <input type="hidden" name="fornecedor" value="fornecedor">

                <select class="form-select" name="select-pesquisa">
                    <option value="id_fornecedor" selected>ID</option>
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
                        <th style="width:05%" scope="col">ID</th>
                        <th style="width:05%" scope="col">NOME</th>
                        <th style="width:05%" scope="col">CNPJ</th>
                        <th style="width:05%" scope="col">TELEFONE</th>
                        <th style="width:05%" scope="col">EMAIL</th>
                        <th style="width:01%" scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($result) && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                $id_fornecedor = $row['id_fornecedor'];
                                $nome = $row['nome'];
                                $cnpj = $row['cnpj'];
                                $telefone = $row['telefone'];
                                $email = $row['email'];

                        ?>
                                <td>  <?php echo $id_fornecedor;  ?> </td>
                                <td>  <?php echo $nome;  ?> </td>
                                <td>  <?php echo $cnpj;  ?> </td>
                                <td>  <?php echo $telefone;  ?> </td>
                                <td>  <?php echo $email;  ?> </td>
                                <td> 
                                    <form action="ac_fornecedor.php" method="post">
                                    <input type="hidden" name="excluir_produto" value="<?php echo $id_fornecedor; ?>"> 
                                    <button type="submit" class="btn btn-danger btn-sm">EXCLUIR</button>
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
                            echo "<td>-</td>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
       
    
</div>