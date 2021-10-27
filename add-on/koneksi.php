<?php

define('DB_SERVER', getenv('MYSQL_HOST'));  // alamat server database
define('DB_USERNAME', getenv('MYSQL_USER'));  // username masuk database
define('DB_PASSWORD', getenv('MYSQL_PASSWORD'));  // passpord masuk database
define('DB_DATABASE', getenv('MYSQL_DATABASE'));	// nama database yang dipilih

class koneksi {
	public function koneksi() {
		$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		if ($db) {
			return $db;
		}
	}
	public function eksekusi($query)
	{
		$db = $this->koneksi();
		if($db)
		{
			$data = mysqli_query($db,$query);
			return $data;
		}
		else
		{
			return false;
		}
	}
}


?>
