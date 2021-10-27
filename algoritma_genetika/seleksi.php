<?php

class seleksi {
	public function index($fitnes_arr, $stringLend){
		
		# [1] inisialisasi fitnes ke dalam bentuk array $fitnes
		$buffer=explode("|", $fitnes_arr);
		for($i=0; $i<count($buffer); $i++){
			$fitnes[] = explode(",", $buffer[$i]);
		}
		# akhir: [1]

		# [2] mengurutkan nilai fitnes
		for($i=0; $i<count($fitnes); $i++){
			for($j=$i; $j<count($fitnes); $j++){
				if($fitnes[$j][$stringLend] > $fitnes[$i][$stringLend]) {
					$tmp = $fitnes[$j];
					$fitnes[$j] = $fitnes[$i];
					$fitnes[$i] = $tmp;
				}
			}
		}
		# akhir: [2]

		# [3] kapsulasi $fitnes untuk proses pengiriman
		for($i=0; $i<count($fitnes); $i++){
			$a[]=implode(",", $fitnes[$i]);
		}
		$return = implode("|", $a);
		# akhir: [3]

		return $return;
	}
}

?>