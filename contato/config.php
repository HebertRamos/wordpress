<?php

require_once plugin_dir_path(__FILE__).'/ConfigContato.php';

$configContato = new ConfigContato();

if($_POST)
	$configContato->salvaConfig($_POST);

$config_contato = $configContato->getConfig();

?>

<form method="post">
	<table>
		<tr>
			<td><label>SMTP:</label></td>
			<td>
				<select name="config[contato_issmtp]">
					<option value="True" <?php echo ($config_contato->contato_issmtp == "True"? "selected='selected'":"")?>>True</option>
					<option value="False" <?php echo ($config_contato->contato_issmtp == "False"? "selected='selected'":"")?>>False</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label>SMTPAuth:</label></td>
			<td>
				<select name="config[contato_smtpauth]">
					<option value="True" <?php echo ($config_contato->contato_smtpauth == "True"? "selected='selected'":"")?>>True</option>
					<option value="False" <?php echo ($config_contato->contato_smtpauth == "False"? "selected='selected'":"")?>>False</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label>SECURE:</label></td>
			<td><input type="text" name="config[contato_secure]" value="<?php echo $config_contato->contato_secure; ?>"/></td>
		</tr>
		<tr>
			<td><label>HOST:</label></td>
			<td><input type="text" name="config[contato_host]" value="<?php echo $config_contato->contato_host; ?>"/></td>
		</tr>
		<tr>
			<td><label>PORT:</label></td>
			<td><input type="text" name="config[contato_port]" value="<?php echo $config_contato->contato_port; ?>" /></td>
		</tr>
		<tr>
			<td><label>USERNAME:</label></td>
			<td><input type="text" name="config[contato_username]" value="<?php echo $config_contato->contato_username; ?>" /></td>
		</tr>
		<tr>
			<td><label>PASSWORD:</label></td>
			<td><input type="text" name="config[contato_password]" value="<?php echo $config_contato->contato_password; ?>" /></td>
		</tr>
		<tr>
			<td><label>FROM:</label></td>
			<td><input type="text" name="config[contato_from]" value="<?php echo $config_contato->contato_from; ?>" /></td>
		</tr>
		<tr>
			<td><label>DESTINATÁRIOS:(separado por ;)</label></td>
			<td><input type="text" name="config[contato_destinatarios]" value="<?php echo $config_contato->contato_destinatarios; ?>" /></td>
		</tr>
	</table>
	
	<input type="submit" value="salva configuração" />
</form>
