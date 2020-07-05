<?php

	// Alterar campo (alteração INLINE)
	
	include("conexao.php");
	
	$coluna = $_POST["coluna"];
	$valor = $_POST["valor"];
	$id = $_POST["id"];
	
	$alteracao = "UPDATE contato SET 
				$coluna = '$valor'
				WHERE id_contato = '$id'";

	mysqli_query($conexao,$alteracao)
		or die(mysqli_error($conexao));
	
	echo "1";
	
?>