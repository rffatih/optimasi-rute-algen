<?php

class SimpanAttribute
{
  public function index($start, $time) {
    $koneksi = new koneksi;
    $updateStart = "UPDATE attribute SET nama = '$start' WHERE kode = 'start'";
    $updateTIme = "UPDATE attribute SET nama = '$time' WHERE kode = 'time'";
    $koneksi->eksekusi($updateStart);
    $koneksi->eksekusi($updateTIme);
  }
}
?>