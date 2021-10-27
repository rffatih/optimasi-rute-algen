<div>
  Ke pengaturan <a href="/?pengaturan">List Object</a>
</div>
<hr/>

<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = @$_POST['start'];
    $time = @$_POST['time'];
    $simpan_attribute = new SimpanAttribute;
    $simpan_attribute->index($start, $time);
  }

  $konek = new koneksi;
  $sql= "SELECT * FROM attribute";
  $run = $konek->eksekusi($sql);
  $data = [];
  while ($row = mysqli_fetch_assoc($run)) {
    $data[$row['kode']] = $row['nama'];
  }
?>

<div class="box-shadow p-2">
  <label for="start">Titik Mulai</label><br/>
  <input type="text" name="start" id="start" value="<?=$data['start']?>">
</div>
<div class="box-shadow p-2 mt-4">
  <label for="time">Satuan Waktu</label><br/>
  <input type="text" name="time" id="time" value="<?=$data['time']?>">
</div>

<div class="mt-4">
  <input type="submit" id="submit" value="Simpan"/>
</div>