<?php

//

class antarmuka{
	public function index($stringLend, $pm, $pc, $durasi, $popSize, $parent, $amCros, $crossover, $amMut, $mutasi,
		$individu, $fitnes, $seleksi,$persentase){

		$tabel = new tabel;
		$attr = new Attribute;
		echo "<table>";
		echo "<tr><td>pc</td><td>=</td><td>$pc</td></tr>";
		echo "<tr><td>pm</td><td>=</td><td>$pm</td></tr>";
		echo "<tr><td>popSize</td><td>=</td><td>$popSize</td></tr>";
		echo "<tr><td>lama waktu yang dimiliki</td><td>=</td><td>$durasi</td></tr>";
		echo "<tr><td>titik awal keberangkatan</td><td>=</td><td>".$attr->awal_object()."</td></td></tr>";
		echo "<tr><td><i>elitism</i></td><td>=</td><td>$persentase%</td></tr>";
		echo "</table>";

# INISIALISASI ------------------------------------------------------------
		echo "<h3><center>∼ Inisialisasi ∼</center></h3>";
		echo "<div align=center>";
		echo "<u>Tabel parent</u>";
		$tabel->index($parent);
		echo "</div>";

# REPRODUKSI - CROSSOVER --------------------------------------------------
		echo "<h3><center>∼ Reproduksi ∼</center></h3>";
		echo "<h4><center><i>----- Crossover -----</i></center></h4>";
		$buf = explode(",", $amCros);
		$countBaf = count($buf);
		$codePengulangan = $stringLend + $stringLend + 3;
		if ( ($countBaf%$codePengulangan) == 0){
			$indexFor = 0;
			$pengulangan = $countBaf/$codePengulangan;

			$arrayChild = explode("|", $crossover);
			$indexChild = 0;

			for ($i=0; $i < $pengulangan; $i++) {
				$bafLokal = array_slice($buf, $indexFor, $codePengulangan);

				$parent1 = array_slice($bafLokal, 0, ($stringLend));
				$parent1_string = implode(",", $parent1);
				$pIndex1  = array_slice($bafLokal, $stringLend, 1);
				$pIndex1_string = implode(",", $pIndex1);

				$parent2 = array_slice($bafLokal, ($stringLend+1), ($stringLend));
				$parent2_string = implode(",", $parent2);
				$pIndex2 = array_slice($bafLokal, ((2*$stringLend)+1), 1);
				$pIndex2_string = implode(",", $pIndex2);

				$tipot = array_slice($bafLokal, -1);
				$tipot_string = implode(",", $tipot);

				$bufChild = null;
				$bufChild[]	 = $arrayChild[$indexChild];
				$indexChild	+= 1;
				$bufChild[]	 = $arrayChild[$indexChild];
				$indexChild += 1;
				$child 		 = implode("|", $bufChild);

				$j = $i+1;
				echo "Crossover ke-$j";
				echo "<br />titik potongnya adalah = $tipot_string";
				echo "<br />parent pertama (parent index ke $pIndex1_string): ";
				$tabel->index($parent1_string);
				echo "parent kedua (parent index ke $pIndex2_string): ";
				$tabel->index($parent2_string);
				echo "Hasilnya:";
				$tabel->index($child);
				echo "<br/>";

				$indexFor += $codePengulangan;
			}
		}
		else {
			echo "<center>Proses <b><i>Crossover</i></b> tidak berjalan, kira-kira kenapa ya...
			<br />
			<br />- Apa Anda memasukkan parameter 0 ya ?
			<br />- Mungkin <i>parent</i> kurang dari 2 ?
			<br />- Atau mungkin aplikasi lagi lelah :)
			<br />
			<br />Mau coba dari <a href='index.php'>awal</a>??<br/></center>";
		}

# REPRODUKSI - MUTASI ------------------------------------------------------
		echo "<h4><center>----- Mutasi -----</center></h4><br />";
		$buf = explode(",", $amMut);
		$countBuf = count($buf);
		$codePengulangan = $stringLend + 3;
		if (($countBuf%$codePengulangan) == 0){

			$arrayChild = explode("|", $mutasi);

			$indexFor = 0;
			$pengulangan = $countBuf/$codePengulangan;
			for ($i=0; $i < $pengulangan; $i++) {
				$bufLokal = array_slice($buf, $indexFor, $codePengulangan);

				$parent = array_slice($bufLokal, 0, ($stringLend));
				$parent_string = implode(",", $parent);
				$pIndex  = array_slice($bufLokal, $stringLend, 1);
				$pIndex_string = implode(",", $pIndex);
				$tipot1 = array_slice($bufLokal, -2, 1);
				$tipot1_string = implode(",", $tipot1);
				$tipot2 = array_slice($bufLokal, -1);
				$tipot2_string = implode(",", $tipot2);

				$child = $arrayChild[$i];

				$j = $i+1;
				echo "Mutasi ke-$j";
				echo "<br/>Titik potongnya adalah $tipot1_string dan $tipot2_string ";
				echo "<br/>parent (index ke $pIndex_string) :";
				$tabel->index($parent_string);
				echo "Hasilnya:";
				$tabel->index($child);
				echo "<br />";

				$indexFor += $codePengulangan;
			} // akhir for
		}
		else{
			echo "<center>Proses <b>Mutasi</b> tidak berjalan,
			<br />
			<br />- Parameter bernilai 0 kah ?
			<br />- Atau mungkin aplikasi yang lagi lelah :)
			<br />
			<br />Mau coba dari <a href='index.php'>awal</a>??<br/></center>";
		}

