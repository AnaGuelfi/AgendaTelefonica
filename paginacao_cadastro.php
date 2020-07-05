<?php
	
	// Paginação: exibir 5 dados por página
	
	include("conexao.php");
	
	$sql = "SELECT COUNT(*) AS qtd FROM contato";
	
	if(!empty($_POST)){
		$nome = $_POST["nome_filtro"];
		$sql .= " WHERE nome LIKE '%$nome%' ORDER BY nome";
	}
	
	$resultado = mysqli_query($conexao,$sql) or die ("Erro." . mysqli_query($conexao));
	
	$linha = mysqli_fetch_assoc($resultado);
	
	$qtd_tuplas = $linha["qtd"];
	
	$qtd_botoes = (int)($qtd_tuplas / 5);
	
	if ($qtd_tuplas%5!=0){
		$qtd_botoes++;
	}
	echo "<center>";
		for ($i=1; $i<=$qtd_botoes; $i++) {
			echo "<button type = 'button' class = 'rounded btn-info pg' value = '$i'>$i</button> ";
		}
	echo "</center>";
	
?>