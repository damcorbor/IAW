<?php
class Database {
	public static $db;
	public static $con;

	function Database(){
	}

	function connect(){



		// Ruta al fichero de configuración (subimos dos niveles desde este archivo)
		$configPath = __DIR__ . '/../../config.ini';

		// Comprobamos que existe y se puede leer
		if (!is_readable($configPath)) {
		    die('Falta el fichero de configuración config.ini o no tiene permisos de lectura.');
		}

		// Leemos el fichero de configuración
		$cfg = parse_ini_file($configPath, true, INI_SCANNER_TYPED);
		$db  = $cfg['database'] ?? [];

		// Cargamos los parámetros con valores por defecto por si faltan
		$host    = $db['host']    ?? 'localhost';
		$dbname  = $db['name']    ?? 'bookmedik';
		$user    = $db['user']    ?? 'bookmedik_user';
		$pass    = $db['pass']    ?? 'bookmedik_pass';
		$charset = $db['charset'] ?? 'utf8mb4';

		// Creamos la conexión
		$con = new mysqli($host, $user, $pass, $dbname);
		if ($con->connect_error) {
		    die('Error de conexión a la base de datos: ' . $con->connect_error);
		}

		// Establecemos el juego de caracteres
		if (!$con->set_charset($charset)) {
		    error_log('No se pudo establecer el charset ' . $charset . ': ' . $con->error);
		}



		$con->query("set sql_mode=''");
		return $con;
	}

	public static function getCon(){
		if(self::$con==null && self::$db==null){
			self::$db = new Database();
			self::$con = self::$db->connect();
		}
		return self::$con;
	}

}
?>
