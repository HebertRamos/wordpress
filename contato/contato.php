<?php

/*
 Plugin Name: Fomulário de Contato
Description: Esse plugin salva e envia todas as informações de um formulário de contato para um ou mais e-mails. 
Version: 0.1
Author: Hebert Ramos
License: 
License URI: https://github.com/HebertRamos
*/

require_once plugin_dir_path(dirname(dirname(dirname(__FILE__)))).'wp-admin/includes/plugin.php';
require_once plugin_dir_path(__FILE__).'/acoes.php';
require_once plugin_dir_path(__FILE__).'/post_type_contato.php';
require_once plugin_dir_path(__FILE__).'/instalacao.php';


/**
 * Função para registrar a página de configuração para envio de e-mail.
 */
function menu_config_contato(){

	add_menu_page('Config - Contato', 'Config - Contato', 10, 'contato/config.php', "", get_bloginfo('url')."/wp-content/plugins/contato/imagens/icon.png");
	add_submenu_page('contato/config.php', 'Config - Contato', 'Exemplo', 10, 'contato/exemplo.php');

}

add_action("admin_menu", "menu_config_contato");


/**
 * Função que salva o contato no banco
 * @param String $titulo
 * @param String $content
 * @param String $arquivos
 */
function salva_contato($titulo, $content, $arquivos=null){
	
	$post = array(
			'post_title'=>$titulo,
			'post_type'=>'contatos',
			'post_content'=>$content,
	);
	
	$post_id = wp_insert_post($post);
	
	if($post_id && $arquivos)
		add_post_meta($post_id, "arquivos", $arquivos);
}

/**
 * Função que envia os dados gerados por e-mail
 * @param String $content
 * @param String $table_arquivos
 * @param Strin $destinatarios_do_form
 * @return boolean
 */
function envia_email($content, $table_arquivos=null, $destinatarios_do_form=null){
	
	global $wpdb;
	
	$result = $wpdb->get_results("SELECT * FROM wp_contato LIMIT 1");
	$config_email = $result[0];
	
	$layoutEmail =' <h1>' . $_POST['contato']['titulo_formulario'] . '</h1>
				  '.$content.'
				  '.$table_arquivos;
	
	
	
	$mail = new PHPMailer();
	$mail->IsSMTP(($config_email->contato_issmtp == "True"?true:false));
	$mail->SMTPAuth     = ($config_email->contato_smtpauth == "True"?true:false); // enable SMTP authentication
	$mail->SMTPSecure   = $config_email->contato_secure;
	$mail->Host         = $config_email->contato_host; // SMTP server
	$mail->Port         = $config_email->contato_port; // set the SMTP port for the GMAIL server
	$mail->Username     = $config_email->contato_username; // eu criei esse email so pra fazer autentica��o smpt
	$mail->Password     = $config_email->contato_password; // SMTP account password
	
	$mail->IsHTML(true);
	$mail->From = $config_email->contato_from;
	$mail->FromName = wp_title('&raquo;', false);
	$mail->Subject =  $_POST['contato']['titulo_formulario'];
	$mail->Body = $layoutEmail;
	
	$destinatarios 		  = array();
	$destinatarios_plugin = array();
	$destinatarios_form   = array();
	
	if($config_email->contato_destinatarios)
		$destinatarios_plugin = explode(";", $config_email->contato_destinatarios);
	
	if($destinatarios_do_form)
		$destinatarios_form = $destinatarios_do_form;

	if(is_array($destinatarios_form))
		$destinatarios = array_merge($destinatarios_plugin, $destinatarios_form);
	else{
		if(is_string($destinatarios_form))
			$destinatarios_plugin[] = $destinatarios_form;
		
		$destinatarios = $destinatarios_plugin;
	}
	

	if($destinatarios) {
		foreach ($destinatarios as $destinatario)
			$mail->AddAddress(trim($destinatario));
	
		if($mail->Send ())
			return true;
		else{
			return false;
		}
	}
	
	return true;
}





