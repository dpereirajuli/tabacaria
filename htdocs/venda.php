<?php
    
 if(isset($_POST['select-pesquisa'])){
    $select = $_POST['select-pesquisa'];
    $pesquisar = $_POST['pesquisa'];
    
    $sql3 = "SELECT * 
    FROM TB_FORNECEDORES  
    WHERE $select 
    LIKE '%$pesquisar%'";
    $result = mysqli_query($conexao,$sql);
}

else{
    $sql3="SELECT a.id_venda,
                  a.id_produto,
                        a.valor_unitario,
                        b.descricao_produto,
                        COUNT(a.id_produto) as quantidade,
                        SUM(a.valor_unitario) as valor_total
              FROM tb_temp a,
              tb_produto b
              WHERE a.id_produto=b.id_produto
              GROUP by a.id_produto";
    $result3 = mysqli_query($conexao,$sql3);

    $sql4="SELECT SUM(a.valor_unitario) as valor_total
              FROM tb_temp a,
              tb_produto b
              WHERE a.id_produto=b.id_produto";
              $result4 = mysqli_query($conexao,$sql4);


}

?>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<link rel="stylesheet" href="venda.css">

<script type='text/javascript'>
			$(document).ready(function(){
				$("input[name='codigo']").blur(function(){
					var $descricao_produto = $("input[name='descricao_produto']");
          var $valor_unitario = $("input[name='valor_unitario']");
					$.getJSON('function.php',{ 
						codigo: $( this ).val() 
					},function( json ){
						$descricao_produto.val( json.descricao_produto );
            $valor_unitario.val( json.valor_unitario );
					});
				});
			});
</script>

<div class="container-fluid menu-cadastro">
    <div  class="container-fluid div-venda">
    <h2>CAIXA</h2>
      <form action="#" method="post">
        <div class="col">
          <div class="col">
            <p>Código do Produto</p>
            <input type="text" class="form-control" name="codigo" placeholder="Scanei o código do produto">
          </div>
          <br>
          <div class="col">
            <p>Produto</p>
            <input type="text" class="form-control" name="descricao_produto" placeholder="Produto">
          </div>
        </div>
        <br>
        <div class="col">
          <div class="col">
            <p>Valor do Produto</p>
            <input type="text" class="form-control"  name="valor_unitario" placeholder="Digite o valor do produto">
          </div>
        </div>
        <br>      
        <hr>
        <button type="submit" class="btn btn-primary">Inserir</button>
      </form>
    </div>

    <div  class="container-fluid div-resulmo">
            <!----------TABELA COM ITENS DA COMPRA------------->
      <table class="table table-bordered table-sm tabela-resulmo">
          <tr>
              <th  style="width:60%" scope="col">Produtos</th>
              <th  style="width:15%" scope="col">Quantidade</th>
              <th  style="width:15%" scope="col">Valor Unitário</th>
              <th  style="width:05%" scope="col">Ações</th>
          </tr>
          <tbody>
            <tr>
            <?php
                              if(!empty($result3) && mysqli_num_rows($result3) > 0){
                                  while($row = mysqli_fetch_assoc($result3)){
                                  $id_produto = $row['id_produto'];
                                  $id_venda = $row['id_venda'];
                                  $descricao_produto  = $row['descricao_produto'];
                                  $valor_unitario = $row['valor_unitario'];
                                  $quantidade = $row['quantidade'];
                          ?>
                                  <td>  <?php echo $descricao_produto;  ?> </td>
                                  <td>  <?php echo $quantidade;  ?> </td>
                                  <td>  <?php echo $valor_unitario;  ?> </td>
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

            </tr>
          </tbody>
        </table>

      <!----------TABELA COM TOTAL DA COMPRA------------->
        <table class="table table-bordered table-sm tabela-total">
              <thead>
                <tr>
                    <th>TOTAL</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                <?php
                              if(!empty($result4) && mysqli_num_rows($result4) > 0){
                                  while($row2 = mysqli_fetch_assoc($result4)){
                                    $valor_total = $row2['valor_total'];
                          ?>
                                  <td>  <?php echo $valor_total;  ?> </td>
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
                </tr>
              </tbody>
        </table>
        <div class="btn-finalizar">
          <button type="submit" class="btn btn-success">Finalizar Compra</button>
        </div>

    </div>


 </div>


 <?php


    
 if(!empty($_POST['valor_unitario']) && $_POST['descricao_produto'] != 'Produto não encontrado'){
    $id_produto = $_POST['codigo'];
    $valor_unitario = $_POST['valor_unitario'];
    
    $sql = "INSERT INTO tb_temp (`id_produto`, `valor_unitario`) VALUES ( $id_produto , '$valor_unitario')";
    $result = mysqli_query($conexao,$sql);
    ?>
    <form action="painel.php" method="post" id="myForm">
        <input type="hidden" name="painel" value="">
    </form>

    <script>
    window.onload = function() {
        document.getElementById("myForm").submit();
    };
    </script>
<?php

}

?>

