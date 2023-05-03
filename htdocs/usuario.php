<?php
    
 if(isset($_POST['select-pesquisa'])){
    $select = $_POST['select-pesquisa'];
    $pesquisar = $_POST['pesquisa'];
    
    $sql = "SELECT * 
    FROM TB_USUARIO  
    WHERE $select 
    LIKE '%$pesquisar%'";
    $result = mysqli_query($conexao,$sql);
}

else{
    $sql="SELECT * 
            FROM TB_USUARIO  
            ORDER BY id_usuario ASC";
    $result = mysqli_query($conexao,$sql);
}

?>

<link rel="stylesheet" href="estoque.css">

<div class="container-fluid menu-cadastro">
    <h2>Consulta Usuários</h2>

        <div class="container-fluid menu-pesquisa">
            <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Pesquisa" name="pesquisa">

            <input type="hidden" name="usuario" value="usuario">

                <select class="form-select" name="select-pesquisa">
                    <option value="id_usuario" selected>ID</option>
                    <option value="usuario">USUÁRIO</option>    
                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>

        <div class="div-tabela">
            <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th style="width:01%" scope="col">ID</th>
                        <th style="width:30%" scope="col">USUÁRIO</th>
                        <th style="width:20%" scope="col">SENHA</th>
                        <th style="width:02%" scope="col">NIVEL</th>
                        <th style="width:01%" scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($result) && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                $id_usuario = $row['id_usuario'];
                                $usuario = $row['usuario'];
                                $senha = $row['senha'];
                                $nivel = $row['nivel'];
                        ?>
                                <td>  <?php echo $id_usuario;  ?> </td>
                                <td>  <?php echo $usuario;  ?> </td>
                                <td>  <?php echo $senha;  ?> </td>
                                <td>  <?php echo $nivel;  ?> </td>
                                <td> 
                                    <form action="ac_usuario.php" method="post">
                                    <input type="hidden" name="excluir_produto" value="<?php echo $id_usuario; ?>"> 
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