<?php
	
	// Alterar dados no banco de dados a partir dos dados modificados pelo usuário
	
	include("conexao.php");
	
	$id = $_POST["id"];
	$nome = $_POST["nome"];
	$telefone = $_POST["telefone"];
	$celular = $_POST["celular"];
	$email = $_POST["email"];
	$endereco = $_POST["endereco"];
	
	$alteracao = "UPDATE contato SET 
				nome = '$nome',
				telefone = '$telefone',
				celular = '$celular',
				email = '$email',
				endereco = '$endereco'
				WHERE id_contato = '$id'";

	mysqli_query($conexao,$alteracao)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>