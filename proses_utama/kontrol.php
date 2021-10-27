<?php

include("proses_utama/algen.php");
include("proses_utama/antarmuka.php");
include("proses_utama/iterasi.php");
include("add-on/tabel.php");
include("add-on/koneksi.php");
include("add-on/fungsi.php");
include("add-on/bahan_baku.php");
include("add-on/lama_tempuh.php");
include("add-on/nama_objekWisata.php");
include("add-on/hasil_akhir.php");
include("add-on/simpan_object.php");
include("add-on/simpan_matrix.php");
include("add-on/simpan_attribute.php");
include("add-on/shield.php");
include("add-on/attribute.php");
include("algoritma_genetika/inisialisasi.php");
include("algoritma_genetika/reproduksi.php");
include("algoritma_genetika/evaluasi.php");
include("algoritma_genetika/seleksi.php");

class kontrol{
	public function index(){

		$antarmuka = @$_REQUEST["antarmuka"];
		$query_params = @$_GET["pengaturan"];

		$tampilan = new antarmuka;

		if ($antarmuka == "proses"){
			$bahanbaku = new bahanbaku;
			$a = $bahanbaku->index();

			$a = explode("|", $a);

			$popSize    = $a[0];
			$stringLend = $a[1];
			$pc         = $a[2];
			$pm         = $a[3];
			$durasi     = $a[4];
			$lama_objek = $a[5];
			$objekwisata= $a[6];
			$keAlgen	  = $a[7];
			$iterasi	  = $a[8];
			$persentase = $a[9];   // berapa persen generasi yang diselamatkan ke iterasi berikutnya

			#pengecekan keberlanjutan ke Algrotima
			if ($keAlgen == "batal"){ // -------------------- BATAL berlanjut ke Algoritma
				
				$LamaTempuh_class = new LamaTempuh;
				$LamaTempuh = $LamaTempuh_class->index($objekwisata);

				$namaOW_class = new nama_objekWisata;
				$namaOW = $namaOW_class->index($objekwisata);

				$tampilan->batalKeAlgen($lama_objek, $durasi, $LamaTempuh, $namaOW);
			}
			else{					  // -------------------- LANJUTKAN ke Algoritma
				$algen = new algoritma_genetika;
				$hasil = $algen->index($popSize, $stringLend, $pc, $pm, $durasi, $lama_objek, $objekwisata, $iterasi,$persentase);
				
				if ($hasil == false){
					$tampilan->popSizeNOL();
				}

				else{
					$tampilan->lihatHasil($hasil,$stringLend,$lama_objek,$objekwisata,$durasi);					
				}
				
			}
			# Akhir: keputusan keberlanjutan Algoritma talah ditetapkan
		}

		else if ($antarmuka == "hasil"){
			$prosesSolusi = new hasilAkhir;
			$prosesSolusi->index();
		}

		else if ($antarmuka == "form2"){
			$tampilan->form2();
		}

		else if($query_params == "matrix"){
			$tampilan->form_matrix();
		}

		else if($query_params == "attribute"){
			$tampilan->form_attribute();
		}
		
		else if($query_params !== null){
			$tampilan->form_object();
		}

		else{
			$tampilan->form1();
		}

	}
}

?>