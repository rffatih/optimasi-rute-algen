<html>
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="/antarmuka/styles/css.css" />
	<script type="text/javascript" src="/antarmuka/scripts/script.js"></script>
	<title>indonesia Raya Jaya - Algoritma Genetik</title>
</head>

<body>
<div id="bingkai">

	<?php
		// HARUS DIHAPUS
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		// END
		include("proses_utama/kontrol.php");

		$shield = new Shield;
		$shield->index();

		$form = false;
		$headerPHP = @$_REQUEST["antarmuka"];
		$query_params = @$_GET["pengaturan"];

		if($query_params == "matrix"){
			$form = true;
			echo '<form action="/?pengaturan=matrix" method="post">';
		}
		else if($query_params == "attribute"){
			$form = true;
			echo '<form action="/?pengaturan=attribute" method="post">';
		}
		else if($query_params !== null){
			$form = true;
			echo '<form action="/?pengaturan" method="post">';
		}
		else if ($headerPHP === 'form2') {
			$form = true;
			echo '<form action="index.php" method="post" name="cekForm" onSubmit="return formJanganKosong(0)">';
		}
		else if (empty($headerPHP)) {
			$form = true;
			echo '<form action="index.php" method="post" onSubmit="return checkbox(0)">';
		}
	?>

	<div id="header">
		<div id="header_kiri">
			<a href="index.php"><img src="/antarmuka/images/garuda.png" class="logo"></a>
		</div>
		<div id="header_kanan">
			Wisata Malang Raya
		</div>
		<?php
		$tombol = true;

		$atribut_form2 = '
		<div class="atribut">
			<div class= "nama_atribut">popSize</div>
			<input type="text" name="popsize" id="ok" value="100" onkeypress="return hanyaAngka(event)">
		</div>
		<div class="atribut">
			<div class= "nama_atribut">pc</div>
			<input type="text" name="pc" id="ok" value="0.7" onkeypress="return hanyaAngka(event)">
		</div>
		<div class="atribut">
			<div class= "nama_atribut">pm</div>
			<input type="text" name="pm" id="ok" value="0.8" onkeypress="return hanyaAngka(event)">
		</div>
		<div class="atribut">
			<div class= "nama_atribut">banyak waktu</div>
			<input type="text" name="durasi" id="ok" value="600" onkeypress="return hanyaAngka(event)">
		</div>
		<div class="atribut">
			<div class= "nama_atribut">Iterasi</div>
			<input type="text" name="iterasi" id="ok" value="50" onkeypress="return hanyaAngka(event)">
		</div>
		<div class="atribut">
			<div class= "nama_atribut"><i>elitism</i></div>
			<input type="text" name="persentase" id="ok" value="20" onkeypress="return hanyaAngka(event)">
		</div>';

		$atribut_proses = '
		<div id = "header_sekunder">
			Mencari Rute Optimal
		</div>
		';

		$atribut_form1 = '
		<div id = "header_sekunder">
			Algoritma Genetika ( <a href="/?pengaturan">pengaturan</a> )
		</div>';

		$atribut_hasil = '
		<div id = "header_sekunder">
			Hasil Rekomendasi Sistem
		</div>
		';

		$atribut_pengaturan = '
		<div id = "header_sekunder">
			Pengaturan ( <a href="/">Beranda</a> )
		</div>
		';

		# format <tag> header HTML yang diaturdiatur oleh PHP
		$headerPHP = @$_REQUEST["antarmuka"];

		if ($headerPHP == "form2"){
			echo $atribut_form2;
		}
		else if ($headerPHP == "proses"){
			echo $atribut_proses;
		}
		else if ($headerPHP == "hasil"){
			echo $atribut_hasil;
		}
		else if (isset($_GET['pengaturan'])){
			echo $atribut_pengaturan;
		}
		else {
			echo $atribut_form1;
		}
		# akhir --------------------------
		?>
	</div>

	<div id="konten">
		<?php
			$start = new kontrol;
			$start->index();
		?>
	</div>

	<div id="footer">
		<img src="/antarmuka/images/bingkai.jpg" class="footer">
	</div>
</div>

<?php
if ($form) {
	echo "</form>";
}
?>

</body>

</html>
