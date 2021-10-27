<?php

class reproduksi{
	public function crossover($pc, $popSize,$stringLend,$parent_asal){

		# syarat crossover adalah popSize (parent) minimal 2 atau lebih
		if ($popSize >= 2){
			$c_offspring = $pc*$popSize;
			$c_offspring =  ceil($c_offspring); // pembulatan nilai ke atas
		}
		else{
			$c_offspring = 0;
		}		

		# [0] mengembalikan nilai parent ke dalam array = $parent
		$buffer = explode("|", $parent_asal);
		for($i=0; $i<(count($buffer)); $i++){
			$parent[$i] = explode(",", $buffer[$i]);
		} # akhir: [0]

		# [1] crossover
		$inOff = 0;
		for($i=0; $i<$c_offspring; $i++){	// pengulangan: dilakukan sebanyak nilai pm		
			# [1.1] mencari parent
			
			# [1.1.1] mencari parent pertama = $n
			$n=rand(0,($popSize-1));
			# akhir: [1.1.1]
			
			# [1.1.2] mencari parent kedua = $m
			$m=rand(0,($popSize-1)); 
			# [1.1.2.1] memastikan nilai n dan m tidak bernilai sama
			if ($m == $n){
				do{
					$m=rand(0,($popSize-1)); // $m diacak ulang
				}while ($m==$n);
			# akhir: [1.1.2.1] perulangan berlanjut jika m dan n masih bernilai sama
			} 
			# akhir: [1.1.2]

			# [1.1.3] inisialisasi parent berdasar angka acak yang telah ditentukan
			$p1 = $parent[$n];
			$p2 = $parent[$m];
			# akhir: [1.1.3]

#---------------- ambil data untuk interface ---------------------------
				$p_c=implode(",", $p1);			
				$pIndex= $n+1;					
				$parentCrossover[] = $p_c;		
				$parentCrossover[] = $pIndex;	
				$p_c=implode(",", $p2);			
				$pIndex= $m+1;					
				$parentCrossover[] = $p_c;		
				$parentCrossover[] = $pIndex;
#------------------- akhir ---------------------------------------------

			# akhir: [1.1]
			
			# [1.2] mencari titik potong chromosom
			$titik_potong = rand(0, ($stringLend-1));
			# akhir: [1.2]

#---------------- ambil data untuk interface ---------------------------
				$tikpot = $titik_potong + 1;	
				$parentCrossover[] = $tikpot;	
#------------------- akhir ---------------------------------------------			
			
			# [1.3] proses crossover

			# [1.3.1] offspring anak pertama

			# [1.3.1.1] mengisi gen offspring dengan gen bagian awal titik potong dari parent pertama
			for($ii=0; $ii<=$titik_potong; $ii++){
				$offspring[$inOff][]= $p1[$ii]; // pengulangan: memasukkan nilai gen urutan pertama sampai gen di titik potong
			}
			# akhir: [1.3.1] 

			# [1.3.1.2] mengisi gen offspring dengan gen dari parent kedua
			for($ii=0; $ii<$stringLend; $ii++){
				# [1.3.2.1] memasukkan gen yang nilainya sementara belum ada di deretan stringLend offspring
				$sama = false;
				for($jj=0; $jj<(count($offspring[$inOff])); $jj++){
					if ($p2[$ii] == $offspring[$inOff][$jj]) // mengecek apakah nilai gen tertunjuk sudah ada atau belum
						$sama = true;
				}
				if (!$sama) // jika belum ada, maka nilai gen tertunjuk diinputkan ke offspring
					$offspring[$inOff][]= $p2[$ii];
				# akhir: [1.3.2.1]
			}
			# akhir: [1.3.1.2]

			$inOff += 1;

			# akhir: [1.3.1]

			# [1.3.2] offspring anak ke dua

			# [1.3.2.1] mengisi gen offspring dengan gen bagian akhir dari parent pertama
			for($ii=($titik_potong+1); $ii<$stringLend; $ii++){
				$offspring[$inOff][]= $p1[$ii]; // pengulangan: memasukkan nilai gen dari tipot sampai gen terakhir
			}
			# akhir: [1.3.2.1]

			# Perbaikan bug (index offset jika titik potong = gen terakhir dari parent)
			$xxx = 0;
			if ($titik_potong != ($stringLend-1)){
				$xxx = count($offspring[$inOff]);
			}
			# --------------

			# [1.3.2.2] mengisi gen offspring dari parent ke dua
			for($ii=0; $ii<$stringLend; $ii++){
				# [1.3.2.1] memasukkan gen yang nilainya sementara belum ada di deretan stringLend offspring
				$sama = false;
				for($jj=0; $jj<($xxx); $jj++){
					if ($p2[$ii] == $offspring[$inOff][$jj]) // mengecek apakah nilai gen tertunjuk sudah ada atau belum
						$sama = true;
				}
				if (!$sama) // jika belum ada, maka nilai gen tertunjuk diinputkan ke offspring
					$offspring[$inOff][]= $p2[$ii];
				# akhir: [1.3.2.1]
			}
			# akhir: [1.3.2.2]

			$inOff += 1;

			# akhir: [i.3.2]

			# akhir: [1.3]
		}
		# akhir: [1]

		# [2] kapsulasi hasil crossover untuk proses pengiriman
		if ($c_offspring != 0){
			for($i=0; $i<count($offspring); $i++){
				$a[] = implode(",", $offspring[$i]);
			}	
			$ember[] = implode("|", $a);               // kapsulasi offspring hasil dari mutasi
			$ember[] = implode(",", $parentCrossover); // kapsulasi data yang di butuhkan untuk interface
			$return = implode(" ", $ember);            // data dan interface dipisahkan "spasi"
		}
		else {
			$return = null;
		}
		
		# akhir: [2]
		
		return $return;
	}


