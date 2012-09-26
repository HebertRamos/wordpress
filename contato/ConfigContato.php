<?php

class ConfigContato{

	public function getConfig(){
		
		global $wpdb;
		
		$result = $wpdb->get_results("SELECT * FROM wp_contato LIMIT 1");
		
		return isset($result[0])?$result[0]:null;
	}
	
	public function salvaConfig($form){
		
		global $wpdb;
		
		$sql 		= "";
		$valores 	= "";

		$config = $this->getConfig();
		
		$campos = null;
		$valores = null;
		
		foreach ($form['config'] as $campo => $valor){
				
			$campos[] = $campo;
			$valores[] = "'".$valor."'";
		}
		
		
		if($config){
		
				$sql = "UPDATE wp_contato SET ";
		
				$sql .= $campos[0]." = ".$valores[0];
				for ($i= 0; $i < count($valores); $i++){
					$sql .= ", ".$campos[$i]." = ".$valores[$i];
				}
		
				$sql .= " WHERE contato_id = ".$config->contato_id;
		
		
		}else{
		
			$sql = "INSERT INTO wp_contato (";
		
			
			$sql .= $campos[0];
			for($i = 1; $i < count($campos); $i++){
					
				$sql .= ", ".$campos[$i];
			}
		
			$sql .= ") VALUES (";
		
			$sql .= $valores[0];
			for($i = 1; $i < count($valores); $i++){
		
				$sql .= ", ".$valores[$i];
			}
		
			$sql .= ")";
		
		
		}
		
		$result_query = $wpdb->query($sql);
		
	}


}