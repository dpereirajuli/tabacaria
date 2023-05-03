<?php

if(!empty($_POST['id_cabecalho'])){
    $id_cabecalho = $_POST['id_cabecalho'];


//// info para preencher os inputs de n documento,  tipo de movimento, header....    
    $sql2="SELECT b.ordem_producao, 
    b.saida, 
    a.descricao  
    FROM TB_TPMOVIMENTO a, 
    TB_TMP_CABECALHO2 b 
    WHERE a.id = b.tpmovimento 
    AND id_cabecalho= $id_cabecalho";
    $result = mysqli_query($conexao, $sql2);
    $resu = mysqli_fetch_array ($result);

    $tipo_movimento = $resu ['descricao'] ;
    $saida = $resu ['saida'] ;
    $ordem_producao = $resu ['ordem_producao'] ;



////Info para a tabela de itens nota
    $sql = "SELECT 	a.id_saida,
    pro.id_produto,
    pro.descricao,
    a.quantidade,
    pro.unidade,
    a.valor_unitario
    FROM	TB_TPM_SAIDA a,
    TB_PRODUTO pro 
    WHERE	a.id_produto = pro.id_produto AND id_cabecalho=$id_cabecalho";
    $query = mysqli_query($conexao,$sql);
}

else{
    $sql = "SELECT b.descricao,a.ordem_producao, a.saida, a.id_cabecalho FROM TB_TMP_CABECALHO2 a ,TB_TPMOVIMENTO b WHERE a.tpmovimento=b.id";
    $query = mysqli_query($conexao,$sql);
}

?>

<link rel="stylesheet" href="saida.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
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
    

