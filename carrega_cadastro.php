<?php
	
	// Retornar dados do banco de dados no formato JSON
	
	header ("Content-Type: Application/json");
	
	include("conexao.php");
	
	$p = $_POST["pg"];
		
	$sql = "SELECT id_contato, nome, celular, telefone, email, endereco FROM Contato";
	
	if (isset($_POST["nome_filtro"])){
		$nome = $_POST["nome_filtro"];
		$sql .= " WHERE nome LIKE '%$nome%'";
	}
	
	$sql .=" ORDER BY nome LIMIT $p,5";
	
	$resultado = mysqli_query($conexao,$sql) or die ("Erro." . mysqli_error($conexao));
	
	while ($linha = mysqli_fetch_assoc($resultado)){
		$matriz[] = $linha;
	}
	
	echo json_encode($matriz);
	
?>