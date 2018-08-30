<?php
function getConnection(){
	$server = 'localhost';
	$user = 'root';
	$password = 'root';
	$database = 'financas_pessoais';

	$connection = mysqli_connect($server, $user, $password, $database);

	if (!$connection) {
		echo "Não foi possível conectar: " . mysql_error();
		exit;
	} else {
		return $connection;
	}
}
 ?>
