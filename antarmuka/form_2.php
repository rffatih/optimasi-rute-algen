<input type="hidden" name="antarmuka" value="proses">
<table>
<?php
	$attr = new Attribute;
	$konek = new koneksi;
	$koneksi = $konek->koneksi();

	if($koneksi) {
		$stringlend = 0;
		$sql= "SELECT * FROM list_object";
		$run = $konek->eksekusi($sql);
		while ($buffer = mysqli_fetch_assoc($run)) {
			$kode = $buffer['kode'];
			$nama = $buffer['nama'];
			if (isset($_REQUEST[$kode])){

				$id_array[] = $kode;

				echo "<tr><td>$nama</td>";
				echo "<td> <input type='text' name='$kode' value='' onkeypress='return hanyaAngka(event)' ></td>";
				echo "<td>".$attr->satuan_waktu()."<td></tr>";

				$stringlend++;
			}

		}
	}
?>

</table>
<?php
	if ($stringlend != 0){
		$id = implode(",",$id_array);
		echo "<input type='hidden' name='list_id' value='$id'>";
		echo "<input type='hidden' name='stringlend' value='$stringlend'>";
		echo '<br /><input type="submit" id="submit" value="mulai penghitungan algoritma">';
	} else {
		echo '<a href="index.php">kembali ke Beranda</a>';
	}
?>
