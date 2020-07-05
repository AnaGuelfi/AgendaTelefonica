<?php

	// Remover dados no banco de dados

	include("conexao.php");
	
	$id = $_GET["id"];

	$remocao = "DELETE FROM contato WHERE id_contato ='$id'";

	mysqli_query($conexao,$remocao)
			or die(mysqli_error($conexao));
	echo "1";
	
?>