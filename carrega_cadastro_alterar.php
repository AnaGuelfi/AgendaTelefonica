<?php
	
	// Retornar dados do banco de dados no formato JSON, após serem alterados
	
	header ("Content-Type: Application/json");
	
	include("conexao.php");
	
	$id = $_POST["id"];
	
	$sql = "SELECT nome, celular, telefone, email, endereco FROM contato WHERE id_contato = '$id' ORDER BY nome";
	
	$resultado = mysqli_query($conexao,$sql) or die ("Erro." . mysqli_query($conexao));
	
	$linha = mysqli_fetch_assoc($resultado);
	
	echo json_encode($linha);
	
?>