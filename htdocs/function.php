<?php
include_once("conexao.php");

function retorna($codigo, $conexao){
	$result_aluno = "SELECT * FROM tb_produto WHERE id_produto = '$codigo' LIMIT 1";
	$resultado_aluno = mysqli_query($conexao, $result_aluno);
	if($resultado_aluno->num_rows){
		$row_aluno = mysqli_fetch_assoc($resultado_aluno);
		$valores['descricao_produto'] = $row_aluno['descricao_produto'];
		$valores['valor_unitario'] = $row_aluno['valor_unitario'];
	}else{
		$valores['descricao_produto'] = 'Produto não encontrado';
	}
	return json_encode($valores);
}

if(isset($_GET['codigo'])){
	echo retorna($_GET['codigo'], $conexao);
}
?>