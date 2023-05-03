<?php
define('HOST', '108.179.193.10:3306');
define('USUARIO', 'bwtecn91');
define('SENHA', 'n9v6A1fk3N');
define('DB', 'bwtecn91_bdrefrin');

$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die ('Não foi possível conectar');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="teste.css">
</head>
<body>

<form action="#" method="post">
    <p>de</p>
    <input type="text" name="de">

    <p>ate</p>
    <input type="text" name="ate">

    <p>usuario</p>
    <input type="text" name="usuario">


    <p>Data de:</p>
    <input type="date" name="inicio_data">

    <p>Data até</p>
    <input type="date" name="termino_data">

    <button type="submit">filtrar</button>
</form>



<div id="tabela">

    <div class="retangulo">
            <img src="./img/cliente.png" alt="" id="img">   
            <div class="h4"><h4>RELÁTORIO DE APONTAMENTO POR GEPRO</h4>  </div>
    </div>



    <?php


    $relatorio=null;

    if(!empty($_POST['de']) && $_POST['ate'] ){
        $de =  $_POST['de'];
        $ate = $_POST['ate'];
        $relatorio=1;
    }

    if(!empty($_POST['inicio_data']) && ($_POST['termino_data']) ){
        $inicio_data = $_POST['inicio_data'];
        $termino_data = $_POST['termino_data'];
        $relatorio=2;
    }

    if(!empty($_POST['de']) && $_POST['ate'] && $_POST['usuario']  ){
        $de =  $_POST['de'];
        $ate = $_POST['ate'];
        $usuario = $_POST['usuario'];
        $relatorio=3;
    }

    if(!empty($_POST['inicio_data']) && ($_POST['termino_data']  && $_POST['usuario'] ) ){
        $inicio_data = $_POST['inicio_data'];
        $termino_data = $_POST['termino_data'];
        $usuario = $_POST['usuario'];
        $relatorio=4;
    }


    switch ($relatorio) {
        case 1:
            for ($i = $de; $i <= $ate; $i++) {
                $sql = "SELECT a.id_apontamento,
                a.gepro,
                a.descricao,
                a.entrada,
                a.hora_inicio,
                a.hora_fim,
                a.tempo_total,
                a.usuario,
                a.cliente,
                b.descricao_atividade
                FROM TB_APONTAMENTO a
                LEFT JOIN TB_ATIVIDADE b ON a.atividade = b.id_atividade OR a.atividade IS NULL
                WHERE gepro = $i
                ORDER BY entrada ASC";
                $result = mysqli_query($conexao, $sql);
            
                if(!empty($result) && mysqli_num_rows($result) > 0){

        ?>
            <h3 id="h3">Filtro - Gepro:<?php echo $i?></h3>
            <table>
                <thead>
                    <tr>
                        <th>CLIENTE</th>
                        <th>DATA</th>
                        <th>INÍCIO</th>
                        <th>TÉRMINO</th>
                        <th>ATIVIDADE</th>
                        <th>DESCRIÇÃO</th>
                        <th>TOTAL</th>
                        <th>CODIFICADOR</th>
                    </tr>
                </thead>
                <tbody>
        <?php
                    while ($row = mysqli_fetch_assoc($result)){
                    $data = $row['entrada'];  
                    $descricao = $row['descricao'];  
                    $gepro = $row['gepro'];  
                    $hora_fim = $row['hora_fim'];  
                    $hora_inicio = $row['hora_inicio'];  
                    $descricao_atividade = $row['descricao_atividade'];  
                    $usuario = $row['usuario'];  
                    $cliente = $row['cliente']; 


                    $horas =$row['tempo_total'];
                    $minutos =$row['tempo_total'];
                    $segundos =$row['tempo_total'];
                    
                    $horas = floor ($horas / 3600);
                    $minutos = floor ($minutos % 3600 / 60 );
                    $segundos = floor ($segundos % 60 );
        ?>
                        <tr>
                        <td><?php echo $cliente?></td>
                        <td><?php echo $data?></td>
                        <td><?php echo $hora_inicio?></td>
                        <td><?php echo $hora_fim?></td>
                        <td><?php echo $descricao_atividade?></td>
                        <td><?php echo $descricao?></td>
                        <td><?php echo "$horas:$minutos:$segundos"?></td>
                        <td><?php echo $usuario?></td>
                        </tr>
        <?php
                    }
        ?>
                </tbody>
            </table>
        <?php
                }
            }
            
            break;

        case 2:
            for ($i = $inicio_data; $i <= $termino_data; $i++) {
                $sql = "SELECT a.id_apontamento,
                a.gepro,
                a.descricao,
                a.entrada,
                a.hora_inicio,
                a.hora_fim,
                a.tempo_total,
                a.usuario,
                a.cliente,
                b.descricao_atividade
                FROM TB_APONTAMENTO a
                LEFT JOIN TB_ATIVIDADE b ON a.atividade = b.id_atividade OR a.atividade IS NULL
                WHERE entrada = '$i'
                ORDER BY entrada ASC";
                $result = mysqli_query($conexao, $sql);
            
                if(!empty($result) && mysqli_num_rows($result) > 0){
            ?>
                <h3>Filtro - Data:<?php echo $i?> </h3>
                <table>
                    <thead>
                        <tr>
                            <th>CLIENTE</th>
                            <th>DATA</th>
                            <th>INÍCIO</th>
                            <th>TÉRMINO</th>
                            <th>ATIVIDADE</th>  
                            <th>DESCRIÇÃO</th>
                            <th>TOTAL</th>
                            <th>CODIFICADOR</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                        while ($row = mysqli_fetch_assoc($result)){
                        $data = $row['entrada'];  
                        $descricao = $row['descricao'];  
                        $hora_fim = $row['hora_fim'];  
                        $hora_inicio = $row['hora_inicio'];  
                        $descricao_atividade = $row['descricao_atividade'];  
                        $usuario = $row['usuario'];  
                        $cliente = $row['cliente']; 


                        $horas =$row['tempo_total'];
                        $minutos =$row['tempo_total'];
                        $segundos =$row['tempo_total'];
                        
                        $horas = floor ($horas / 3600);
                        $minutos = floor ($minutos % 3600 / 60 );
                        $segundos = floor ($segundos % 60 );
            ?>
                            <tr>
                            <td><?php echo $cliente?></td>
                            <td><?php echo $data?></td>
                            <td><?php echo $hora_inicio?></td>
                            <td><?php echo $hora_fim?></td>
                            <td><?php echo $descricao_atividade?></td>
                            <td><?php echo $descricao?></td>
                            <td><?php echo "$horas:$minutos:$segundos"?></td>
                            <td><?php echo $usuario?></td>
                            </tr>
            <?php
                        }
            ?>
                    </tbody>
                </table>
            <?php
                    }
                }
            break;

        case 3:
            for ($i = $de; $i <= $ate; $i++) {
                $sql = "SELECT a.id_apontamento,
                a.gepro,
                a.descricao,
                a.entrada,
                a.hora_inicio,
                a.hora_fim,
                a.tempo_total,
                a.usuario,
                a.cliente,
                b.descricao_atividade
                FROM TB_APONTAMENTO a
                LEFT JOIN TB_ATIVIDADE b ON a.atividade = b.id_atividade OR a.atividade IS NULL
                WHERE gepro = $i
                AND usuario ='$usuario'
                ORDER BY entrada ASC";
                $result = mysqli_query($conexao, $sql);
            
                if(!empty($result) && mysqli_num_rows($result) > 0){
        ?>
            <h3>Filtro - Gepro:<?php echo $i ." / ". $usuario ?> </h3>
            <table>
                <thead>
                    <tr>
                        <th>CLIENTE</th>
                        <th>DATA</th>
                        <th>INÍCIO</th>
                        <th>TÉRMINO</th>
                        <th>ATIVIDADE</th>  
                        <th>DESCRIÇÃO</th>
                        <th>TOTAL</th>
                        <th>CODIFICADOR</th>
                    </tr>
                </thead>
                <tbody>
        <?php
                    while ($row = mysqli_fetch_assoc($result)){
                    $data = $row['entrada'];  
                    $descricao = $row['descricao'];  
                    $hora_fim = $row['hora_fim'];  
                    $hora_inicio = $row['hora_inicio'];  
                    $descricao_atividade = $row['descricao_atividade'];  
                    $usuario = $row['usuario'];  
                    $cliente = $row['cliente']; 


                    $horas =$row['tempo_total'];
                    $minutos =$row['tempo_total'];
                    $segundos =$row['tempo_total'];
                    
                    $horas = floor ($horas / 3600);
                    $minutos = floor ($minutos % 3600 / 60 );
                    $segundos = floor ($segundos % 60 );
        ?>
                        <tr>
                        <td><?php echo $cliente?></td>
                        <td><?php echo $data?></td>
                        <td><?php echo $hora_inicio?></td>
                        <td><?php echo $hora_fim?></td>
                        <td><?php echo $descricao_atividade?></td>
                        <td><?php echo $descricao?></td>
                        <td><?php echo "$horas:$minutos:$segundos"?></td>
                        <td><?php echo $usuario?></td>
                        </tr>
        <?php
                    }
        ?>
                </tbody>
            </table>
        <?php
                }
            }
            break;

            case 4:
                for ($i = $inicio_data; $i <= $termino_data; $i++) {
                    $sql = "SELECT a.id_apontamento,
                    a.gepro,
                    a.descricao,
                    a.entrada,
                    a.hora_inicio,
                    a.hora_fim,
                    a.tempo_total,
                    a.usuario,
                    a.cliente,
                    b.descricao_atividade
                    FROM TB_APONTAMENTO a
                    LEFT JOIN TB_ATIVIDADE b ON a.atividade = b.id_atividade OR a.atividade IS NULL
                    WHERE entrada = '$i'
                    AND usuario = '$usuario'
                    ORDER BY entrada ASC";
                    $result = mysqli_query($conexao, $sql);
                
                    if(!empty($result) && mysqli_num_rows($result) > 0){
            ?>
                <h3>Filtro - Data:<?php echo $i ." / ". $usuario?> </h3>
                <table>
                    <thead>
                        <tr>
                            <th>CLIENTE</th>
                            <th>DATA</th>
                            <th>INÍCIO</th>
                            <th>TÉRMINO</th>
                            <th>ATIVIDADE</th>  
                            <th>DESCRIÇÃO</th>
                            <th>TOTAL</th>
                            <th>CODIFICADOR</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                        while ($row = mysqli_fetch_assoc($result)){
                        $data = $row['entrada'];  
                        $descricao = $row['descricao'];  
                        $total = $row['tempo_total'];  
                        $hora_fim = $row['hora_fim'];  
                        $hora_inicio = $row['hora_inicio'];  
                        $descricao_atividade = $row['descricao_atividade'];  
                        $usuario = $row['usuario'];  
                        $cliente = $row['cliente']; 

            ?>
                            <tr>
                            <td><?php echo $cliente?></td>
                            <td><?php echo $data?></td>
                            <td><?php echo $hora_inicio?></td>
                            <td><?php echo $hora_fim?></td>
                            <td><?php echo $descricao_atividade?></td>
                            <td><?php echo $descricao?></td>
                            <td><?php echo $total?></td>
                            <td><?php echo $usuario?></td>
                            </tr>
            <?php
                        }
            ?>
                    </tbody>
                </table>
            <?php
                    }
                }
                break;
    }
    ?>
