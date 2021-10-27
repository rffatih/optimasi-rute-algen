<?php

class Shield
{
  public function index() {
    $query_params = @$_GET["pengaturan"];
    $redirect = false;

    if($query_params === null) {
      $redirect = true;
      $koneksi = new koneksi;
      if ($koneksi) {
        $sql = "SELECT * FROM matrix_jarak";
        $run = $koneksi->eksekusi($sql);
        if ($run) {
          if ($run->num_rows) {
            $redirect = false;
          }
        }
      }
    }
    if ($redirect) {
      header("Location:/?pengaturan");
    }
  }
}

?>