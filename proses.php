<?php
session_start();
require 'koneksi.php';
if (!file_exists($upload_dir)) {
    echo "<h1>Folder $upload_dir tidak tersedia!\nGagal memuat!</h1>";
    exit;
} else {
    /* Segala proses CRUD DB dari semua page */
    if (isset($_POST['from_path'])) {
        $fp = $_POST['from_path'];
        $aksi = "";
        $locate = "index.php";

        if (isset($_POST['aksi']))
            $aksi = $_POST['aksi'];
        if ($fp == "/anggota") {
            if ($aksi == "hapus-data") {
                if (isset($_POST['id_anggota'])) {
                    $id_anggota = $_POST['id_anggota'];
                    $sql = "DELETE FROM anggotaa WHERE id_anggota = $id_anggota";
                    if (mysqli_query($koneksi, $sql)) {
                        $locate = "anggota.php?info=data-deleted";
                    } else
                        $locate = "anggota.php?info=data-notdeleted";
                } else {
                    $locate = "anggota.php?info=data-idkegiatannotfound";
                }
            } else if ($aksi == "update-data") {
                if (isset($_POST['id_anggota'])) {
                    $id_anggota = $_POST['id_anggota'];
                    if ($drow = mysqli_query($koneksi, "select * from anggotaa where id_anggota = $id_anggota")) {
                        $row = mysqli_fetch_assoc($drow);
                        $nama_anggota = $_POST['editNama'];
                        $jabatan = isset($_POST['editJabatan']) ? $_POST['editJabatan'] : $row['jabatan'];
                        $alamat = $_POST['editAlamat'];
                        $nomor_hp = $_POST['editNomor'];
                        $level = isset($_POST['editLevel']) ? $_POST['editLevel'] : $row['level'];

                        /* Keamanan */
                        if (strtolower($jabatan) == 'ketua')
                            $jabatan = $row['jabatan'];
                        if ($level <= 2 || $jabatan != $row['jabatan']) {
                            if ($_SESSION['user_data']['level'] == 1) {
                                if ($jabatan == "Ketua")
                                    $jabatan = $row['jabatan'];
                            }

                            if ($_SESSION['user_data']['level'] >= 2) {
                                $level = $row['level'];
                                if ($jabatan == "Ketua" || $jabatan == "Wakil Ketua")
                                    $jabatan = $row['jabatan'];
                            }
                        }
                        /* Keamanan END */

                        $sql = "update anggotaa set nama_anggota = '$nama_anggota', jabatan = '$jabatan', alamat = '$alamat', nomor_telepon = '$nomor_hp', level = $level where id_anggota = $id_anggota";
                        if (mysqli_query($koneksi, $sql)) {
                            $locate = "anggota.php?info=data-updated";
                        } else
                            $locate = "anggota.php?info=data-notupdated";

                        if ($result = mysqli_query($koneksi, "select * from anggotaa where id_anggota=".$_SESSION['user_data']['id_anggota'])) {
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION['user_data'] = $row;
                        }
                    } else {
                        $locate = "anggota.php?info=data-notupdated";
                    }
                } else {
                    $locate = "anggota.php?info=data-idkegiatannotfound";
                }
            } else if ($aksi == "tambah-data") {
                if (isset($_POST['addNama']) || isset($_POST['addJabatan']) || isset($_POST['addAlamat']) || isset($_POST['addNoHP']) || isset($_POST['addUsername']) || isset($_POST['addPassword']) || isset($_POST['addLevel'])) {
                    if (mysqli_query($koneksi, "INSERT INTO anggotaa VALUES ('', '" . $_POST['addNama'] . "', '" . $_POST['addJabatan'] . "', '" . $_POST['addAlamat'] . "', '" . $_POST['addNoHP'] . "', '" . $_POST['addUsername'] . "', '" . $_POST['addPassword'] . "', '" . $_POST['addLevel'] . "')")) {
                        $locate = "anggota.php?info=data-added";
                    } else
                        $locate = "anggota.php?info=data-notadded";
                } else {
                    $locate = "anggota.php?info=data-idkegiatannotfound";
                }
            }
        } else if ($fp == "/kegiatan") {
            if ($aksi == "hapus-data") {
                if (isset($_POST['id_kegiatan'])) {
                    $id_kegiatan = $_POST['id_kegiatan'];
                    if ($res = mysqli_query($koneksi, "select gambar FROM kegiatan WHERE id_kegiatan = $id_kegiatan")) {
                        $gambar = mysqli_fetch_assoc($res)['gambar'];
                        if (file_exists($upload_dir . $gambar))
                            unlink($upload_dir . $gambar);
                    }

                    if (mysqli_query($koneksi, "DELETE FROM kegiatan WHERE id_kegiatan = $id_kegiatan")) {
                        $locate = "kegiatan.php?info=data-deleted";
                    } else
                        $locate = "kegiatan.php?info=data-notdeleted";
                } else {
                    $locate = "kegiatan.php?info=data-idkegiatannotfound";
                }
            } else if ($aksi == "update-data") {
                if (isset($_POST['id_kegiatan'])) {
                    $id_kegiatan = $_POST['id_kegiatan'];

                    if ($drow = mysqli_query($koneksi, "select * from kegiatan where id_kegiatan = $id_kegiatan")) {
                        $row = mysqli_fetch_assoc($drow);
                        $nama_kegiatan = $_POST['editNama'];
                        $tanggal = $_POST['editTanggal'];
                        $deskripsi = $_POST['editDeskripsi'];
                        $gambar = isset($_FILES['editGambar']) ? $_FILES['editGambar']['name'] : "";
                        $gambar_old = isset($_POST['editGambarOld']) ? $_POST['editGambarOld'] : "";
                        $gambar = $gambar == "" ? $gambar_old : $gambar;

                        if ($gambar == "" && $gambar_old == "") {
                            $locate = "kegiatan.php?info=data-notupdated";
                        } else {
                            $id_kegiatan = $_POST["id_kegiatan"];

                            $file_name = $_FILES["editGambar"]["name"];
                            $file_temp = $_FILES["editGambar"]["tmp_name"];

                            $new_file_name = "kegiatan_" . $id_kegiatan . "_" . basename($file_name);
                            $destination = $upload_dir . $new_file_name;

                            $old_files_pattern = $upload_dir . "kegiatan_" . $id_kegiatan . "_*";
                            $old_files = glob($old_files_pattern);
                            foreach ($old_files as $old_file) {
                                if (file_exists($old_file))
                                    unlink($old_file);
                            }

                            if (move_uploaded_file($file_temp, $destination))
                                $gambar = $new_file_name;

                            $sql = "update kegiatan set nama_kegiatan = '$nama_kegiatan', tanggal_kegiatan = '$tanggal', deskripsi = '$deskripsi', gambar='$gambar' where id_kegiatan = $id_kegiatan";
                            if (mysqli_query($koneksi, $sql)) {
                                $locate = "kegiatan.php?info=data-updated";
                            } else
                                $locate = "kegiatan.php?info=data-notupdated";
                        }
                    } else {
                        $locate = "kegiatan.php?info=data-notupdated";
                    }
                } else {
                    $locate = "kegiatan.php?info=data-idkegiatannotfound";
                }
            } else if ($aksi == "tambah-data") {
                if (isset($_POST['addNama']) || isset($_POST['addBulan']) || isset($_POST['addDeskripsi'])) {
                    $gambar = "";
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["addGambar"])) {
                        $result = mysqli_query($koneksi, "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $database_name . "' AND TABLE_NAME = 'kegiatan'");
                        if (!mysqli_connect_errno()) {
                            $row = mysqli_fetch_assoc($result);
                            $next_id = $row['AUTO_INCREMENT'];

                            $file_name = $_FILES["addGambar"]["name"];
                            $file_temp = $_FILES["addGambar"]["tmp_name"];

                            $new_file_name = "kegiatan_" . $next_id . "_" . basename($file_name);
                            $destination = $upload_dir . $new_file_name;
                            echo $new_file_name . "<br>";
                            echo $destination . "<br>";

                            if (move_uploaded_file($file_temp, $destination))
                                $gambar = $new_file_name;
                        }
                    }


                    if (mysqli_query($koneksi, "INSERT INTO kegiatan VALUES ('', '" . $_POST['addNama'] . "', '" . $_POST['addTanggal'] . "', '" . $_POST['addDeskripsi'] . "', '" . $gambar . "')")) {
                        $locate = "kegiatan.php?info=data-added";
                    } else
                        $locate = "kegiatan.php?info=data-notadded";
                } else {
                    $locate = "kegiatan.php?info=data-idkegiatannotfound";
                }
            }
        } else if ($fp == "/lembaga") {
            if ($aksi == "hapus-data") {
                if (isset($_POST['id_lembaga'])) {
                    $id_lembaga = $_POST['id_lembaga'];
                    $sql = "DELETE FROM lembaga WHERE id_lembaga = $id_lembaga";
                    if (mysqli_query($koneksi, $sql)) {
                        $locate = "lembaga.php?info=data-deleted";
                    } else
                        $locate = "lembaga.php?info=data-notdeleted";
                } else {
                    $locate = "lembaga.php?info=data-idlembaganotfound";
                }
            } else if ($aksi == "update-data") {
                if (isset($_POST['id_lembaga'])) {
                    $id_lembaga = $_POST['id_lembaga'];
                    if ($drow = mysqli_query($koneksi, "select * from lembaga where id_lembaga = $id_lembaga")) {
                        $row = mysqli_fetch_assoc($drow);
                        $nama_lembaga = $_POST['editNama'];
                        $kontak = $_POST['editKontak'];

                        $sql = "update lembaga set nama_lembaga = '$nama_lembaga', kontak = '$kontak' where id_lembaga = $id_lembaga";
                        if (mysqli_query($koneksi, $sql)) {
                            $locate = "lembaga.php?info=data-updated";
                        } else
                            $locate = "lembaga.php?info=data-notupdated";
                    } else {
                        $locate = "lembaga.php?info=data-notupdated";
                    }
                } else {
                    $locate = "lembaga.php?info=data-idlembaganotfound";
                }
            } else if ($aksi == "tambah-data") {
                if (isset($_POST['addNama']) || isset($_POST['addKontak'])) {
                    if (mysqli_query($koneksi, "INSERT INTO lembaga VALUES ('', '" . $_POST['addNama'] . "', '" . $_POST['addKontak'] . "')")) {
                        $locate = "lembaga.php?info=data-added";
                    } else
                        $locate = "lembaga.php?info=data-notadded";
                } else {
                    $locate = "lembaga.php?info=data-idlembaganotfound";
                }
            }
        } else if ($fp == "/index") {
            if ($aksi == "hapus-data") {
                if (isset($_POST['id_lpmd'])) {
                    $id_lpmd = $_POST['id_lpmd'];
                    $sql = "DELETE FROM lpmd WHERE id_lpmd = $id_lpmd";
                    if (mysqli_query($koneksi, $sql)) {
                        $locate = "index.php?info=data-deleted#lpmd";
                    } else
                        $locate = "index.php?info=data-notdeleted#lpmd";
                } else {
                    $locate = "index.php?info=data-idlpmdnotfound#lpmd";
                }
            } else if ($aksi == "update-data") {
                if (isset($_POST['id_lpmd'])) {
                    $id_lpmd = $_POST['id_lpmd'];
                    if ($drow = mysqli_query($koneksi, "select * from lpmd where id_lpmd = $id_lpmd")) {
                        $row = mysqli_fetch_assoc($drow);
                        $id_lpmd = $_POST['id_lpmd'];
                        $id_kegiatan = $_POST['editNamaKegiatan'];
                        $id_lembaga = $_POST['editNamaLembaga'];
                        $id_anggota = $_POST['editNamaAnggota'];

                        $sql = "update lpmd set id_anggota = $id_anggota, id_kegiatan = $id_kegiatan, id_lembaga = $id_lembaga where id_lpmd = $id_lpmd";
                        if (mysqli_query($koneksi, $sql)) {
                            $locate = "index.php?info=data-updated#lpmd";
                        } else
                            $locate = "index.php?info=data-notupdated#lpmd";
                    } else {
                        $locate = "index.php?info=data-notupdated#lpmd";
                    }
                } else {
                    $locate = "index.php?info=data-idlpmdnotfound#lpmd";
                }
            } else if ($aksi == "tambah-data") {
                if (isset($_POST['addNamaKegiatan']) || isset($_POST['addNamaLembaga']) || isset($_POST['addNamaAnggota'])) {
                    $id_kegiatan = $_POST['addNamaKegiatan'];
                    $id_lembaga = $_POST['addNamaLembaga'];
                    $id_anggota = $_POST['addNamaAnggota'];

                    if (mysqli_query($koneksi, "INSERT INTO lpmd VALUES ('', $id_anggota, $id_kegiatan, $id_lembaga)")) {
                        $locate = "index.php?info=data-added#lpmd";
                    } else
                        $locate = "index.php?info=data-notadded#lpmd";
                } else {
                    $locate = "index.php?info=data-idlpmdnotfound#lpmd";
                }
            }
        }

        header("location:" . $locate);
    } else {
        header("location: index.php");
    }
}
?>