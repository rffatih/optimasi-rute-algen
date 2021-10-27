<?php

class inisialisasi {
	
	public function index ($mulai_algoritma, $popSize, $stringLend, $objekwisata,$persentase) {

		# [1-a] jika ini adalah iterasi pertama
		if($mulai_algoritma == "budalawal"){

			$buffer = explode(",", $objekwisata); // bakal parent

			# [1-a.1] membuat parent sebanyak popSize
			for($i=0; $i<$popSize; $i++){
				shuffle($buffer); // mengacak susunan cromosom untuk mencari susunan random
				$chromosom[] = $buffer; // menggabungkan semua kromosom menjadi satu variabel
			}
			# akhir: [1-a.1]
		}
		# akhir: [1-a]

		# [1-b] jika ini adalah iterasi ke-2 dst.
		else {

# Perubahan elitism = yakni parent 20% dari individu pada iterasi sebelumnya
# parent selebihnya di ambil dari proses pengacakan susunan gen chromosom ulang
# saran ini dari dosen Pembimbing 1, Bapak Budi Darma Setiawan
			if ($persentase>100){
				$persentase = 100;
			}
			$dariKeturunan = $popSize * ($persentase/100);
			$dariKeturunan = ceil($dariKeturunan); // pembulatan nilai ke atas

			$dariOrangBaru = $popSize-$dariKeturunan;
# -----------------------------------------------------------------------------

			# [1-b.1] mengekstrak kapsulisasi
			$buffer = explode("|", $mulai_algoritma);
			for($i=0; $i<(count($buffer)); $i++){
				$calon_chromosom[$i] = explode(",", $buffer[$i]);
			}
			# akhir: [1-b.1]

			# [1-b.2] inisialisasi parent
			# dari keturunan
			for($i=0; $i<$dariKeturunan; $i++){
				for($j=0; $j<$stringLend; $j++){
					$chromosom[$i][$j] = $calon_chromosom[$i][$j];
				}
			}
			# dari orang baru
			$buffer = explode(",", $objekwisata); 	// bakal parent
			for($i=0; $i<$dariOrangBaru; $i++){
				shuffle($buffer); 					// mengacak susunan cromosom untuk mencari susunan random
				$chromosom[] = $buffer; 			// menggabungkan semua kromosom menjadi satu variabel
			}
			# akhir: [1-b.2]
		}
		# akhir: [1-b]

		# [2] proses kapsulasi --> untuk pengririman
		for($i=0; $i<count($chromosom); $i++){
			$a[] = implode(",", $chromosom[$i]);
		}
		$return = implode("|", $a);
		# akhir: [2]

		return $return;
	}
}

?>