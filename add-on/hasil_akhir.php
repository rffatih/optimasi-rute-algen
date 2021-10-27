<?php

class hasilAkhir{
	public function index (){

		# [1] Persiapan Data yang akan diproses
		$dataTransfer = $_REQUEST["susunanObjek"];
		$stringLend   = $_REQUEST["stringLend"];
		$lamaObjek    = $_REQUEST["lama_objek"];
		$lama_objek   = explode(",", $lamaObjek);
		$objekWisata  = $_REQUEST["objekwisata"];
		$objek_wisata = explode(",", $objekWisata);
		$durasi		  = $_REQUEST["durasi"];

		$dataTransfer_buf = explode(":", $dataTransfer);
		$dataTransfer = $dataTransfer_buf[0];
		$waktu_eksekusi = $dataTransfer_buf[1];

		$buf = explode("|", $dataTransfer);
		for($i=0; $i<count($buf); $i++){
			$buffer[] = explode(",", $buf[$i]);
		}
		# Akhir [1]

		# [2] Seleksi fitness
		for($i=0; $i<count($buffer); $i++){
			if($buffer[$i][$stringLend] >= $buffer[0][$stringLend]){
				$seleksiFitness[] = $buffer[$i];
			}
		}
		# Akhir [2]

		# ---- ambil nilai fitness untuk antarmuka pengguna
		$fitness = $seleksiFitness[0][$stringLend];
		# Akhir ----

		# [3] Seleksi Konten
		# [3.1] Ambil Objek pertama
		for($i=0; $i<$seleksiFitness[0][$stringLend+1]; $i++){
			$susunanObjek[0][] = $seleksiFitness[0][$i];
		}

		/*
		Catatan:
		$seleksiFitness = {a,b,c,....,akhir} dengan fitness terbesar
		$susunanObjek   = {a,b,c,d} murni objek wisata yang telah lolos batas waktu
		*/

		if (isset($susunanObjek)){

			# [3.2] Menghapus dublikat dan menyusun susunan solusi urutan tempat wisata
			for($i=0; $i<count($seleksiFitness); $i++){
				$dublikat = "beda"; 														// reset kode dublikat
				for($j=0; $j<count($susunanObjek); $j++){
					if ( $seleksiFitness[$i][$stringLend+1] == count($susunanObjek[$j]) ){  //perbandingan banyak n objek
						# membandingkan susunan objek
						$susunan = "sama"; 													// reset kode susunan
						for($k=0; $k<$seleksiFitness[$i][$stringLend+1]; $k++){
							if( $seleksiFitness[$i][$k] != $susunanObjek[$j][$k] )
								$susunan = "beda";
						}
						if ($susunan == "sama")
							$dublikat = "sama";
					}
				}
				# Memasukkan cromosome lain yang memberikan pilihan alternatif
				if ($dublikat == "beda"){
					for($ii=0; $ii<$seleksiFitness[$i][$stringLend+1]; $ii++){
						$susunanObjekBuffer[] = $seleksiFitness[$i][$ii];
					}
					$susunanObjek[]= $susunanObjekBuffer;
					$susunanObjekBuffer = null;
				}
			}
			# Akhir: [3.2]
			# Akhir: {3}

			# [4] Koneksi ke data base dan mengambil data
			$koneksi = new koneksi;

			if ($koneksi){
				# mengambil matrik jarak
				$query="SELECT * FROM matrix_jarak";
				$run = $koneksi->eksekusi($query);
				if ($run){
					while ($data = mysqli_fetch_assoc($run)) {
						$matrik_jarak[] = $data;
					}
				}

				# mengambil list objek
				$query="SELECT * FROM list_object";
				$run = $koneksi->eksekusi($query);
				if($run){
					while ($data = mysqli_fetch_row($run)) {
						$list_objek[] = $data;
					}
				}
				# Akhir: [4]

				# [5] mencari nilai x dan y per gen dan melakukan perhitungan waktu
				for ($in=0; $in<(count($susunanObjek)); $in++){

					$namaOW_total = null;
					$x_total = null;
					$y_total = null;
					$waktu_terpakai = 0;
					$sigma_y = 0;
					$sigma_x = 0;

					# [5.1] mencari lama tempuh antar gen dalam setiap individu, pengulangan dilakukan sebanyak stringLeng
					for($i=0; $i<count($susunanObjek[$in]); $i++){
						# [5.1.1] gen pertama
						if ($i == 0){
							foreach ($matrik_jarak as $value) {
								if ($value['kode'] === $susunanObjek[$in][$i]) {
									$x = $value['awal'];
								}
							}
						}
						#akhir: [5.1.1]

						# [5.1.2] mencari lama tempuh gen kedua dst.
						else{
							foreach ($matrik_jarak as $value) {
								if ($value['kode'] === $susunanObjek[$in][$i-1]) {
									$x = $value[$susunanObjek[$in][$i]];
								}
							}
						}
						# akhir: [5.1.2]

						# [5.1.3] memasukkan lama tempuh gen terpilih ke dalam urutan deret array = $x_total
						$x_total[] = $x;
						# akhir: [5.1.3]
					}
					# akhir: [5.1]

					# [5.2] mencari lama di objek wisata setiap gen
					for($i=0; $i<count($susunanObjek[$in]); $i++){

						# [5.2.1] mencari lama di objek wisata
						for($j=0; $j<(count($objek_wisata)); $j++){
							if($susunanObjek[$in][$i] == $objek_wisata[$j])
								$y = $lama_objek[$j];
						}
						# akhir: [5.2.1]

						# [5.2.2] memasukkan nilai lama di objek wisata pada gen terpilih ke dalam urutan deret array = $y_total
						$y_total[] = $y;
						# akhir: [5.2.2]
					}
					# akhir: [5.2]

					# [5.3] menghitung banyak gen yang lolos ketentuan & mencatat waktu yang produktif
					for($i=0; $i<count($susunanObjek[$in]); $i++){
						$sigma_x += $x_total[$i];
						$sigma_y += $y_total[$i];
					}
					$waktu_terpakai = $sigma_x + $sigma_y;
					# akhir: [5.3], produk -> $waktu_lolos & &gen_ke_n

					$sisa_waktu = $durasi - $waktu_terpakai;

					# [5.4] mencari nama objek wisata
					for($i=0; $i<count($susunanObjek[$in]); $i++){

						# [5.4.1] mencari nama objek wisata
						for($j=0; $j<(count($list_objek)); $j++){
							if($susunanObjek[$in][$i] == $list_objek[$j][0])
								$namaOW = $list_objek[$j][1];
						}
						# akhir: [5.4.1]

						# [5.4.2] memasukkan nilai nama objek wisata
						$namaOW_total[] = $namaOW;
						# akhir: [5.4.2]
					}
					# akhir: [5.4]

					$susunanObjek_str = implode(",", $susunanObjek[$in]);
					$namaOW_total_str = implode(",", $namaOW_total);
					$x_total_str	  = implode(",", $x_total);
					$y_total_str	  = implode(",", $y_total);

					$ada = 'y';
					$tampilan = new antarmuka;
					$tampilan->hasilSolusi($ada,$susunanObjek_str,$namaOW_total_str, $x_total_str, $y_total_str,
					$sigma_x, $sigma_y, $waktu_terpakai, $sisa_waktu, $waktu_eksekusi, $fitness);
				}
				# akhir: [5]
			}
			else{
				echo "Koneksi terkendala";
			}
		}
		else {
			$ada				= 't';
			$susunanObjek_str	= '';
			$namaOW_total_str	= '';
			$x_total_str		= '';
			$y_total_str		= '';
			$sigma_x			= '';
			$sigma_y			= '';
			$waktu_terpakai		= '';
			$sisa_waktu			= $durasi;
			$fitness 			= '';

			$tampilan = new antarmuka;
			$tampilan->hasilSolusi($ada,$susunanObjek_str,$namaOW_total_str, $x_total_str, $y_total_str,
			$sigma_x, $sigma_y, $waktu_terpakai, $sisa_waktu, $waktu_eksekusi, $fitness);
		}
	}
}

?>
