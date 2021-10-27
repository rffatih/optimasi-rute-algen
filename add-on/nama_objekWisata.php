<?php

class nama_objekWisata{
	public function index ($kodeOW){
		$koneksi = new koneksi;
		$namaxOW = '';

		if ($koneksi){
			$qwr="SELECT * FROM list_object WHERE kode = '$kodeOW'";
			$run = $koneksi->eksekusi($qwr);
			if($run) {
				while ($data = mysqli_fetch_assoc($run)) {
					$namaxOW = $data['nama'];
				}
			}
			return $namaxOW;
		}
		return false;
	}
}

?>
