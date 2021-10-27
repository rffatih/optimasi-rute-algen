<?php

class iterasi{
	public function index($mulai_algoritma, $popSize, $stringLend, $pc, $pm, $durasi, $lama_objek, $objekwisata,$persentase){
		$microtime_mulai = microtime(true);
		# ---------------------------------- proses iterasi ------------------------------------
		# [1] inisialisasi
		$inisialisasi = new inisialisasi;
		$parent = $inisialisasi->index($mulai_algoritma, $popSize, $stringLend, $objekwisata,$persentase);
		# akhir: [1]

		# [2] [reproduksi]
		$proses_reproduksi = new reproduksi;
		$dataCrossover = $proses_reproduksi->crossover($pc, $popSize,$stringLend,$parent);
		$dataMutasi = $proses_reproduksi->mutasi($pm, $popSize,$stringLend,$parent);
		# akhir [2]

		# TAMPILAN
		if ($dataCrossover != null){
			$buf = explode(" ", $dataCrossover);
			$crossover          = $buf[0];
			$antarmukaCrossover = $buf[1];	
		}
		else{
			$crossover 			= null;
			$antarmukaCrossover = null;
		}
		
		if ($dataMutasi != null){
			$buf = explode(" ", $dataMutasi);
			$mutasi 		 = $buf[0];
			$antarmukaMutasi = $buf[1];	
		}
		else{
			$mutasi 		 = null;
			$antarmukaMutasi = null;
		}
		
		#--------------------------

		# [3] menggabungkan parent dan offspring menjadi kumpulan baru yang disebut "individu"
		$proses_fungsi = new fungsi;
		$individu = $proses_fungsi->index($parent, $crossover, $mutasi);
		# akhir: [3]

		# [4] evaluasi
		$proses_evaluasi = new evaluasi;
		$fitnes = $proses_evaluasi->index($durasi, $individu, $lama_objek, $stringLend, $objekwisata);
		# akhir: [4]

		# [5] seleksi
		$proses_seleksi = new seleksi;
		$seleksi = $proses_seleksi->index($fitnes, $stringLend);
		# akhir: [5]

		# -----------------------------------akhir satu iterasi ------------------------------

		$antarmuka = new antarmuka;
		$antarmuka->index($stringLend, $pm, $pc, $durasi, $popSize, $parent, $antarmukaCrossover, $crossover, $antarmukaMutasi,
			$mutasi, $individu, $fitnes, $seleksi,$persentase);

		return $seleksi;
		
	}
}

?>