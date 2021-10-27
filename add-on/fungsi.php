<?php

// class ini berfungsi menggabungkan parent dan semua offspring ke dalam satu variabel = $individu

class fungsi {
	public function index($hasil_parent, $hasil_cross, $hasil_mut){
		# [1] inisialisasi parent ke array = $parent
		$buffer = explode("|", $hasil_parent);
		for($i=0; $i<(count($buffer)); $i++){
			$parent[$i] = explode(",", $buffer[$i]);
		}
		# akhir: [1]

		# [2] inisialisasi offspring dari crossover ke array = $cross
		if ($hasil_cross != null){
			$buffer = explode("|", $hasil_cross);
			for($i=0; $i<(count($buffer)); $i++){
				$cross[$i] = explode(",", $buffer[$i]);
			}
		}		
		# akhir: [2]

		# [3] inisialisasi offspring dari mutasi ke array = $mut
		if ($hasil_mut != null){
			$buffer = explode("|", $hasil_mut);
			for($i=0; $i<(count($buffer)); $i++){
				$mut[$i] = explode(",", $buffer[$i]);
			}	
		}
		# akhir: [3]

		# [4] memasukkan array $parent ke array = $individu
		foreach ($parent as $key) {
			$individu[] = $key;
		}
		# akhir: [4]

		# [5] memasukkan array $cross ke array = $individu
		if ($hasil_cross != null){
			foreach ($cross as $key) {
				$individu[] = $key;
			}	
		}		
		# akhir: [5]

		# [6] memasukkan array $mut ke array = $individu
		if ($hasil_mut != null){
			foreach ($mut as $key) {
				$individu[] = $key;
			}	
		}		
		# akhir: {6}

		# [7] kapsulasi $individu untuk proses pengiriman
		for($i=0; $i<count($individu); $i++){
			$a[] = implode(",", $individu[$i]);
		}
		$return = implode("|", $a);
		# akhir: [7]

		return $return;
	}
}

?>