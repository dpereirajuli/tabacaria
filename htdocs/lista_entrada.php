<?php
    
 if(isset($_POST['inicio']) &&($_POST['termino'])  ){
    $inicio = $_POST['inicio'];
    $termino = $_POST['termino'];
    $tipo_de_data = $_POST['data'];
    
    $sql = "SELECT A.id_cabecalho, A.id_recebimento, A.documento, A.emissao, A.entrada, A.pedido_compra, B.nome
    FROM TB_RECEBIMENTO A, 
         TB_FORNECEDORES B 
    WHERE a.$tipo_de_data >= '$inicio'
    AND a.$tipo_de_data <= '$termino'
    AND a.id_fornecedor = b.id_fornecedor 
    ORDER BY id_produto ASC";
    $result = mysqli_query($conexao,$sql);
}

elseif(!empty($_POST['codigo']) ){

    $codigo_produto = $_POST['codigo'];

    $sql = "SELECT A.id_cabecalho, 
    A.id_recebimento, 
    A.documento, 
    A.emissao, 
    A.entrada, 
    A.pedido_compra, 
    B.nome
    FROM TB_RECEBIMENTO A, 
         TB_FORNECEDORES B  
    WHERE A.id_produto = $codigo_produto
    AND A.id_fornecedor = B.id_fornecedor 
    GROUP BY A.id_cabecalho";
    $result = mysqli_query($conexao,$sql);
}


else{
    $sql = "SELECT A.id_cabecalho, A.id_recebimento, A.documento, A.emissao, A.entrada, A.pedido_compra, B.nome
    FROM TB_RECEBIMENTO A, 
         TB_FORNECEDORES B  
    WHERE A.id_fornecedor = B.id_fornecedor 
    GROUP BY A.id_cabecalho";
    $result = mysqli_query($conexao,$sql);
}

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<link rel="stylesheet" href="relatorio.css">

<script type='text/javascript'>
			$(document).ready(function(){
				$("input[name='codigo']").blur(function(){
					var $descricao_produto = $("input[name='descricao_produto']");
					$.getJSON('function.php',{ 
						codigo: $( this ).val() 
					},function( json ){
						$descricao_produto.val( json.descricao_produto );
					});
				});
			});
</script>

<div class="container-fluid menu-cadastro">

    <?php
    if(isset($_POST['detalhes'])){
    ?>
    <h2>Detalhes</h2>

    <?php
    }
    else{
    ?>
    <h2>Lista de Entradas</h2>
        <div class="container-fluid menu-pesquisa">
            <a class="btn btn-warning" data-bs-toggle="offcanvas" data-bs-target="#filtro" role="button" >Filtro</a>
            <input type="button" class="btn btn-danger btn-pdf" value="Gerar PDF" id="btnImprimir" onclick="CriaPDF()" />
            <input type="button" class="btn btn-success btn-exel" value="Gerar Exel" id="btnImprimir" onclick="CriaPDF()" />
        </div>

        <div class="div-tabela"  id="tabela">
            <div class="oculta_relatorio">
                <img src="/img/teckab.png">
            </div>
            <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                    <th style="width:05%">DOCUMENTO</th>
                    <th style="width:05%">EMISSÃO</th>
                    <th style="width:05%">ENTRADA</th>
                    <th style="width:05%">Nº PEDIDO</th>
                    <th style="width:35%">FORNECEDOR</th>
                    <th style="width:05%">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($result) && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $documento = $row['documento'];
                                    $emissao= $row['emissao'];
                                    $emissao = date('d/m/Y', strtotime($emissao));
                                    $entrada= $row['entrada'];
                                    $entrada = date('d/m/Y', strtotime($entrada));
                                    $pedido_compra = $row['pedido_compra'];
                                    $nome = $row['nome'];                                  
                        ?>
                                <td>  <?php echo $documento;  ?> </td>
                                <td>  <?php echo $emissao;  ?> </td>
                                <td>  <?php echo $entrada;  ?> </td>
                                <td>  <?php echo $pedido_compra;  ?> </td>
                                <td>  <?php echo $nome;  ?> </td>
                                <td>
                                    <form action="painel.php" method="post">
                                        <input type="hidden" value="entradas" name="entradas">
                                        <button type="submit" class="btn btn-warning btn-sm" >Detalhes</button>
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
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                        }
                        ?>
                </tbody>
            </table>
        </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtro" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Criar filtro</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="#" method="post">
                    <div class="col">
                        <input type="hidden" name="lista_entrada.php" value="lista_entrada">
                        <p>Tipo de filtro</p>
                        <select class="form-select" name="data">
                            <option value="entrada" selected>Data de Entrada</option>
                            <option value="emissao">Data de Emissão</option>
                        </select>
                    </div>
                    <br>
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
                <button type="submit" class="btn btn-primary">Aplicar filtro</button>
            </form>
        </div>
    </div>

    <?php
    }
    ?>

        

        <script>
    function CriaPDF() {
        var minhaTabela = document.getElementById('tabela').innerHTML;
        var style = "<style>";
        style = style + "table {width: 100%;font: 20px Calibri;}";
        style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: center;}";
        style = style + "</style>";
        // CRIA UM OBJETO WINDOW
        var win = window.open('', '', 'height=700,width=700');
        win.document.write('<html><head>');
        win.document.write('<title>Relátorio de levantamento de valores</title>');   // <title> CABEÇALHO DO PDF.
        win.document.write(style);                                     // INCLUI UM ESTILO NA TAB HEAD
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(minhaTabela);                          // O CONTEUDO DA TABELA DENTRO DA TAG BODY
        win.document.write('</body></html>');
        win.document.close(); 	                                         // FECHA A JANELA
        win.print();                                                            // IMPRIME O CONTEUDO
    }
</script>
       

    
</div>