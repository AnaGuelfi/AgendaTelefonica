<?php
	
	// Conexão com o banco de dados
	
	$user = "root";
	$senha = "usbw";
	$banco = "agenda";
	$server = "localhost";
	
	$conexao = mysqli_connect($server, $user, $senha, $banco);
	
	mysqli_set_charset($conexao,"utf8");
?>