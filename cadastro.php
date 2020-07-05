<!--Formulário para coleta de dados do usuário e funções do sistema para cumprir as principais operações.-->

<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Agenda Telefônica</title>
		<meta charset = "UTF-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		
		<link rel = "stylesheet" href = "css/bootstrap.min.css" />

		<script src = "js/jquery-3.4.1.min.js"></script>	
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
		<script>
			
			var id = null;
			var filtro = null;
			
			$(function(){
				
				// Cadastrar contato
				
				$(document).on("click",".cadastrar",function(){
					$.ajax({ 
						url: "insere.php",
						type: "post",
						data: {nome:$("input[name='nome']").val(), telefone:$("input[name='telefone']").val(), celular:$("input[name='celular']").val(),email:$("input[name='email']").val(), endereco:$("input[name='endereco']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Contato cadastrado!");
							}else {
								console.log(data);
							}
						}
					});
				});
				
				// Paginação
				
				paginacao(0);
				
				function paginacao(p) {
					$.ajax ({
						url: "carrega_cadastro.php",
						type: "post",
						data: {pg: p, nome_filtro: filtro},
						success: function(matriz){
							$("#identificador").html("");
							for(i=0;i<matriz.length;i++){
								linha = "<tr class = 'table-info'>";
								linha += "<td class = 'nome text-danger'>" + matriz[i].nome + "</td>";
								linha += "<td class = 'telefone text-danger'>" + matriz[i].telefone + "</td>";
								linha += "<td class = 'celular text-danger'>" + matriz[i].celular + "</td>";
								linha += "<td class = 'email text-danger'>" + matriz[i].email + "</td>";
								linha += "<td class = 'endereco text-danger'>" + matriz[i].endereco + "</td>";
								linha += "<td><button type = 'button' class = 'rounded btn-info alterar' value ='" + matriz[i].id_contato + "'>Alterar</button> <button type = 'button' class = 'rounded btn-info excluir' value ='" + matriz[i].id_contato + "'>Excluir</button></td>";
								linha += "</tr>";
								$("#identificador").append(linha);
							}
						}
					});
				}
				
				$(document).on("click",".pg",function(){
					p = $(this).val();
					p = (p-1)*5;
					paginacao(p);
				});
				
				// Alterar contato
				
				$(document).on("click",".alterar",function(){
					id = $(this).attr("value");
					$.ajax({
						url: "carrega_cadastro_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("input[name='nome']").val(vetor.nome);
							$("input[name='telefone']").val(vetor.telefone);
							$("input[name='celular']").val(vetor.celular);
							$("input[name='email']").val(vetor.email);
							$("input[name='endereco']").val(vetor.endereco);
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar");
						}
					});
				});
				
				$(document).on("click",".alteracao",function(){
					$.ajax({ 
						url: "altera.php",
						type: "post",
						data: {id: id, nome:$("input[name='nome']").val(), telefone:$("input[name='telefone']").val(), celular:$("input[name='celular']").val(),email:$("input[name='email']").val(), endereco:$("input[name='endereco']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Contato alterado!");
								paginacao(0);
								$("input[name='nome']").val("");
								$("input[name='telefone']").val("");
								$("input[name='celular']").val("");
								$("input[name='email']").val("");
								$("input[name='endereco']").val("");
								$(".alteracao").attr("class","cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else {
								console.log(data);
							}
						}
					});
				});
				
				// Excluir contato
				
				$(document).on("click", '.excluir', function(){
					id = $(this).attr("value");
					linha = $(this).closest("tr");
					$.ajax({
						url: "excluir.php",
						type: "GET", 
						data:{id: id},

						success: function(data){
							if(data==1){
								$("#resultado").html("Contato excluído!");
								
								linha.remove();
							}else{
								$("#resultado").html("Erro: Contato não pode ser excluído.");
								console.log(data);
							}
						}
					});
				});
				
				// Filtrar contatos pelo Nome
				
				$("#filtrar").click(function(){
					$.ajax ({
						url: "paginacao_cadastro.php",
						type: "post",
						data: {nome_filtro: $("input[name='nome_filtro']").val()},
						success:  function(d){
							$("#paginacao").html(d);
							filtro = $("input[name='nome_filtro']").val();
							paginacao(0);
						}
					});
				});
				
				// Alteração INLINE (Nome)
				
				$(document).on("click",".nome",function(){
					td = $(this);
					nome = td.html();
					td.html("<input type = 'text' id='nome_alterar' name = 'nome' value = '" + nome + "' />");
					td.attr("class","nome_alterar");
				});
				$(document).on("blur",".nome_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "altera_inline.php",
						type: "post",
						data: {coluna: 'nome', valor: $("#nome_alterar").val(), id: id_linha},
						
						success: function(){
							nome = $("#nome_alterar").val();
							td.html(nome);
							td.attr("class","nome");
						}
					});
				});
				
				// Alteração INLINE (Telefone)
				
				$(document).on("click",".telefone",function(){
					td = $(this);
					telefone = td.html();
					td.html("<input type = 'tel' id='telefone_alterar' name = 'telefone' value = '" + telefone + "' />");
					td.attr("class","telefone_alterar");
				});
				$(document).on("blur",".telefone_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "altera_inline.php",
						type: "post",
						data: {coluna: 'telefone', valor: $("#telefone_alterar").val(), id: id_linha},
						
						success: function(){
							telefone = $("#telefone_alterar").val();
							td.html(telefone);
							td.attr("class","telefone");
						}
					});
				});
				
				// Alteração INLINE (Celular)
				
				$(document).on("click",".celular",function(){
					td = $(this);
					celular = td.html();
					td.html("<input type = 'tel' id='celular_alterar' name = 'celular' value = '" + celular + "' />");
					td.attr("class","celular_alterar");
				});
				$(document).on("blur",".celular_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "altera_inline.php",
						type: "post",
						data: {coluna: 'celular', valor: $("#celular_alterar").val(), id: id_linha},
						
						success: function(){
							celular = $("#celular_alterar").val();
							td.html(celular);
							td.attr("class","celular");
						}
					});
				});
				
				// Alteração INLINE (E-mail)
				
				$(document).on("click",".email",function(){
					td = $(this);
					email = td.html();
					td.html("<input type = 'email' id='email_alterar' name = 'email' value = '" + email + "' />");
					td.attr("class","email_alterar");
				});
				$(document).on("blur",".email_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "altera_inline.php",
						type: "post",
						data: {coluna: 'email', valor: $("#email_alterar").val(), id: id_linha},
						
						success: function(){
							email = $("#email_alterar").val();
							td.html(email);
							td.attr("class","email");
						}
					});
				});
				
				// Alteração INLINE (Endereço)
				
				$(document).on("click",".endereco",function(){
					td = $(this);
					endereco = td.html();
					td.html("<input type = 'text' id='endereco_alterar' name = 'endereco' value = '" + endereco + "' />");
					td.attr("class","endereco_alterar");
				});
				$(document).on("blur",".endereco_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "altera_inline.php",
						type: "post",
						data: {coluna: 'endereco', valor: $("#endereco_alterar").val(), id: id_linha},
						
						success: function(){
							endereco = $("#endereco_alterar").val();
							td.html(endereco);
							td.attr("class","endereco");
						}
					});
				});
				
			});
		
		</script>
		
	</head>

	<body>
		
		<center>
			<div class='container'>
				<h1>Agenda Telefônica</h1>
			</div>
		</center>
		<br />
		<div class='container rounded table-info w-25'>
		
			<h3>Cadastrar contatos</h3>
			
			<form>
				<input type = "text" class = "rounded" name = "nome" placeholder = "Nome..." /> <br /><br />
				<input type = "tel" class = "rounded" name = "telefone" placeholder = "Telefone..." /><br /><br />
				<input type = "tel" class = "rounded" name = "celular" placeholder = "Celular..." /><br /><br />
				<input type = "email" class = "rounded" name = "email" placeholder = "E-mail..." /><br /><br />
				<input type = "text" class = "rounded" name = "endereco" placeholder = "Endereço..." /><br /><br />
				<input type = "button" class = "btn-info rounded cadastrar" value = "Cadastrar" />
			</form>
			<br />
			
			<div id = "resultado" class="text-center font-weight-bold"></div>
			<br />
			
			<h3>Buscar contato</h3>
			
			<form name = 'filtro'>
				<input type = "text" class = "rounded" name = "nome_filtro" placeholder = "Nome..." /><br /><br />
				<button type = "button" class = "btn-info rounded" id = "filtrar">Filtrar</button><br /><br />	
			</form>
			
		</div>
		<br />
		
		<div class = "container">
		
			<table class = "table table-bordered table-sm text-center" border = '1'>
							
				<thead>
					<tr class = "bg-info text-white">
						<th colspan="6">Contatos</th>
					</tr>
					<tr class = "bg-info text-white">
						<th class = "text-white">Nome</th>
						<th class = "text-white">Telefone</th>
						<th class = "text-white">Celular</th>
						<th class = "text-white">E-mail</th>
						<th class = "text-white">Endereço</th>
						<th class = "text-white">Ação</th>
					</tr>
				 </thead>
			
				<tbody id = 'identificador'></tbody>
			
			</table>
		
		</div>
		
		<br />
			
		<div id = "paginacao">
		
			<?php
				
				include("conexao.php");

				include("paginacao_cadastro.php");
				
			?>
		
		</div>
		
	</body>
	
</html>