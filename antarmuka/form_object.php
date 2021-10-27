<div>
  Ke pengaturan <a href="/?pengaturan=matrix">Tabel Matrix</a><br />
  Ke pengaturan <a href="/?pengaturan=attribute">Attribute</a>
</div>
<hr/>
<div id="form-object">
  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nama = @$_POST['nama'];
      $kode = @$_POST['kode'];
      if ($nama && $kode) {
        $data = [];
        foreach ($nama as $key => $value) {
          if ($value && $kode[$key]) {
            $data[] = ['kode' => $kode[$key], 'nama' => $value];
          }
        }
        $simpan_object = new SimpanObject;
        $simpan_object->index($data);
      }
    }

    $konek = new koneksi;
    $koneksi = $konek->koneksi();
    if ($koneksi) {
      $sql= "SELECT * FROM list_object";
      $run = $konek->eksekusi($sql);
      $index = 0;
      while ($row = mysqli_fetch_assoc($run)) {
        ?>
        <div class="flex box-shadow p-1">
          <div class="flex-col">
            <label class="font-sm" for="kode[<?=$index?>]">Kode</label>
            <input type='text' name='kode[<?=$index?>]' id="kode[<?=$index?>]" value="<?=$row['kode']?>" onkeypress="return onlyLetter(event)" />
          </div>
          <div class="flex-col ml-4">
            <label class="font-sm" for="nama[<?=$index?>]">Nama</label>
            <input type='text' name='nama[<?=$index?>]' id="nama[<?=$index?>]" value="<?=$row['nama']?>" />
          </div>
        </div>
        <?php
        $index++;
      }
    }
  ?>
</div>

<div class="mt-4">
  <img class="pointer" src="/antarmuka/images/add.png" style="width: 1.2rem; height: 1.2rem;" alt="add" onclick="tambahFieldObject()" />
  <input type="submit" id="submit" value="Simpan" class="ml-4" />
</div>