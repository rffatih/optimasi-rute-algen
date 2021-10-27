<?php

class LamaTempuh{
	public function index ($kodeOW){
		$koneksi = new koneksi;

		if ($koneksi){
			$qwr = "SELECT * FROM matrix_jarak";
			$jalankan = $koneksi->eksekusi($qwr);
			if ($jalankan){
				while ($data = mysqli_fetch_assoc($jalankan)) {
					$matrik_jarak[] = $data;
				}
			}

			foreach ($matrik_jarak as $value) {
				if ($kodeOW == $value['kode']) {
					$waktuTempuh = $value['awal'];
				}
			}

			return $waktuTempuh;
		}
		return false;
	}
}

?>
