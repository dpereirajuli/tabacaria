<?php

include('conexao.php');
include('verifica_login.php');



///// EXCLUIR CABECALHO/NF 
if(isset(($_POST['id_excluir']))){
    $id_cabecalho = $_POST['id_excluir'];
    $sql = "DELETE FROM `tb_tmp_cabecalho2` WHERE id_cabecalho = $id_cabecalho ";
    
    if(mysqli_query($conexao, $sql)){

        $resultado2 = mysqli_query($conexao, "DELETE FROM `tb_tpm_saida` WHERE id_cabecalho = $id_cabecalho");
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="saida" value="saida">
        </form>

        <script>
        window.onload = function() {
            document.getElementById("myForm").submit();
        };
        </script>
<?php
    }
}


///// EXCLUIR ITENS DE DENTRO DA NF 
if(!empty($_POST['id_cabecalho']) && ($_POST['id_saida'])){
    $id_saida = $_POST['id_saida'];
    $id_cabecalho = $_POST['id_cabecalho'];
    
    $sql = "DELETE FROM `tb_tpm_saida` WHERE id_saida = $id_saida ";
    
    if(mysqli_query($conexao, $sql)){
    
?>
        <form action="painel.php" method="post" id="myForm">
            <input type="hidden" name="saida" value="saida">
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




///// INSERIR CABECALHO/NF 
if(!empty($_POST['tpmovimento']) && ($_POST['saida'])){

    echo $tpmovimento =  ($_POST['tpmovimento']);
    $ordem_producao =  ($_POST['ordem_producao']);
    $saida =  ($_POST['saida']);


    if ($tpmovimento == 2){
        $ordem_producao =  'null';
        
        $sql = "INSERT INTO TB_TMP_CABECALHO2 (ordem_producao,saida,tpmovimento) 
        VALUES ($ordem_producao, '$saida', '$tpmovimento')";
       
       if(mysqli_query($conexao, $sql)){
        ?>
            <form action="painel.php" method="post" id="myForm">
                <input type="hidden" name="saida" value="saida">
            </form>
    
            <script>
            window.onload = function() {
                document.getElementById("myForm").submit();
            };
            </script>
        <?php
        }
} 

    
else{

        $sql = "INSERT INTO TB_TMP_CABECALHO2 (ordem_producao,saida,tpmovimento)
        VALUES ('$ordem_producao', '$saida', '$tpmovimento')";
        
        if(mysqli_query($conexao, $sql)){
        ?>
            <form action="painel.php" method="post" id="myForm">
                <input type="hidden" name="saida" value="saida">
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



///// INSERIR PRODUTOS DENTRO DO  CABECALHO/NF 
if(!empty($_POST['id_cabecalho']) && (($_POST['descricao_produto']) != "Produto não encontrado")){
    $id_produto = $_POST['codigo'];
    $quantidade = $_POST['quantidade'];
    $id_cabecalho = ($_POST['id_cabecalho']);
    $usuario = "dpereirajuli";

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

        $sql = "INSERT INTO TB_TPM_SAIDA (id_produto, quantidade, id_cabecalho, usuario) 
        VALUE ($id_produto, $quantidade, $id_cabecalho,'$usuario')";
            

        if ($query = mysqli_query($conexao, $sql)){
?>

            <form action="painel.php" method="post" id="myForm">
                <input type="hidden" name="saida" value="saida">
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

if(!empty(($_POST['descricao_produto']) == "Produto não encontrado")){
    echo "Campo produto está como Produto não encontrado";
}



///// INSERIR NF NA TABELA ULTIMA DE SAIDA JUNTO AO ITENS
if(isset(($_POST['confirma']))){
    $id_cabecalho = $_POST['id_saida'];

    $sql = "INSERT INTO TB_SAIDA (ordem_producao,saida,id_produto,quantidade,id_cabecalho,tpmovimento)
    (SELECT A.ordem_producao, A.saida, B.id_produto, B.quantidade, B.id_cabecalho, A.tpmovimento
    FROM TB_TMP_CABECALHO2 A, TB_TPM_SAIDA B 
    WHERE A.id_cabecalho=$id_cabecalho
    AND B.id_cabecalho=$id_cabecalho)";

        

    if(mysqli_query($conexao, $sql)){
        $sql1 = "DELETE FROM TB_TPM_SAIDA WHERE id_cabecalho=$id_cabecalho";

        if(mysqli_query($conexao, $sql1)){

            $sql2 = "DELETE FROM TB_TMP_CABECALHO2 WHERE id_cabecalho=$id_cabecalho";

            if(mysqli_query($conexao, $sql2)){

                ?>

                <form action="painel.php" method="post" id="myForm">
                    <input type="hidden" name="saida" value="saida">
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
