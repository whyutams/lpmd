<?php 
include "fungsi.php";

$koneksi = mysqli_connect("localhost","root","",$database_name);

if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>