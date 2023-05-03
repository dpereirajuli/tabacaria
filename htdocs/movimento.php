<?php
    
 if(isset($_POST['select-pesquisa'])){
    $select = $_POST['select-pesquisa'];
    $pesquisar = $_POST['pesquisa'];
    
    $sql="SELECT a.id,
    a.descricao,
    b.tipo
    FROM `tb_tpmovimento` a,
    tb_tipo b
    WHERE a.tipo=b.id
    AND a.$select LIKE '%$pesquisar%' ";
    $result = mysqli_query($conexao,$sql);


}

else{
    $sql="SELECT  A.id, A.descricao, B.tipo
            FROM TB_TPMOVIMENTO  A,
                 TB_TIPO B
            WHERE A.tipo = B.id  
            ORDER BY id ASC";
    $result = mysqli_query($conexao,$sql);
}

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<link rel="stylesheet" href="estoque.css">

<div class="container-fluid menu-cadastro">
    <h2>Consulta Movimentos</h2>

        <div class="container-fluid menu-pesquisa">
            <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Pesquisa" name="pesquisa">

            <input type="hidden" name="movimento" value="movimento">

                <select class="form-select" name="select-pesquisa">
                    <option value="id" selected>ID</option>
                    <option value="descricao">DESCRIÇÃO</option>
                    <option value="tipo">TIPO</option>
                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>

        <div class="div-tabela"  id="tabela">
            <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th style="width:05%" scope="col">ID</th>
                        <th style="width:05%" scope="col">DESCRIÇÃO</th>
                        <th style="width:05%" scope="col">TIPO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($result) && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                $id_movimento = $row['id'];
                                $descricao = $row['descricao'];
                                $tipo = $row['tipo'];
                        ?>
                                <td>  <?php echo $id_movimento;  ?> </td>
                                <td>  <?php echo $descricao;  ?> </td>
                                <td>  <?php echo $tipo;  ?> </td>
                    </tr>
                        <?php
                        }
                            }
                        else{
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
</div>