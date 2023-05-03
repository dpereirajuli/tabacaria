<?php
define('HOST', '108.179.193.10:3306');
define('USUARIO', 'bwtecn91');
define('SENHA', 'n9v6A1fk3N');
define('DB', 'bwtecn91_bdrefrin');

$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die ('Não foi possível conectar');

$usuario ='reginaldo.fagundes';
$data_inicio = '2023-01-01';
$data_termino = '2023-04-16';


$de=0;
$ate=0;

if(!empty($de) && ($ate)){

  $sql = "SELECT * 
          FROM TB_APONTAMENTO
          WHERE gepro >= $de
          AND gepro <= $ate";
  $result = mysqli_query($conexao, $sql);

  // Cria um array com os resultados
  $data = array();
  while ($row = mysqli_fetch_assoc($result)) {

      if($row>0){
          $data[] = $row;
      }
    
  }

  // Loop for que cria várias tabelas
  for ($i = 0; $i < 5; $i++) {
    // Cria a estrutura básica da tabela

    
    // Loop foreach que itera sobre os dados do banco de dados e cria as linhas da tabela
    foreach ($data as $row) {
      echo "<table>";
      echo "<h2>Filtro - Gepro: ".$row['gepro']."</h2>";
      echo "<thead><tr><th>DATA</th><th>INICÍO</th><th>TÉRMINO</th><th>DESCRIÇÃO</th><th>TOTAL</th></tr></thead>";
      echo "<tbody>";
      echo "<tr><td>".$row['entrada']."</td><td>".$row['hora_inicio']."</td><td>".$row['hora_fim']."</td><td>".$row['descricao']."</td><td>".$row['tempo_total']."</td></tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
  }
}



////// PESQUISA POR USUARIO

if(!empty($usuario) && ($data_inicio) && ($data_termino) || $data_inicio < $data_termino){

  $sql2 = "SELECT MAX(gepro) AS maior_gepro, 
            MIN(gepro) AS menor_gepro
          FROM TB_APONTAMENTO
          WHERE entrada >= '$data_inicio'
          AND entrada <= '$data_termino'
          AND usuario ='$usuario'
          ORDER BY gepro asc";
  $result2 = mysqli_query($conexao, $sql2);

    if(!empty($result2) && mysqli_num_rows($result2) > 0){

      while ($row2 = mysqli_fetch_assoc($result2)) {
        $menor_gepro = $row2['menor_gepro'];
        $maior_gepro= $row2['maior_gepro'];
      }
         

        for ($i = $menor_gepro; $i < $maior_gepro; $i++) {

          
          $sql = "SELECT * 
          FROM TB_APONTAMENTO
          WHERE gepro <= $i
          AND usuario ='$usuario'";
          
          echo "<h2>$i</h2>";

          $sql = "SELECT * 
          FROM TB_APONTAMENTO
          WHERE gepro = '$i'
          AND usuario ='$usuario'
          ORDER BY gepro asc";

          $result = mysqli_query($conexao, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
           
              echo "<table>";
              echo "<thead><tr><th>GEPRO</th><th>DATA</th><th>INICÍO</th><th>TÉRMINO</th><th>DESCRIÇÃO</th><th>TOTAL</th></tr></thead>";
              echo "<tbody>";
              echo "<tr><td>".$row['gepro']."</td><td>".$row['entrada']."</td><td>".$row['hora_inicio']."</td><td>".$row['hora_fim']."</td><td>".$row['descricao']."</td><td>".$row['tempo_total']."</td></tr>";
              echo "</tbody>";
              echo "</table>";
          }
        }
    }
  }





?>