	public function mutasi($pm, $popSize,$stringLend,$parent_asal) {
		$m_offspring = $pm*$popSize;
		$m_offspring = ceil($m_offspring); // pembulatan nilai ke atas

		# [1] inisialisasi nilai parent ke dalam array = $parent
		$buffer = explode("|", $parent_asal);
		for($i=0; $i<(count($buffer)); $i++){
			$parent[$i] = explode(",", $buffer[$i]);
		} # akhir: [1]

		# proses mutasi [2]
		for ($i=0; $i<$m_offspring ; $i++) {
			# [2.1] menentukan parent
			$n = rand(0, ($popSize-1)); // mencari angka acak
			$p = $parent[$n];           // memilih parent sesuai angka acak
			# akhir: [2.1]

#---------------- ambil data untuk interface ---------------------------
			$p_m=implode(",",$p);
			$pIndex=$n+1;
			$parentMutasi[] = $p_m;	
			$parentMutasi[] = $pIndex;
#------------------- akhir ---------------------------------------------

			# [2.2] menentukan titik mutasi
			$x=rand(0,($stringLend-1)); // menentukan titik mutasi 1 (x)
			$y=rand(0,($stringLend-1)); // menentukan titik mutasi 2 (y)
			# akhir: [2.2]

			# [2.3] jika nilai y sama dengan nilai x
			if ($y == $x){
				do{
					$y=rand(0,($stringLend-1)); // nilai y diacak ulang
				}while ($y==$x); # akhir: [2.1] perulangan berlanjut jika y dan x bernilai sama
			}
			# akhir: [2.3]

#---------------- ambil data untuk interface ---------------------------
			$tikmut1 = $x+1;
			$parentMutasi[] = $tikmut1;
			$tikmut2 = $y+1;
			$parentMutasi[] = $tikmut2;
#------------------- akhir ---------------------------------------------

			# [2.4] proses penukaran gen indek x dengan y
			$penampung = $p[$x];
			$p[$x] = $p[$y];
			$p[$y] = $penampung;
			# akhir: [2.4]

			$offspring[$i] = $p; // inisialisasi hasil offspring yang telah jadi
		}
		# akhir: [2]

		# [3] kapsulasi offspring untuk proses pengiriman
		if ($m_offspring !=0){
			for($i=0; $i<count($offspring); $i++){
				$a[] = implode(",", $offspring[$i]);
			}
			$ember[] = implode("|", $a);            // kapsulasi offspring hasil Mutasi
			$ember[] = implode(",", $parentMutasi); // data yang digunakan untuk interface
			$return = implode(" ", $ember);			// data dan interface dipisahkan tanda "spasi"
		}
		else{
			$return = null;
		}

		# akhir: [3]

		return $return;
	}
}

?>