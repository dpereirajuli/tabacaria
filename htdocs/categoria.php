<?php
    
 if(isset($_POST['select-pesquisa'])){
    $select = $_POST['select-pesquisa'];
    $pesquisar = $_POST['pesquisa'];
    
    $sql = "SELECT * 
    FROM tb_categoria  
    WHERE $select 
    LIKE '%$pesquisar%'";
    $result = mysqli_query($conexao,$sql);
}

else{
    $sql="SELECT * 
            FROM tb_categoria  
            ORDER BY id_categoria ASC";
    $result = mysqli_query($conexao,$sql);
}

?>

<link rel="stylesheet" href="estoque.css">

<div class="container-fluid menu-cadastro">
    <h2>Consulta Unidades</h2>

        <div class="container-fluid menu-pesquisa">
            <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Pesquisa" name="pesquisa">

            <input type="hidden" name="unidade" value="unidade">

                <select class="form-select" name="select-pesquisa">
                    <option value="id_unidade" selected>ID</option>
                    <option value="descricao">DESCRIÇÃO</option>
                    <option value="unidade">UNIDADE</option>
                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>

        <div class="div-tabela">
            <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th style="width:05%" scope="col">ID</th>
                        <th style="width:05%" scope="col">DESCRIÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($result) && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                $id_categoria = $row['id_categoria'];
                                $descricao_categoria = $row['descricao_categoria'];
                        ?>
                                <td>  <?php echo $id_categoria;  ?> </td>
                                <td>  <?php echo $descricao_categoria;  ?> </td>
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