<?php

class bahanbaku{
	public function index() {

		# [1] menerima input semua bahan baku yang dibutuhkan
		$popsize 		    = $_REQUEST["popsize"];
		$popsize		    = ceil($popsize);
		$pc 			      = $_REQUEST["pc"];
		$pm 			      = $_REQUEST["pm"];
		$durasi 		    = $_REQUEST["durasi"];
		$id 			      = $_REQUEST["list_id"];
		$stringlend 	  = $_REQUEST["stringlend"];
		$iterasi 		    = $_REQUEST["iterasi"];
		$persentase		  = $_REQUEST["persentase"];
		$jumlah_list_id = 0;

		# [1.1] mekanisme pencocokan setiap objek dengan lama waktunya masing-masing sesuai inputan
		$list_id = explode(",", $id);
		foreach ($list_id as $key) {
			$lama[] = $_REQUEST[$key];
			$jumlah_list_id += 1;
		}
		$lama_objek = implode(",", $lama);
		# akhir: [1.1]
		# akhir: [1]

		#pengecekan data objek wisata tunggal
		if($jumlah_list_id <=1)
			$keAlgen =  "batal";
		else
			$keAlgen = "lanjut";
		# akhir -----------------------------

		# [2] menjadikan semua data bahan baku menjadi satu array
		$kirim[] = $popsize;
		$kirim[] = $stringlend;
		$kirim[] = $pc;
		$kirim[] = $pm;
		$kirim[] = $durasi;
		$kirim[] = $lama_objek;
		$kirim[] = $id;
		$kirim[] = $keAlgen;
		$kirim[] = $iterasi;
		$kirim[] = $persentase;
		# akhir: [2]

		# [3] kapsulasi array yang berisi semua bahan baku untuk proses pengiriman
		$kirim = implode("|", $kirim);
		# akhir: [3]

		return $kirim;
	}
}

?>