# EVALUASI -------------------------------------------------------------
		echo "<br/>";
		echo "<div align=center>";
		echo "<h3>∼ Evaluasi ∼</h3>";
		echo "<u>Tabel Semua Individu</u><br />";
		$tabel->index($individu);
		echo "<br/>";
		echo "<u>Tabel <i>Fitnes</i></u>";
		$tabel->index($fitnes);
		echo "</div>";

# SELEKSI --------------------------------------------------------------
		echo "<br />";
		echo "<div align=center>";
		echo "<h3>∼ Seleksi ∼</h3>";
		echo "<u>Tabel Hasil <i>Fitnes</i> Tertinggi</u><br />";
		$tabel->index($seleksi);
		echo "</div>";
	}

	public function form1(){
		include("antarmuka/form_1.php");
	}

	public function form2(){
		include("antarmuka/form_2.php");
	}

	public function form_object(){
		include_once("antarmuka/form_object.php");
	}

	public function form_matrix(){
		include_once("antarmuka/form_matrix.php");
	}

	public function form_attribute(){
		include_once("antarmuka/form_attribute.php");
	}

	public function popSizeNOL(){
		echo "<center><br/> Oppsss...!! :(
			<br />Aplikasi sudah berusaha, tapi terpaksa harus berhenti di sini, coba kami bantu selidiki...
			<br /><br />--- Apa popSize yang Anda masukkan <b>0</b> ya...? ---<br />
			<br />Sepertinya Aplikasi Sedang Galau
			<br />Coba bantu Aplikasi <i>move on</i> dari awal dengan <i>click</i> di bawah ini.
			<br /><a href='index.php'><img src='antarmuka/emoticon.png' class='emot' ></a>
			</center><br/><br/>";
	}

	public function lihatHasil($hasil,$stringLend,$lama_objek,$objekwisata,$durasi){
		echo "";
		echo "<div id=tombolkeHasil>
			<form action='index.php' method='post' >
			<input type='hidden' name='antarmuka' value='hasil' >
			<input type='hidden' name='susunanObjek' value='$hasil'>
			<input type='hidden' name='stringLend' value='$stringLend'>
			<input type='hidden' name='lama_objek' value='$lama_objek'>
			<input type='hidden' name='objekwisata' value='$objekwisata'>
			<input type='hidden' name='durasi' value='$durasi'>
			<input type='submit' value='Lihat Hasil'>
			</form>
			</div>";
		echo "<a class='pojok' href='index.php'>ke beranda?</a>";
	}

	public function batalKeAlgen($lama_objek,$durasi,$LamaTempuh,$namaOW) {
		$attr = new Attribute;
		$satuanWaktu = $attr->satuan_waktu();
		$waktu = $lama_objek + $LamaTempuh;
		if ($waktu <= $durasi){
			$sisaWaktu = $durasi - $waktu;
			echo "<h3>Kunjungan ke $namaOW</h3>";
			echo "<table>";
			echo "<tr>
						<td>Keberangkatan dari</td>
						<td>:</td>
						<td style='text-align: right'>
							".$attr->awal_object()."
						</td></tr>";
			echo "<tr>
						<td>Waktu Tempuh </td>
						<td>:</td>
						<td style='text-align: right'>
							$LamaTempuh $satuanWaktu
						</td></tr>";
			echo "<tr>
						<td>Lama di Lokasi</td>
						<td>:</td>
						<td style='text-align: right'>
							$lama_objek $satuanWaktu
						</td></tr>";
			echo "<tr>
						<td>Sisa Waktu</td>
						<td>:</td>
						<td style='text-align: right'>
							$sisaWaktu $satuanWaktu
						</td></tr>";
			echo "</table>";
		}
		else{
			$kurangWaktu = $durasi - $waktu;
			echo "<h3>Maaf... Waktu Anda tidak memungkinkan untuk melakukan kunjungan ke $namaOW.</h3>";
			echo "Anda membutuhkan $kurangWaktu $satuanWaktu untuk dapat melakukan kunjungan ini";
		}
	}

	public function hasilSolusi($ada,$susunanObjek_str,$namaOW_total_str, $x_total_str, $y_total_str,
		$sigma_x, $sigma_y, $waktu_terpakai, $sisa_waktu, $waktu_eksekusi, $fitness) {

		$attr = new Attribute;
		$satuanWaktu = $attr->satuan_waktu();
		if ($ada == 'y'){
		$susunanObjek = explode(",", $susunanObjek_str);
		$namaOW_total = explode(",", $namaOW_total_str);
		$x_total 	  = explode(",", $x_total_str);
		$y_total 	  = explode(",", $y_total_str);

		echo "<h3> Rekomendasi Perjalanan Dinas</h3>";
		echo "<p class='hasil'>*Keberangkatan kunjungan dimulai dari <b>".$attr->awal_object()."</b></p>";
		echo "<table class='hasil'>";
		echo "<tr>
						<th style='text-align: left'><u>Urutan</u></th>
						<th style='text-align: left'><u>Lokasi</u></th>
						<th style='text-align: left'><u>Lama Perjalanan</u></th>
						<th style='text-align: left'><u>Durasi di Lokasi</u></th>
					</tr>";
		for ($i=0; $i<count($susunanObjek); $i++){
			echo "<tr>";
			$urutan = $i+1;
			echo "<td style='text-align: center'>$urutan</td>";
			echo "<td style='text-align: left'  >$namaOW_total[$i]</td>";
			echo "<td style='text-align: right' >$x_total[$i] $satuanWaktu</td>";
			echo "<td style='text-align: right' >$y_total[$i] $satuanWaktu</td>";
			echo "</tr>";
			}
		echo "</table>";

		echo "<br/>";

		echo "<table class='hasil'>";
		echo "<tr>
				<td style='text-align: left'>
					Waktu Habis dalam Perjalanan
				</td>
				<td>:</td>
				<td style='text-align: right'>
					$sigma_x $satuanWaktu
				</td>
				</tr>";
		echo "<tr>
				<td style='text-align: left'>
					Durasi Berada di Lokasi
				</td>
				<td>:</td>
				<td style='text-align: right'>
					$sigma_y $satuanWaktu
				</td>
				</tr>";
		echo "<tr>
				<td style='text-align: left'>
					Total Waktu Kunjungan
				</td>
				<td>:</td>
				<td style='text-align: right'>
					$waktu_terpakai $satuanWaktu
				</td>
				</tr>";
		echo "<tr>
				<td style='text-align: left'>
					Sisa Waktu Luang
				</td>
				<td>:</td>
				<td style='text-align: right'>
					$sisa_waktu $satuanWaktu
				</td>
				</tr>";
		echo "<tr><td><br /></td><td></td><td></td></tr>";
		echo "<tr>
				<td style='text-align: left'>
					Waktu Eksekusi
				</td>
				<td>:</td>
				<td style='text-align: right'>
					$waktu_eksekusi detik
				</td>
				</tr>";

		echo "<tr>
				<td style='text-align: left'>
					<i>Fitness</i>
				</td>
				<td>:</td>
				<td style='text-align: right'>
					$fitness
				</td>
				</tr>";
		echo "</table>";
		}
		else{
			echo "<h3>Maaf, waktu yang Anda miliki tidak mencukupi</h3>
				Anda hanya memiliki waktu $sisa_waktu $satuanWaktu, sehingga tidak memungkinkan
				untuk melakukan kunjungan ke Lokasi.<br/><br/>
				Waktu Eksekusi Sistem = $waktu_eksekusi";

		}
	}

	public function microtime_antarmuka($eksekusi){
		echo "<div id=microtime >Waktu Eksekusi Algoritma = $eksekusi detik</div>";
	}
}

?>
