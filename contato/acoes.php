<?php


/**
 * Função que registra um formulário no JavaScript onde será realizado o ajaxForm do mesmo quando submetido. 
 * @param String $form_id
 * @param String $button_submit_id
 * @param Array  $args_erro
 * @param Array  $args_sucesso
 * @param String $elemnto_loading. Caso queria trocar a imagem de loading, acessar .../plugins/contato/imagens/loagding.gif.
 */
function registra_formulario_contato($form_id, $button_submit_id, $args_erro=null, $args_sucesso=null, $elemnto_loading=null){

	
?>

	<script src="<?php echo plugin_dir_url(__FILE__); ?>js/jquery.form.js" type="text/javascript"></script>

	<script>
			$(document).ready(function() {

 			var button_submit_id = '<?php echo $button_submit_id; ?>'
			var form_id 		 = '<?php echo $form_id; ?>'
			var plugin_url		 = '<?php echo plugin_dir_url(__FILE__).'salva_contato.php'?>';

			 var id_elemento_sucesso = '<?php echo (is_array($args_sucesso) && isset($args_sucesso['id_elemento_mensagem'])?$args_sucesso['id_elemento_mensagem']:"") ?>';	
			 var mensagem_sucesso	= '<?php echo (is_array($args_sucesso) && isset($args_sucesso['mensagem'])?$args_sucesso['mensagem']:"")?>'

			 var id_elemento_erro = '<?php echo (is_array($args_erro) && isset($args_erro['id_elemento_mensagem'])?$args_erro['id_elemento_mensagem']:"") ?>';	
			 var mensagem_erro	  = '<?php echo (is_array($args_erro) && isset($args_erro['mensagem'])?$args_erro['mensagem']:"")?>'
		    		
			var id_elemento_loading	  = '<?php echo ($elemnto_loading? $elemnto_loading: "") ?>';
			
			 
			 $("#"+button_submit_id).click(function(){

				 if(id_elemento_erro != ""){
					 $("#"+id_elemento_erro).hide();
				 }

				 if(id_elemento_sucesso != ""){
					 $("#"+id_elemento_sucesso).hide();
				 }

				 if(id_elemento_loading != "") {
					 $("#"+id_elemento_sucesso).html("<image src=\"<?php echo plugin_dir_url(__FILE__)."/imagens/loading.gif" ?>\" />");
					 $("#"+id_elemento_sucesso).show();
				 }

				 $("#"+form_id).ajaxForm({
					 
					     success:function(data) {

					       if(id_elemento_loading != "") {
					    	   $("#"+id_elemento_sucesso).hide();
					       }

					       if(data.mensagem == "sucesso"){

								var mensagem = "";
								if(mensagem_sucesso != ""){
									mensagem = mensagem_sucesso;
								}
								else{
									mensagem = "Dados enviados com sucesso!!";
								}

								if(id_elemento_sucesso != ""){
									$("#"+id_elemento_sucesso).html(mensagem);
									$("#"+id_elemento_sucesso).show();
								}
								else{
									alert(mensagem);
								}
					    	 }else{
					    		 var mensagem = "";
					    		 if(mensagem_erro != "" && data.campo == ""){
					    			 	mensagem = mensagem_erro;
								 }
								 else{
								   mensagem = data.mensagem;
								 }

								 if(id_elemento_erro != ""){
								 	$("#"+id_elemento_erro).html(mensagem);
								 	$("#"+id_elemento_erro).show();
								 	$('input[name='+data.campo+']').focus();
								 }
								 else{
								 	alert(mensagem);
								 }
			
						   	 }
						     return false;
						 },
							 
						 error : function(){

							 
							 var mensagem = "";
							 if(mensagem_erro != ""){
									mensagem = mensagem_erro;
							 }
							 else{
							   mensagem = "Erro ao enviar dados!!";
							 }

							 if(id_elemento_erro != ""){
							 	$("#"+id_elemento_erro).html(mensagem);
							 	$("#"+id_elemento_erro).show();
							 }
							 else{
							 	alert(mensagem);
							 }
							 return false;
						 },
						 
						 dataType: 'json',
						 
					     url: plugin_url,
					     resetForm: false
					     
				 }).submit();

				 return false;		
				 
			 });
		    
		
		});
	</script>
 
<?php
 	
}