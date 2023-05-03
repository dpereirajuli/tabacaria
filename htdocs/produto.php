<?php
////usuario logado
$usuario = $_SESSION['usuario'];
    
 if(isset($_POST['select-pesquisa'])){
    $select = $_POST['select-pesquisa'];
    $pesquisar = $_POST['pesquisa'];
    
    $sql = "SELECT a.id_produto,
                    a.descricao_produto,
                    a.minimo,
                    a.quantidade,
                    b.descricao_categoria
                FROM tb_produto a,
                tb_categoria b
                WHERE a.id_categoria=b.id_categoria
                AND $select 
                LIKE '%$pesquisar%'";
    $result = mysqli_query($conexao,$sql);
}

else{
    $sql="SELECT a.id_produto,
                a.descricao_produto,
                a.minimo,
                a.quantidade,
                b.descricao_categoria
            FROM tb_produto a,
            tb_categoria b
            WHERE a.id_categoria=b.id_categoria 
            ORDER BY a.id_produto ASC";
    $result = mysqli_query($conexao,$sql);
}


////form para entrada do produto clicado
if(isset($_POST['btn-entrada'])){

    $entrada_produto = $_POST['entrada_produto'];
?>
    <script>
        $(document).ready(function(){
        $('#entrada').offcanvas('show');
        });
    </script>
<?php
}

////form para editar produto clicado

if(isset($_POST['editar-produto'])){
    $id_produto = $_POST['editar-produto'];
    $sql2 = "SELECT a.id_produto,
                    a.descricao_produto,
                    a.minimo,
                    a.valor_unitario,
                    a.id_categoria,
                    b.descricao_categoria
                FROM tb_produto a,
                tb_categoria b
                WHERE a.id_categoria = b.id_categoria
                AND  id_produto = $id_produto";
    $result2 = mysqli_query($conexao,$sql2);
    while($row2 = mysqli_fetch_assoc($result2)){
        $id_produto2 = $row2['id_produto'];
        $descricao_produto2 = $row2['descricao_produto'];
        $minimo2 = $row2['minimo'];
        $id_categoria2 = $row2['id_categoria'];
        $descricao_categoria2 = $row2['descricao_categoria'];
        $valor_unitario2 = $row2['valor_unitario'];
    }

?>
    <script>
        $(document).ready(function(){
        $('#editar').offcanvas('show');
        });
    </script>
<?php
}

?>

<link rel="stylesheet" href="estoque.css">


<!---------inserir descrição de acordo com o produto que for clicado para dar entrada---------->
<script type='text/javascript'>
			$(document).ready(function(){
				$("input[name='codigo']").blur(function(){
					var $descricao_produto = $("input[name='descricao_produto']");
                    var $valor = $("input[name='valor_unitario']");
					$.getJSON('function.php',{ 
						codigo: $( this ).val() 
                        
					},function( json ){
						$descricao_produto.val( json.descricao_produto );
                        $unidade.val( json.unidade );
					});
				});
			});
</script>



<div class="container-fluid menu-cadastro">
    <h2>Consulta Produtos</h2>

        <div class="container-fluid menu-pesquisa">
            <form action="#" method="post">
                <input type="text" class="form-control" placeholder="Pesquisa" name="pesquisa">

                <input type="hidden" name="produto" value="produto">

                    <select class="form-select" name="select-pesquisa">
                        <option value="id_produto" selected>ID</option>
                        <option value="descricao_categoria">DESCRIÇÃO</option>
                        <option value="categoria">CATEGORIA</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>

        <div class="div-tabela">
            <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th style="width:01%" scope="col">ID</th>
                        <th style="width:20%" scope="col">DESCRIÇÃO</th>
                        <th style="width:03%" scope="col">MIN</th>
                        <th style="width:05%" scope="col">CATEGORIA</th>
                        <th style="width:02%" scope="col">QTD</th>
                        <th style="width:01%" scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($result) && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                $id_produto = $row['id_produto'];
                                $descricao_produto = $row['descricao_produto'];
                                $minimo = $row['minimo'];
                                $descricao_categoria = $row['descricao_categoria'];
                                $quantidade = $row['quantidade'];
                        ?>
                                <td>  <?php echo $id_produto;  ?> </td>
                                <td>  <?php echo $descricao_produto;  ?> </td>
                                <td>  <?php echo $minimo;  ?> </td>
                                <td>  <?php echo $descricao_categoria;  ?> </td>
                                <td>  <?php echo $quantidade;  ?> </td>
                                <td class="td-produto-linha"> 
                                    <form action="ac_produto.php" method="post">
                                        <input type="hidden" name="excluir_produto" value="<?php echo $id_produto; ?>"> 
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form> 
                                    <form action="#" method="post">
                                        <input type="hidden" name="produto" value="produto">
                                        <input type="hidden" name="editar-produto" value="<?php echo $id_produto; ?>"> 
                                        <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                                    </form> 
                                    <form action="painel.php" method="post">
                                        <input type="hidden" name="produto" value="produto"> 
                                        <input type="hidden" name="entrada_produto" value="<?php echo $id_produto; ?>"> 
                                        <button type="submit" class="btn btn-success btn-sm" name="btn-entrada">Entrada</button>
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




