<input type="hidden" name="antarmuka" value="form2">
Centang semua <input type="checkbox" name="allbox" onclick="checkAll(0);" /><br /> <!-- value="check" -->

<?php
$konek = new koneksi;
$koneksi = $konek->koneksi();

if($koneksi){
	$sql= "SELECT * FROM list_object";
	$run = $konek->eksekusi($sql);
	while ($buffer = mysqli_fetch_assoc($run)) {
		echo '<input
			type="checkbox"
			name="'.$buffer['kode'].'"
			id="'.$buffer['kode'].'"
			value="'.$buffer['kode'].'"
		/>
		<label for="'.$buffer['kode'].'">'. $buffer['nama'] .'</label><br />';
	}
}
else{
	echo "load list pada datebase mengalami kegagalan";
}
?>

<input type="submit" value="proses">