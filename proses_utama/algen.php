<?php

class algoritma_genetika{
	public function index ($popSize, $stringLend, $pc, $pm, $durasi, $lama_objek, $objekwisata,$jumlahIterasi,$persentase){

		#syarat melakukan iterasi adalah $popSize tidak boleh nol
		if($popSize != 0){
			# [1] melakukan pemanggilan iterasi sebanyak yang dibutuhkan
			$iterasi = new iterasi;
			$mulai_algoritma = "budalawal";

			$i=1;
			$mulai_eksekusi = microtime(true);
			do{
				echo "<h2><center>♣ iterasi ke-$i ♣</center></h2>";
				$new_parent = $iterasi->index($mulai_algoritma, $popSize, $stringLend, $pc, $pm, $durasi, $lama_objek, $objekwisata,$persentase);	
				$mulai_algoritma = $new_parent;
				$i++;

			} while ($i <= $jumlahIterasi);
			
			$akhir_eksekusi = microtime(true);
			$eksekusi = $akhir_eksekusi - $mulai_eksekusi;

			$antarmuka = new antarmuka;
			$antarmuka->microtime_antarmuka($eksekusi);

			$return = $mulai_algoritma.":".$eksekusi;
			
			return $return;

			# akhir: [1]	
		}
		else{
			return false;
		}		
	}
}

?>