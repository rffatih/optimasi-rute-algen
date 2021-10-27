<?php

class evaluasi{
	public function index ($durasi, $individu_string, $lama_objek, $stringLend, $objekwisata){
		# [1] koneksi ke database
		$koneksi = new koneksi;

		# [1.1] jika berhasil terhubung database
		if ($koneksi){

			# [1.1.1] mengambil list objek dari database (inisialisasi list objek = $list_objek)
			$query="SELECT * FROM list_object";
			$run = $koneksi->eksekusi($query);
			if($run){
				while ($data = mysqli_fetch_assoc($run)) {
					$list_objek[] = $data;
				}
			}
			# akhir: [1.1.1]

			# [1.1.2] mengambil matrik jarak dari database (inisialisasi matrik jarak = $matrik_jarak)
			$query="SELECT * FROM matrix_jarak";
			$run = $koneksi->eksekusi($query);
			if ($run){
				while ($data = mysqli_fetch_assoc($run)) {
					$matrik_jarak[] = $data;
				}
			}
			# akhir: [1.1.2]

			# [1.1.3] inisialisasi individu ke dalam array = $individu
			$buffer = explode("|", $individu_string);
			for($i=0; $i<(count($buffer)); $i++){
				$individu[$i] = explode(",", $buffer[$i]);
			}
			# akhir: [1.1.3]

			# [1.1.4] inisialisasi lama per objek wisata ke array = $lama_objek
			$lama_objek = explode(",", $lama_objek);
			# akhir: [1.1.4]

			# [1.1.5] mencari fitnes, pengulangan dilakukan sebanyak jumlah individu
			for ($in=0; $in<(count($individu)); $in++){

				$x_total = null;
				$y_total = null;
				$penjumlahan_waktu = 0;
				$waktu_lolos = 0;
				$gen_ke_n = 0;
				$sigma_y = 0;
				$sigma_x = 0;

				# [1.1.5.1] mencari lama tempuh antar gen dalam setiap individu, pengulangan dilakukan sebanyak stringLeng
				for($i=0; $i<$stringLend; $i++){

					# [1.1.5.1.1] gen pertama lama tempuh = 0
					if ($i == 0){
						foreach ($matrik_jarak as $value) {
							if ($value['kode'] === $individu[$in][$i]) {
								$x = $value['awal'];
							}
						}
					}
					#akhir: [1.1.5.1.1]
					
					# [1.1.5.1.2] mencari lama tempuh gen kedua dst.
					else{
						foreach ($matrik_jarak as $value) {
							if ($value['kode'] === $individu[$in][$i-1]) {
								$x = $value[$individu[$in][$i]];
							}
						}
					}
					# akhir: [1.1.5.1.2]

					# [1.1.5.1.3] memasukkan lama tempuh gen terpilih ke dalam urutan deret array = $x_total
					$x_total[] = $x;
					# akhir: [1.1.5.1.3]
				}
				# akhir: [1.1.5.1]

				# [1.1.5.2] mencari lama di objek wisata setiap gen pada individu, pengulangan dilakukan sebanyak stringLeng
				for($i=0; $i<$stringLend; $i++){

					# [1.1.5.2.1] mencari lama di objek wisata suatu gen sesuai data pada array $lama_objek
					$objek_wisata = explode(",", $objekwisata);
					for($j=0; $j<(count($objek_wisata)); $j++){
						if($individu[$in][$i] == $objek_wisata[$j])
							$y = $lama_objek[$j];
					}
					# akhir: [1.1.5.2.1]

					# [1.1.5.2.2] memasukkan nilai lama di objek wisata pada gen terpilih ke dalam urutan deret array = $y_total
					$y_total[] = $y;
					# akhir: [1.1.5.2.2]
				}
				# akhir: [1.1.5.2]

				# [1.1.5.3] menghitung banyak gen yang lolos ketentuan & mencatat waktu yang produktif
				for($i=0; $i<$stringLend; $i++){
					$penjumlahan_waktu += $x_total[$i] + $y_total[$i];
					if($penjumlahan_waktu <= $durasi){
						$waktu_lolos = $penjumlahan_waktu;
						$gen_ke_n += 1;
						$sigma_x += $x_total[$i];
						$sigma_y += $y_total[$i];
					}
				}
				# akhir: [1.1.5.3], produk -> $waktu_lolos & &gen_ke_n

				// $sisa_waktu = $durasi - $waktu_lolos;

				# [1.1.5.4] menghitung rumus fitnes setiap individu
				if($sigma_x == 0)
					$sigma_x = 0.001;
				$individu[$in][] = ($gen_ke_n * $sigma_y) / $sigma_x;
				# akhir: [1.1.5.4]

				# [1.1.5.5] menghitung banyak gen yang dikunjungi
				$individu[$in][] = $gen_ke_n;
				# akhir: [1.1.5.5]
			}
			# akhir: [1.1.5]

			# [1.1.6] kapsulasi $individu untuk proses pengiriman
			for($i=0; $i<count($individu); $i++){
				$a[] = implode(",", $individu[$i]);
			}
			$return = implode("|", $a);
			# akhir: [1.1.6]

			return $return;
		}
		# akhir: [1.1]

		# [1.2] jika gagal terhubung
		else
			return "gagal terhubung ke datase";
		# akhir: [1.2]

		# akhir: [1]
	}
}


?>
