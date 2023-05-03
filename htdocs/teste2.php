<?php
define('HOST', '108.179.193.10:3306');
define('USUARIO', 'bwtecn91');
define('SENHA', 'n9v6A1fk3N');
define('DB', 'bwtecn91_bdrefrin');

$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die ('Não foi possível conectar');



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="#" method="post">
    <label for="De:"></label>
    <input type="text" name="de">

    <label for="Até:"></label>
    <input type="text" name="ate">

    <button type="submit">filtrar</button>
</form>

<?php

$de =  $_POST['de'];
$ate = $_POST['ate'];




    for ($i = $de; $i <= $ate; $i++) {
        $sql = "SELECT * FROM TB_APONTAMENTO WHERE gepro = $i";
        $result = mysqli_query($conexao, $sql);
       
        if(!empty($result) && mysqli_num_rows($result) > 0){
?>
    <h3>Filtro - Gepro:<?php echo $i?> </h3>
    <table>
        <thead>
            <tr>
                <th>DATA</th>
                <th>INÍCIO</th>
                <th>TÉRMINO</th>
                <th>DESCRIÇÃO</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
<?php
            while ($row = mysqli_fetch_assoc($result)){
            $data = $row['entrada'];  
            $descricao = $row['descricao'];  
            $total = $row['tempo_total'];  
            $gepro = $row['gepro'];  
            $hora_fim = $row['hora_fim'];  
            $hora_inicio = $row['hora_inicio'];  
?>
                <tr>
                <td><?php echo $data?></td>
                <td><?php echo $hora_inicio?></td>
                <td><?php echo $hora_fim?></td>
                <td><?php echo $descricao?></td>
                <td><?php echo $total?></td>
                </tr>
<?php
            }
?>
        </tbody>
    </table>
<?php
        }
    }
?>




</body>
</html>