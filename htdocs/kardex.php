<?php


if(!empty($_POST['inicio']) && ($_POST['termino']) && ($_POST['codigo'])){

    $id_produto = $_POST['codigo'];
    $dt_inicial = $_POST['inicio'];
    $dt_final = $_POST['termino'];

    $sql = "SELECT  TAB.tipo,
    TAB.movimento,
    TAB.documento,
    TAB.quantidade,
    TAB.data
     FROM (SELECT  'ENTRADA' 		as tipo,
           A.id_produto  as produto,
           B.descricao 	as movimento,
           A.documento 	as documento,
           A.quantidade	as quantidade,
           A.entrada		as data
     FROM  TB_RECEBIMENTO  A,
           TB_TPMOVIMENTO	B
     WHERE	A.tp_movimento = B.id     

     UNION ALL

SELECT  'SAIDA' 		 as tipo,
     A.id_produto  as produto,
     B.descricao 	 as movimento,
     A.ordem_producao as documento,
     A.quantidade	 as quantidade,
     A.saida			as data
       FROM    TB_SAIDA  		A,
           TB_TPMOVIMENTO	B
       WHERE	A.tpmovimento = B.id ) TAB
       WHERE   TAB.data    >= '$dt_inicial'
       AND TAB.produto= $id_produto
       AND	TAB.data	<= '$dt_final'";
$query = mysqli_query($conexao,$sql);


$sql2="SELECT X.descricao,
COALESCE((SELECT sum(A.quantidade)	as quantidade
FROM    TB_RECEBIMENTO  A
WHERE	A.id_produto = X.id_produto
GROUP BY A.id_produto),0) - 
COALESCE((SELECT  sum(A.quantidade)	as quantidade
FROM    TB_SAIDA  A
WHERE	A.id_produto = X.id_produto
GROUP BY A.id_produto),0)saldo
FROM TB_PRODUTO X
WHERE X.id_produto = $id_produto";
$query2 = mysqli_query($conexao,$sql2);


}
?>

<link rel="stylesheet" href="kardex.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>



<script type='text/javascript'>
			$(document).ready(function(){
				$("input[name='codigo']").blur(function(){
					var $descricao_produto = $("input[name='descricao_produto']");
                    var $unidade = $("input[name='unidade']");
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
    <h2>Kardex</h2>
    <div class="menu-kardex">
            <form action="#" method="post" class="form-kardex">
                            <input type="hidden" name="kardex" value="kardex">
                            <div class="col">
                                <p>Início</p>
                                <input type="date" name="inicio" class="form-control">
                            </div>
                            <br>
                            <div class="col">
                                <p>Término</p>
                                <input type="date" name="termino" class="form-control">
                            </div>
                            <hr>
                            <div class="col">
                                <p>Código do Produto</p>
                                <input type="text" class="form-control" name="codigo"  placeholder="Código do produto">
                            </div>
                            <br>
                            <div class="col">
                                <p>Produto</p>
                                <input type="text" readonly class="form-control" name="descricao_produto" placeholder="Nome do Produto">
                            </div>
                            <hr>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" name="pesquisar">Pesquisar</button>
                                </div>

            </form>
        </div>

    <br>
    <hr>



        <!-------- TABELA DE PENDENTES ----->

    <div class="informacao-kardex">
        <div>
            <h2>Movimentos</h2>
        </div>
        <?php if(!empty($_POST['inicio']) && ($_POST['termino']) && ($_POST['codigo'])){ ?> 
        <div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>PRODUTO</th>
                        <th>SALDO TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        if(!empty($query2) && mysqli_num_rows($query2) > 0){
                        while($res = mysqli_fetch_array($query2)){
                            $saldo= $res['saldo'];
                            $descricao = $res['descricao'];
                        ?>
                            <td>  <?php echo $saldo;  ?> </td>
                            <td>  <?php echo $descricao;  ?> </td>
                    </tr>
                    <?php
                        }
                            }
                        else{
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
        <?php }  ?> 
    </div>
    <div class="div-tabela">
        <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th style="width:20%" scope="col">TIPO DE MOVIMENTO</th>
                        <th style="width:05%" scope="col">DATA</th>
                        <th style="width:05%" scope="col">DOCUMENTO</th>
                        <th style="width:05%" >QUANTIDADE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($query) && mysqli_num_rows($query) > 0){
                                while($row = mysqli_fetch_assoc($query)){
                                $movimento= $row['movimento'];
                                $documento= $row['documento'];
                                $quantidade= $row['quantidade'];

                                $dia = $row['data'];
                                $timestamp = strtotime($dia);
                                $dia = date("d/m/Y", $timestamp);

                        ?>
                                <td>  <?php echo $movimento;  ?> </td>
                                <td>  <?php echo $dia;  ?> </td>
                                <td>  <?php echo $documento;  ?> </td>
                                <td>  <?php echo $quantidade;  ?> </td>
                    </tr>
                        <?php
                        }
                            }
                        else{
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                        }
                        ?>
                </tbody>
        </table>
    </div>



<!---------MODAL PARA ADD ITEM NA TABELA--->
<div class="offcanvas offcanvas-end" tabindex="-1" id="add_iten" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Adicionar iten</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="ac_saida.php" method="post">
                    <div class="col">
                        <p>Código do Produto</p>
                        <input type="hidden" name="id_cabecalho" value="<?php echo $id_cabecalho;?>" >
                        <input type="text" class="form-control" name="codigo"  placeholder="Código do produto">
                    </div>
                    <br>
                    <div class="col">
                        <p>Produto</p>
                        <input type="text" readonly class="form-control" name="descricao_produto" placeholder="Nome do Produto">
                    </div>
                    <br>
                    <div class="col">
                        <label class="form-label">Unidade</label>
                        <input type="text" class="form-control form-control-sm" name="unidade" readonly="true" required="required" >
                    </div>
                    <br>
                    <div class="col">
                        <label class="form-label">Quantidade</label>
                        <input type="text" class="form-control form-control-sm" name="quantidade"  required="required">
                    </div>
                    <br>                    
                <hr>
                <button type="submit" class="btn btn-primary">Inserir</button>
            </form>
        </div>
    </div>



            <!-- MODAL CONFIRMAR SAIDA -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja confirmar saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="ac_saida.php" method="post">
                    <div class="modal-body">
                            
                                <p>Movimento: <?php echo $tipo_movimento ?> na data de: <?php echo $saida ?> <br> 
                                OP:<?php echo $ordem_producao ?> , com a quantidades de iten(s): <?php echo $total_saida ?> </p>

                                <input type="hidden" name="id_saida" value="<?php echo $id_cabecalho ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="confirma">Confirmar</button>    
                    </div>
                </form>
                </div>
            </div>
        </div>
</div>