<?php
/////CASO CLIQUE EM ALGUMA "ATUALIZAR" PARA INSERIR ITEMS NA NF//////
if(!empty($_POST['id_cabecalho'])){
    $id_cabecalho = $_POST['id_cabecalho'];
?>  

    <h2>Nota de Saida</h2>
    <div class="row">
            <div class="col">
                <label class="form-label form-control-sm">TIPO DE MOVIMENTO</label>
                <input type="text" name="ordem_producao"  class="form-control form-control-sm" readonly  value="<?php echo $tipo_movimento ?>">
            </div>
            <div class="col">
                <label class="form-label form-control-sm">SAÍDA</label>
                <input type="text" name="saida" class="form-control form-control-sm"  readonly  value="<?php echo $saida ?>" > 
            </div>
            <div class="col">
                <label class="form-label form-control-sm">OP</label>
                <input type="text" name="ordem_producao"  class="form-control form-control-sm"  readonly  value="<?php echo $ordem_producao ?>" >
            </div>
            <div class="col">
                <form action="#" method="post">
                    <input type="hidden" name="saida" value="saida">
                    <button type="submit" class="btn btn-primary btn-sm" name="btn_inserir">Voltar</button>  
                    <button type="button" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Confirmar Saida</button>
                </form>
            </div>
        </div>

    <br>
    <hr>


    <?php

    ///ITENS TOTAL INICIO////

    $resultado2 = mysqli_query($conexao, "SELECT sum(quantidade) as itens_total FROM TB_TPM_SAIDA WHERE id_cabecalho=$id_cabecalho");
    $linhas2 = mysqli_num_rows($resultado2);

    while($linhas2 = mysqli_fetch_array($resultado2)){
    $itens_total=  $linhas2['itens_total'];
    $itens_total = number_format($itens_total, 2, ',', '.');
    }
    ///ITENS TOTAL FIM////

    ?>
    <div class="menu_itens">
        <h2>Itens da nota</h2>
        <table class="table table-sm tabela_info">
            <thead>
                <th class="table-dark"> QTD TOTAL</th>
            </thead>
            <tbody>
                <td class="table-light"><b> <?php echo $itens_total  ?></b> </td>
            </tbody>
        </table>
        <div class="btn_iten">
            <a  class="btn btn-success btn-sm" data-bs-toggle="offcanvas" data-bs-target="#add_iten" role="button" id="btn_add_iten" >Adicionar iten</a>
        </div>
    </div>
   
    <div class="div-tabela">
        <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th style="width:05%" scope="col">ID</th>
                        <th style="width:35%" scope="col">DESCRIÇÃO</th>
                        <th style="width:05%" scope="col">UN</th>
                        <th style="width:05%" scope="col">QUANTIDADE</th>
                        <th style="width:05%" >AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($query) && mysqli_num_rows($query) > 0){
                                while($row = mysqli_fetch_assoc($query)){
                                    $id_saida= $row['id_saida'];
                                    $id_produto= $row['id_produto'];
                                    $descricao= $row['descricao'];
                                    $unidade= $row['unidade'];
                                   $quantidade=$row['quantidade'];
                                    $quantidade = str_replace('.',',', $quantidade);
                        ?>
                                <td>  <?php echo $id_produto;  ?> </td>
                                <td>  <?php echo $descricao;  ?> </td>
                                <td>  <?php echo $unidade;  ?> </td>
                                <td>  <?php echo $quantidade;  ?> </td>
                                <td>
                                <form action="ac_saida.php" method="post">
                                    <input type="hidden" value="saida" name="saida">
                                    <input type="hidden" value="<?php echo $id_cabecalho;?>" name="id_cabecalho">
                                    <input type="hidden" value="<?php echo $id_saida;?>" name="id_saida">
                                    <button type="submit" class="btn btn-danger btn-sm" >Excluir</button>
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
    

    
    <?php
    ////// para contar quantos itens tem
    $sql4= "SELECT COUNT(id_saida) as total_saida
    FROM `tb_tpm_saida` 
    WHERE id_cabecalho=$id_cabecalho";
    $result4 = mysqli_query($conexao, $sql4);
    while($row4 = mysqli_fetch_array($result4)){
        $total_saida = $row4 ['total_saida'];
    }

  

}

/////ASSIM QUE ENTRAR NA TELA E ACIONAR UMA NOTA FISCAL
else{
?>
    <h2>Nota de Saída</h2>
    <form action="ac_saida.php" method="post">
        <div class="row">
            <div class="col">
                <label class="form-label form-control-sm">TIPO DE MOVIMENTO</label>
                <select name="tpmovimento" class="form-select form-select-sm select">
                        <?php
                        $sql3 = "SELECT * FROM TB_TPMOVIMENTO A WHERE A.tipo = 2";
                            $result3 = mysqli_query($conexao, $sql3);
                            while($row3 = mysqli_fetch_row($result3))
                        { 
                        $id_movimento=$row3[0];
                        $descricao_movimento=$row3[1];   
                        echo "<option value='$id_movimento'>$descricao_movimento</option>";
                        }
                        ?>
                </select>
            </div>
            <div class="col">
                <label class="form-label form-control-sm">SAÍDA</label>
                <input type="date" name="saida" class="form-control form-control-sm" value='<?php echo date("Y-m-d"); ?>' placeholder="Data da entrada" required="required"> 
            </div>
            <div class="col">
                <label class="form-label form-control-sm">OP</label>
                <input type="text" name="ordem_producao"  class="form-control form-control-sm" value="0" required="required">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-success btn_inserir btn-sm" name="btn_inserir"> INSERIR </button>     
                <button class="btn btn-primary btn-sm"  name="lista_entrada" type="submit">SAIDAS</button>
            </div>
        </div>
    </form>

    <br>
    <hr>



        <!-------- TABELA DE PENDENTES ----->
    <h2>Pendentes</h2>
    <div class="div-tabela">
        <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th style="width:25%" scope="col">TIPO DE MOVIMENTO</th>
                        <th style="width:05%" scope="col">OP</th>
                        <th style="width:05%" scope="col">DATA</th>
                        <th style="width:05%" >AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($query) && mysqli_num_rows($query) > 0){
                                while($row = mysqli_fetch_assoc($query)){
                                $id_cabecalho= $row['id_cabecalho'];
                                $descricao= $row['descricao'];
                                $saida= $row['saida'];
                                $saida = date('d/m/Y', strtotime($saida));
                                $ordem_producao = $row['ordem_producao'];

                        ?>
                                <td>  <?php echo $descricao;  ?> </td>
                                <td>  <?php echo $ordem_producao;  ?> </td>
                                <td>  <?php echo $saida;  ?> </td>
                                <td class="em_linha">
                                    <form action="#" method="post">
                                        <input type="hidden" value="saida" name="saida">
                                        <input type="hidden" value="<?php echo $id_cabecalho;?>" name="id_cabecalho">
                                        <button type="submit" class="btn btn-warning btn-sm" >Atualizar</button>
                                    </form>
                                    <form action="ac_saida.php" method="post">
                                        <input type="hidden" value="<?php echo $id_cabecalho;?>" name="id_excluir">
                                        <button type="submit" name="excluir" class="btn btn-danger btn-sm excluir" >Excluir</button>
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
                        }
                        ?>
                </tbody>
        </table>
    </div>
<?php
}
?>  


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