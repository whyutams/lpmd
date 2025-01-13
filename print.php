<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['is_logged']) && $_SESSION['user_data']['level'] != 1) {
    header("location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/popper.min.js"></script>
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./dist/fa/css/all.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/index.css">
    <title>Laporan LPMD</title>
    <script>
        window.print();
        // window.history.go(-1);
    </script>
    <style>
        #kopsur {
            width: 100%;
            border-bottom: solid 3px #000;
        }
    </style>
</head>

<body>
    <table id="kopsur">
        <tr>
            <td width="10%"><img src="./img/kab-gor.png" alt="" width="150"></td>
            <td width="90%" align="center">
                <h4>PEMERINTAHAN KABUPATEN GORONTALO <br>KECAMATAN TELAGA <br>DESA BULILA</h4><span>Jl. Wadipalapa -
                    Bulila - Telaga - Gorontalo 96138</span>
            </td>
        </tr>
        <br>
    </table>
    <br>
    <h4 style="font-weight: bold; margin-bottom: 15px;">
        Data LPMD</h4>

    <?php
    $sql = "select ag.id_anggota, ag.nama_anggota, ag.jabatan, ag.alamat, ag.nomor_telepon as notelp_anggota, k.id_kegiatan ,k.nama_kegiatan, k.tanggal_kegiatan, k.deskripsi, k.gambar, l.id_lembaga , l.nama_lembaga, l.kontak as notelp_lembaga, lp.id_lpmd from anggotaa as ag, kegiatan as k, lembaga as l, lpmd as lp where lp.id_anggota = ag.id_anggota and lp.id_kegiatan = k.id_kegiatan and lp.id_lembaga = l.id_lembaga";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table lpmd print' id='lpmd-print'>";
        echo "<tr> <th>#</th> <th>Nama Anggota</th> <th>Nama Kegiatan</th> <th>Nama Lembaga</th> <th>No. Telepon Lembaga</th> <th>Tanggal Kegiatan</th> <th>Deskripsi</th> <th>Gambar</th></tr>";
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_assoc($result);
            echo "<tr>";
            echo "<th scope='row'>" . $i + 1 . "</th>";
            echo "<td>" . $row["nama_anggota"] . "</td>";
            echo "<td>" . $row["nama_kegiatan"] . "</td>";
            echo "<td>" . $row["nama_lembaga"] . "</td>";
            echo "<td>" . $row["notelp_lembaga"] . "</td>";
            echo "<td>" . $row["tanggal_kegiatan"] . "</td>";
            echo "<td>" . $row["deskripsi"] . "</td>";
            echo "<td>" . ($row["gambar"] == "" ? "Tidak ada gambar" : "<img class='gambar' src='" . $upload_dir . $row["gambar"] . "' width='150px'>") . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Data LPMD tidak tersedia.";
    }
    ?>

    <div class="bottom" style="float: center;">
    <?php 
        $res = mysqli_query($koneksi, "select nama_anggota, lower(jabatan) as jabatan from anggotaa where jabatan = 'ketua'");
        $ketua = mysqli_fetch_assoc($res)['nama_anggota'];
    ?>
        <table class="table text-center" style="margin-top: 50px;">
            <td style="border: none;"><p>Ketua LPMD <br> &nbsp; <p style="margin-top: 75px;"><?= $ketua ?></p></p></td>
            <td style="border: none;"><p><font style="font-style: normal;">Bulila, ................... <?= date('Y') ?></font> <br>Kepala Desa Bulila<p style="margin-top: 75px;">Yusran Tine</p></p></td>
        </table>
    </div>
</body>

</html>