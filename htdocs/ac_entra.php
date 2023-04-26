<?php
include('conexao.php');




///// EXCLUIR CABECALHO/NF 
if(isset(($_POST['id_excluir']))){
    $id_cabecalho = $_POST['id_excluir'];
    $sql = "DELETE FROM `tb_tmp_cabecalho` WHERE id_cabecalho = $id_cabecalho ";
    
    if(mysqli_query($conexao, $sql)){
        $resultado2 = mysqli_query($conexao, "DELETE FROM `tb_tmp_recebimento` WHERE id_cabecalho = $id_cabecalho");
       
?>

        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="entrada" value="entrada">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php
    }
}




if(!empty($_POST['id_cabecalho']) && ($_POST['id_recebimento'])){
    $id_recebimento = $_POST['id_recebimento'];
    $id_cabecalho = $_POST['id_cabecalho'];
    
    $sql = "DELETE FROM `TB_TMP_RECEBIMENTO` WHERE id_recebimento = $id_recebimento ";
    
    if(mysqli_query($conexao, $sql)){
    
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="entrada" value="entrada">
            <input type="hidden" name="id_cabecalho" value="<?php echo $id_cabecalho;?>">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php
    }
}

if(!empty($_POST['n_documento'])){
    $n_documento =  ($_POST['n_documento']);
    $emissao =  ($_POST['emissao']);
    $entrada =  ($_POST['entrada']);
    $p_compra =  ($_POST['p_compra']);
    $p_compra = str_replace('/','.', $p_compra);
    $fornecedor =  ($_POST['fornecedor']);
    $usuario = "dpereirajuli";
    $tp_movimento = ($_POST['tp_movimento']);
 
$sql = "INSERT INTO TB_TMP_CABECALHO (documento,emissao,entrada,pedido_compra,id_fornecedor, usuario, tp_movimento) 
        VALUES ('$n_documento', '$emissao', '$entrada', $p_compra, '$fornecedor', '$usuario', $tp_movimento)";
    if(mysqli_query($conexao, $sql)){
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="entrada" value="entrada">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php
    }
}

if(!empty($_POST['id_cabecalho']) && (($_POST['descricao_produto']) != "Produto não encontrado")){
    $id = $_POST['codigo'];
    $quantidade = $_POST['quantidade'];
    $valor_unitario = $_POST['valor_unitario'];
    $id_cabecalho = ($_POST['id_cabecalho']);
    $lote = ($_POST['lote']);
    $status1 = ($_POST['status']);
    $usuario = "dpereirajuli";


    function Valor($valor_unitario) {
        $verificaPonto = ".";
        if(strpos("[".$valor_unitario."]", "$verificaPonto")):
            $valor_unitario = str_replace('.','', $valor_unitario);
            $valor_unitario = str_replace(',','.', $valor_unitario);
            else:
              $valor_unitario = str_replace(',','.', $valor_unitario);   
        endif;
 
        return $valor_unitario;
    }

    function qtd ($quantidade) {
        $verificaPonto = ".";
        if(strpos("[".$quantidade."]", "$verificaPonto")):
            $quantidade = str_replace('.','', $quantidade);
            $quantidade = str_replace(',','.', $quantidade);
            else:
              $quantidade = str_replace(',','.', $quantidade);   
        endif;
    
        return $quantidade;
    }
        $quantidade = qtd($quantidade);
        $valor_unitario = Valor($valor_unitario);

        $sql = "INSERT INTO TB_TMP_RECEBIMENTO (id_produto, quantidade, valor_unitario, id_cabecalho, usuario, status1, lote) 
        VALUE ($id, $quantidade, $valor_unitario, $id_cabecalho,'$usuario', '$status1', '$lote' )";
            

        if ($query = mysqli_query($conexao, $sql)){
?>

            <form action="painel.php" method="post" id="myForm">
                <input type="hidden" name="entrada" value="entrada">
                <input type="hidden" name="id_cabecalho" value="<?php echo $id_cabecalho;?>">
            </form>

            <script>
            window.onload = function() {
                document.getElementById("myForm").submit();
            };
            </script>
<?php
        }
            else{
                echo "erro";
            }
        
}


if(isset($_POST['id_entrada'])){
    $id_cabecalho = $_POST['id_entrada'];
    echo $id_cabecalho;

    $sql = "INSERT INTO TB_RECEBIMENTO (documento,emissao,entrada,pedido_compra,id_fornecedor,id_produto,quantidade, valor_unitario,id_cabecalho, tp_movimento,lote,status1)
    (SELECT A.documento, A.emissao, A.entrada, A.pedido_compra, A.id_fornecedor, B.id_produto, B.quantidade, B.valor_unitario, B.id_cabecalho,A.tp_movimento,B.lote,B.status1
    FROM TB_TMP_CABECALHO A, TB_TMP_RECEBIMENTO B 
    WHERE A.id_cabecalho=$id_cabecalho
    AND B.id_cabecalho=$id_cabecalho)";

        

    if(mysqli_query($conexao, $sql)){
        $sql1 = "DELETE FROM TB_TMP_RECEBIMENTO WHERE id_cabecalho=$id_cabecalho";

        if(mysqli_query($conexao, $sql1)){

            $sql2 = "DELETE FROM TB_TMP_CABECALHO WHERE id_cabecalho=$id_cabecalho";

            if(mysqli_query($conexao, $sql2)){

                ?>

                <form action="painel.php" method="post" id="myForm">
                    <input type="hidden" name="entrada" value="entrada">
                </form>
    
                <script>
                window.onload = function() {
                    document.getElementById("myForm").submit();
                };
                </script>
            <?php

            }

        }

    }        
}

else{
    echo "Existe campo vazio";
}
    
?>
    