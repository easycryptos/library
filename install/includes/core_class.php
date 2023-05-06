<?php

class Core {
	// Function to write the config file
	function write_config($data) {

		// Config path
		$template_path 	= 'config/Database.php';
		$output_path 	= '../app/Config/Database.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace('%HOSTNAME%',$data['db_host'],$database_file);
		$new  = str_replace('%USERNAME%',$data['db_user'],$new);
		$new  = str_replace('%PASSWORD%',$data['db_password'],$new);
		$new  = str_replace('%DATABASE%',$data['db_name'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
}