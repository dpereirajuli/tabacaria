<?php
    
 if(isset($_POST['inicio']) &&($_POST['termino'])  ){
    $inicio = $_POST['inicio'];
    $termino = $_POST['termino'];
    $tipo_de_data = $_POST['data'];
    
    $sql = "SELECT a.documento,
    a.lote,
    a.emissao,
    a.pedido_compra,
    b.nome,
    c.descricao,
    c.unidade,
    a.id_fornecedor,
    a.quantidade,
    e.descricao_status,
    a.entrada
    FROM `tb_recebimento` a, 
    `tb_fornecedores` b, 
    `tb_produto` c,
    `tb_tpmovimento` d,
    `tb_status` e
    WHERE a.$tipo_de_data >= '$inicio'
    AND a.$tipo_de_data <= '$termino'
    AND a.id_fornecedor = b.id_fornecedor 
    AND a.id_produto = c.id_produto
    AND a.tp_movimento = d.id
    AND e.id_status=a.status1 
    ORDER BY emissao ASC";
    $result = mysqli_query($conexao,$sql);
}


elseif(!empty($_POST['codigo']) ){

    $codigo_produto = $_POST['codigo'];

    $sql = "SELECT a.documento,
    a.lote,
    a.emissao,
    a.pedido_compra,
    b.nome,
    c.descricao,
    c.unidade,
    a.id_fornecedor,
    a.quantidade,
    e.descricao_status,
    a.entrada
    FROM `tb_recebimento` a, 
    `tb_fornecedores` b, 
    `tb_produto` c,
    `tb_tpmovimento` d,
    `tb_status` e
    WHERE c.id_produto=$codigo_produto
    AND a.id_fornecedor = b.id_fornecedor 
    AND a.id_produto = c.id_produto
    AND a.tp_movimento = d.id
    AND e.id_status=a.status1 
    ORDER BY emissao ASC";
    $result = mysqli_query($conexao,$sql);
}

else{
    $sql = "SELECT a.documento,
    a.lote,
    a.emissao,
    a.pedido_compra,
    b.nome,
    c.descricao,
    c.unidade,
    a.id_fornecedor,
    a.quantidade,
    e.descricao_status,
    a.entrada
    FROM `tb_recebimento` a, 
    `tb_fornecedores` b, 
    `tb_produto` c,
    `tb_tpmovimento` d,
    `tb_status` e
    WHERE  a.id_fornecedor = b.id_fornecedor 
    AND a.id_produto = c.id_produto
    AND a.tp_movimento = d.id
    AND e.id_status=a.status1 
    ORDER BY emissao ASC";
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
    <h2>Relátorio Entrada</h2>

        <div class="container-fluid menu-pesquisa">
            <a class="btn btn-warning" data-bs-toggle="offcanvas" data-bs-target="#filtro" role="button" >Filtro</a>
            <input type="button" class="btn btn-danger btn-pdf" value="Gerar PDF" id="btnImprimir" onclick="CriaPDF()" />
            <input type="button" class="btn btn-success btn-exel" value="Gerar Exel" id="btnImprimir" onclick="CriaPDF()" />
        </div>

        <div class="div-tabela"  id="tabela">
            <div class="oculta_relatorio">
                <img src="/img/teckab.png">
                <p>
                    <?php 
                        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                        date_default_timezone_set('America/Sao_Paulo');
                        echo $data = strftime("%d/%m/%Y ás %T");
                    ?>
                </p>
            </div>
            <table class="table table-bordered table-sm tabela-produto">
                <thead>
                    <tr>
                        <th>ENTRADA</th>
                        <th>CÓDIGO FORNECEDOR</th>
                        <th>FORNECEDOR</th>
                        <th>QUANTIDADE</th>
                        <th>UNIDADE</th>
                        <th>PEDIDO</th>
                        <th>LOTE</th>
                        <th>NF</th>
                        <th>LAUDO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if(!empty($result) && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $dia = $row['entrada'];
                                    $timestamp = strtotime($dia);
                                    $dia = date("d/m/Y", $timestamp);    
                                    $quantidade = $row['quantidade'];
                                    $quantidade = number_format($quantidade, 2, ',', '.');
                                    $descricao = $row['descricao'];
                                    $id_fornecedor = $row['id_fornecedor'];
                                    $nome = $row['nome'];
                                    $unidade = $row['unidade'];
                                    $pedido_compra = $row['pedido_compra'];
                                    $lote = $row['lote'];
                                    $documento = $row['documento'];
                                    $descricao_status = $row['descricao_status'];
                        ?>
                                <td>  <?php echo $dia;  ?> </td>
                                <td>  <?php echo $id_fornecedor;  ?> </td>
                                <td>  <?php echo $nome;  ?> </td>
                                <td>  <?php echo $quantidade;  ?> </td>
                                <td>  <?php echo $unidade;  ?> </td>
                                <td>  <?php echo $pedido_compra;  ?> </td>
                                <td>  <?php echo $lote;  ?> </td>
                                <td>  <?php echo $documento;  ?> </td>
                                <td>  <?php echo $descricao_status;  ?> </td>
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
                        <input type="hidden" name="relatorio_recebimento" value="relatorio_recebimento">
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
        win.document.write('<title>Relátorio de entrada de estoque</title>');   // <title> CABEÇALHO DO PDF.
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