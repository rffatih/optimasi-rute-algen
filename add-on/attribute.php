<?php

class Attribute
{
  public function awal_object() {
    $result = '';
    $koneksi = new koneksi;
    $qwr = "SELECT * FROM attribute WHERE kode = 'start'";
    $run = $koneksi->eksekusi($qwr);
    while ($row = mysqli_fetch_assoc($run)) {
      $result = $row['nama'];
    }
    return $result;
  }

  public function satuan_waktu() {
    $result = '';
    $koneksi = new koneksi;
    $qwr = "SELECT * FROM attribute WHERE kode = 'time'";
    $run = $koneksi->eksekusi($qwr);
    while ($row = mysqli_fetch_assoc($run)) {
      $result = $row['nama'];
    }
    return $result;
  }
}

?>