</div>

<input type="button" class="btn btn-danger btn-sm" value="EXPORTAR PDF" id="btnImprimir" onclick="CriaPDF()" />

<script>
        function CriaPDF() {
        var minhaTabela = document.getElementById('tabela').innerHTML;
        var style = "<style>";
        style = style + "table {width: 100%;font: 12px Calibri;}";
        style = style + "table, td {border: dotted 1px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: center;}";
        style = style + ".retangulo {width: 100%; border: dotted 1px #c3ced2; display:flex;";
        style = style + "#img {width: 15vh; padding: 5px;";
        style = style + "h3{font-size: medium;};";
            
        style = style + "</style>";
        // CRIA UM OBJETO WINDOW
        var win = window.open('', '', 'height=700,width=700');
        win.document.write('<html><head>');
        win.document.write('<title>Relátorio Apontamentos</title>');   // <title> CABEÇALHO DO PDF.
        win.document.write(style);                                     // INCLUI UM ESTILO NA TAB HEAD
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(minhaTabela);                          // O CONTEUDO DA TABELA DENTRO DA TAG BODY
        win.document.write('</body></html>');
        win.document.close(); 	                                         // FECHA A JANELA
        win.print();                                                            // IMPRIME O CONTEUDO
    }
</script>




</body>
</html>