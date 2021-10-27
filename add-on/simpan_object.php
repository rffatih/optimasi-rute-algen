<?php

class SimpanObject
{
  public function index($data) {
    $koneksi = new koneksi;
    if ($koneksi){
      // Drop Table Matrix
      $sqlDrop = "DROP TABLE matrix_jarak";
      $koneksi->eksekusi($sqlDrop);

      // Create Table Matrix dengan struktur yang baru
      $column = '';
      foreach ($data as $key => $value) {
        $column .= " ". $value['kode'] ." INT,";
      }
      $column = preg_replace('/,\s*$/i', '', $column);
      $sqlCreate = "CREATE TABLE matrix_jarak (
        kode VARCHAR(5)	PRIMARY KEY,
        awal INT,
        $column
      )";
      $koneksi->eksekusi($sqlCreate);

      // TRUNCATE table list_object
      $sqlTruncate = "TRUNCATE TABLE list_object";
      $koneksi->eksekusi($sqlTruncate);
      
      $sqlInsert = "";
      foreach ($data as $key => $value) {
        if ($key === 0) {
          $sqlInsert .= "INSERT INTO list_object (kode, nama) VALUES";
        } 
        $sqlInsert .= " ('". $value['kode'] ."', '". $value['nama'] ."'),";
      }
      $sqlInsert = preg_replace('/,\s*$/i', '', $sqlInsert);
      if ($sqlInsert) {
        $koneksi->eksekusi($sqlInsert);
      }
    }
  }
}

?>