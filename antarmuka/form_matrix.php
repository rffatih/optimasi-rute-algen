<div>
  Ke pengaturan <a href="/?pengaturan">List Objek</a>
</div>
<hr/>
<div>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['awal']['awal'] = 0;
    foreach (@$_POST as $key => $value) {
      $kode = explode('-', $key);
      $data[$kode[0]][$kode[1]] = $value;
      if ($kode[1] === 'awal') {
        $data['awal'][$kode[0]] = $value;
      }
    }

    $simpan_matrix = new SimpanMatrix;
    $result = $simpan_matrix->index($data);
    if ($result) {
      echo "*Data Berhasil di update";
    } else {
      echo "*Perubahan Data tidak berjalan dengan baik, data rusak, silahkan ulangi proses simpan data.";
    }
  }

  $konek = new koneksi;
  $namaObject = new nama_objekWisata;
  $koneksi = $konek->koneksi();
  $emptyMatrix = true;
  if ($koneksi) {
    $selectMatrix = "SELECT * FROM matrix_jarak";
    $run = $konek->eksekusi($selectMatrix);
    if ($run) {
      if ($run->num_rows) {
        $emptyMatrix = false;
        while ($row = mysqli_fetch_assoc($run)) {
          if ($row['kode'] !== 'awal') {
            ?>
            <div class="box-shadow p-1">
              <div><?=$namaObject->index($row['kode'])?> -> <?=$row['kode']?></div>
              <div class="flex">
                <?php
                foreach ($row as $k => $v) {
                  if ($k !== 'kode') {
                    ?>
                    <div class="flex-col">
                      <label class="font-sm" for="<?=$row['kode']?>-<?=$k?>"><?=$k?></label>
                      <input class="input-matrix" type='text' name='<?=$row['kode']?>-<?=$k?>' id="<?=$row['kode']?>-<?=$k?>" value="<?=$v?>" onkeypress="return hanyaAngka(event)"/>
                    </div>
                    <?php
                  }
                }
                ?>
              </div>
            </div>
            <?php
          }
        }
      }
    }


    if ($emptyMatrix) {
      $sql= "SELECT * FROM list_object";
      $run = $konek->eksekusi($sql);
      $list_object = [];
      while ($row = mysqli_fetch_assoc($run)) {
        $list_object[] = $row;
      }
  
      foreach ($list_object as $key => $value) {
        ?>
        <div class="box-shadow p-1">
          <div><?=$value['nama']?> (<?=$value['kode']?>)</div>
          <div class="flex">
            <div class="flex-col">
              <label class="font-sm" for="<?=$value['kode']?>-awal">Awal</label>
              <input class="input-matrix" type='text' name='<?=$value['kode']?>-awal' id="<?=$value['kode']?>-awal" value="" onkeypress="return hanyaAngka(event)"/>
            </div>
            <?php
            foreach ($list_object as $k => $v) {
              ?>
              <div class="flex-col">
                <label class="font-sm" for="<?=$value['kode']?>-<?=$v['kode']?>"><?=$v['kode']?></label>
                <input class="input-matrix" type='text' name='<?=$value['kode']?>-<?=$v['kode']?>' id="<?=$value['kode']?>-<?=$v['kode']?>" value="" onkeypress="return hanyaAngka(event)"/>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        <?php
      }
    }
  }

  ?>
</div>
<div class="mt-4">
  <input type="submit" id="submit" value="Simpan" />
</div>