<!---------inserir qtde produto---------->

<div class="offcanvas offcanvas-end" tabindex="-1" id="entrada" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Inseri entrada de produto</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
      <form action="ac_produto.php" method="post">
            <div class="col">
            <div class="col">
                        <p>Código do Produto</p>
                        <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
                        <input type="number" class="form-control" name="codigo" value="<?php echo $entrada_produto; ?>">
                    </div>
                    <br>
                    <div class="col">
                        <p>Descrição produto</p>
                        <input type="text" readonly class="form-control" name="descricao_produto">
                    </div>
                    <br>
                    <div class="col">
                        <p>Quantidade</p>
                        <input type="number" class="form-control" name="quantidade" placeholder="Quantidade de entrada">
                    </div>
              <br>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-sm" name="btn-inserir">Inserir</button>
          </form>
      </div>
    </div>





    <div class="offcanvas offcanvas-end" tabindex="-1" id="editar" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Atualização de produto</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
      <form action="ac_produto.php" method="post">
            <div class="col">
            <div class="col">
                        <p>Código do Produto</p>
                        <input type="number" readonly class="form-control" name="id_produto" value="<?php echo $id_produto2; ?>">
                    </div>
                    <br>
                    <div class="col">
                        <p>Descrição produto</p>
                        <input type="text"  class="form-control" name="descricao_produto" value="<?php echo $descricao_produto2; ?>">
                    </div>
                    <br>
                    <div class="col">
                        <p>Categoria de Produto</p>
                           
                            <select name="id_categoria" class="form-control">
                            <option value="<?php echo $id_categoria2; ?>"><?php echo $descricao_categoria2; ?></option>
                               <?php
                            $sql = "SELECT * FROM tb_categoria WHERE id_categoria != $id_categoria2";
                            $result = mysqli_query($conexao, $sql);
                            while($row = mysqli_fetch_row($result))
                            { 
                                $id_categoria=$row[0];   
                                $descricao_categoria=$row[1]; 
                                echo "<option value='$id_categoria'>$descricao_categoria</option>";
                            }
                            ?>
                            </select>
                    </div>
                    <br>
                        <div class="col">
                        <p>Quantidade Minima</p>
                        <input type="number" class="form-control" name="minimo" value="<?php echo $minimo2; ?>" >
                    </div>
                    <br>
                    <div class="col">
                        <p>Valor unitário</p>
                        <input type="number" class="form-control" name="valor_unitario" placeholder="Valor do produto" value="<?php echo $valor_unitario2; ?>">
                    </div>
              <br>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-sm" name="btn-atualizar">Atualizar</button>
          </form>
      </div>
    </div>


<!---------ordenar a tabela---------->

<script>
$(document).ready(function() {
  $("th").click(function() {
    var table = $(this).parents("table").eq(0);
    var rows = table.find("tr:gt(0)").toArray().sort(comparer($(this).index()));
    this.asc = !this.asc;
    if (!this.asc) {
      rows = rows.reverse();
    }
    for (var i = 0; i < rows.length; i++) {
      table.append(rows[i]);
    }
  });
});

function comparer(index) {
  return function(a, b) {
    var valA = getCellValue(a, index);
    var valB = getCellValue(b, index);
    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
  };
}

function getCellValue(row, index) {
  return $(row).children("td").eq(index).text();
}
</script>





