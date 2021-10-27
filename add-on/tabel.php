<?php 

class tabel {
	public function index($bahan) {
		# mengembalikan nilai chromosom (string) ke dalam array
		$buffer = explode("|", $bahan);
		for($i=0; $i<(count($buffer)); $i++){
			$chromosom[$i] = explode(",", $buffer[$i]);
		}

		echo "<table border=1 width=700 >";
		for ($i=0; $i<(count($chromosom)); $i++){
			echo "<tr>";
			for($j=0; $j<(count($chromosom[$i])); $j++){
				echo "<td>";
				echo $chromosom[$i][$j];
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";

	}
}

?>