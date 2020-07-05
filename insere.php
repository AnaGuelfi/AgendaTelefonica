<?php
	
	// Registrar dados do formulário no banco de dados
	
	include("conexao.php");
	
	$nome = $_POST["nome"];
	$telefone = $_POST["telefone"];
	$celular = $_POST["celular"];
	$email = $_POST["email"];
	$endereco = $_POST["endereco"];
	
	$insercao = "INSERT INTO contato (nome, telefone, celular, email, endereco)
						VALUES('$nome', '$telefone', '$celular', '$email', '$endereco')";
	
	mysqli_query($conexao,$insercao)
		or die ("Erro." . mysqli_error($conexao));
	
	echo "1";
	
?>