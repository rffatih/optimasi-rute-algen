<?php

class SimpanMatrix
{
  public function index($data) {
    $koneksi = new koneksi;
    if ($koneksi) {
      if ($data) {
        $column = ['kode'];
        $values = [];
        foreach ($data as $key => $value) {
          $column[] = $key;
          $row = ["'$key'"];
          foreach ($value as $val) {
            $row[] = $val;
          }
          $values[] = "(". implode(",", $row) .")";
        }
        $column = implode(",", $column);
        $values = implode(",", $values);
        $sqlInsert = "INSERT INTO matrix_jarak ($column) VALUES $values";
        return $koneksi->eksekusi($sqlInsert);
      }
    }
    return false;
  }
}
?>