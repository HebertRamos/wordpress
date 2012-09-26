<?php

if(is_plugin_active('contato/contato.php')){
	
	global $wpdb;
	
	$result = $wpdb->query( "
		CREATE TABLE IF NOT EXISTS `wp_contato` (
		  `contato_id` int(11) NOT NULL AUTO_INCREMENT,
		  `contato_issmtp` varchar(128) DEFAULT NULL,
		  `contato_secure` varchar(128) DEFAULT NULL,
		  `contato_host` varchar(128) DEFAULT NULL,
		  `contato_port` varchar(128) DEFAULT NULL,
		  `contato_username` varchar(128) DEFAULT NULL,
		  `contato_password` varchar(128) DEFAULT NULL,
		  `contato_from` varchar(128) DEFAULT NULL,
		  `contato_destinatarios` text,
		  `contato_smtpauth` varchar(128) DEFAULT NULL,
		  PRIMARY KEY (`contato_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
	" );
	
	
}