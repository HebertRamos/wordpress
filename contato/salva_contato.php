<?php

include_once dirname(dirname(dirname(dirname(__FILE__)))).'/wp-config.php';
include_once dirname(__FILE__).'/includes/PHPMailer/class.phpmailer.php';


/**
 * Validação dos campos.
 */
foreach ($_POST['contato'] as $campo=>$form){
	
	
	if(isset($form['validar']) && trim($form['validar']) == ""){
		
		die(json_encode(array('mensagem'=>"Campo $campo Obrigatório!!", 'campo'=>"contato[${campo}][validar]")));
	}
}


$content 		= "";
$table_arquivos = "";

/**
 * Montagem da tabela dos dados tipo text do formulário
 */
$content .= "<table width='600' border='0' cellspacing='0' cellpadding='0'>";
foreach ($_POST['contato'] as $campo => $valor){
	if(is_array($valor) && (isset($valor['validar']) || isset($valor['nao_validar'])) ){
		
		$chave  = isset($valor['validar'])?'validar':'nao_validar';
		
		$content .= "<tr>";
		$content .= "	<td>".$campo.":</td>";
		$content .=	"	<td>".$valor[$chave] ."</td>";
		$content .=	"</tr>";
	}
}
$content .= "</table>";

/**
 * Montagem da tabela dos dados tipo Arquivo do formulário
 */
if($_FILES){
	
	$path_upload = wp_upload_dir();
	$path = $path_upload['path']."/";
	
	$table_arquivos .= "<h2>Arquivos</h2><table width='600' border='0' cellspacing='0' cellpadding='0'>";
	foreach ($_FILES['contato']['tmp_name'] as $campo=>$arquivos){
		
		$chave  = isset($arquivos['validar'])?'validar':'nao_validar';
		
		$extensaoArquivo = explode(".", $_FILES['contato']["name"][$campo][$chave]);
		$extensaoArquivo = $extensaoArquivo[1];
		$nomeArquivo = time().".".$extensaoArquivo;
		
		$arquivo = $path.$nomeArquivo;
		
		move_uploaded_file($arquivos[$chave], $arquivo);
		
		$table_arquivos .= "<tr>";
		$table_arquivos .= "	<td>".$campo.":</td>";
		$table_arquivos .=	"	<td><a href='".(site_url())."/wp-content/uploads/".$path_upload["subdir"]."/".$nomeArquivo."' target='blank'>";
		
		if($extensaoArquivo == "jpg" || $extensaoArquivo == "gif" || $extensaoArquivo == "png" || $extensaoArquivo == "jpeg")
			$table_arquivos .= "<img src='".(site_url())."/wp-content/uploads/".$path_upload["subdir"]."/".$nomeArquivo."' />";
		else 
			$table_arquivos .= "<img src='".(site_url())."/wp-content/plugins/contato/imagens/download.png' />";
		$table_arquivos .=	"   </a></td>";
		$table_arquivos .=	"</tr>";
		
	}
	$table_arquivos .= "</table>";
}


/**
 * Grava o post no banco com tabela de texts e arquivos.
 */
salva_contato($_POST['contato']['titulo_formulario'], $content, $table_arquivos);

/**
 * 
 */
$retorno = envia_email($content, $table_arquivos, isset($_POST["contato"]["add-destinatario"])? $_POST["contato"]["add-destinatario"]:null);

if($retorno)
	die(json_encode(array('mensagem'=>'sucesso')));
else
	die(json_encode(array('mensagem'=>'erro')));





