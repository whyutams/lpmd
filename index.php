<?php
include 'koneksi.php';
session_start();

if (isset($_POST['username']) && isset($_POST['password']) && !isset($_SESSION['is_logged'])) {
    $username = cleanString($_POST['username']);
    $password = cleanString($_POST['password']);

    $sql = "SELECT * FROM anggotaa WHERE username=? AND password=?";
    $stmt = mysqli_prepare($koneksi, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $_SESSION["is_logged"] = true;
        $_SESSION["user_data"] = $row;
        header("location:#");
    } else {
        echo '<script>alert("Username atau password salah.");</script>';
    }
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
    <title>LPMD - Beranda</title>
    <script>
        var __d = {
            lpmd: [
                {
                    id_lpmd: null,
                    id_kegiatan: null,
                    id_lembaga: null,
                    id_anggota: null,
                    nama_anggota: null,
                    nama_kegiatan: null,
                    no_telp_lembaga: null,
                    tanggal_kegiatan: null,
                    deskripsi: null,
                },
            ],
            kegiatan: [{
                id_kegiatan: null,
                nama_kegiatan: null,
                tanggal_kegiatan: null,
                deskripsi: null,
                gambar: null
            }],
            lembaga: [{
                id_lembaga: null,
                nama_lembaga: null,
                kontak: null,
            }],
            anggota: [{
                id_anggota: null,
                nama_anggota: null
            }]
        };
        __d.lpmd.pop();
        __d.kegiatan.pop();
        __d.lembaga.pop();
        __d.anggota.pop();

        var [kpush, lpush] = [true, 1];
    </script>
</head>

<body>
    <div class="cont">
        <?php include 'navbar.php' ?>
        <div class="bg"></div>

        <div class="konten">
            <div class="container">
                <?php
                if (isset($_SESSION["is_logged"])) {
                    echo '<h3>Selamat datang, <b>' . $_SESSION['user_data']['nama_anggota'] . '</b>!</h3>';
                }
                ?>
                <div class="ko">
                    <h3
                        style="font-weight: bold; border-left: 5px solid var(--prim-color); border-radius: 5px; padding-left: 15px; margin-bottom: 15px;">
                        Lembaga Pemberdayaan Masyarakat Desa
                    </h3>
                    <p>Lembaga Pemberdayaan Masyarakat Desa atau merupakan kepanjangan LPM Desa adalah lembaga mitra
                        strategis diluar Pemerintahan Desa yang membantu dalam meningkatkan partisipasi dan
                        pelayanan penyelenggaraan masyarakat Desa.
                    </p>
                    <p> Selain meningkatkan partisipasi dan pelayanan penyelenggaraan bagi masyarakat, LPM juga ikut
                        serta didalam perencanaan, pelaksanaan dan pembangunan yang dilakukan oleh Pemerintah Desa.
                    </p>
                    <p> Sebelum berubah nama menjadi Lembaga Pemberdayaan Masyarakat, pada Keputusan Presiden nomor
                        49 tahun 2001 tepat di bab ketentuan umum pasal 1, dahulu bernama Lembaga Ketahanan
                        Masyarakat Desa (LPMD).</p>
                </div>

                <div class="ko">
                    <?php
                    include './msginfo.php';
                    ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4
                            style="font-weight: bold; border-left: 5px solid var(--prim-color); border-radius: 5px; padding-left: 15px; margin-bottom: 15px;">
                            Data LPMD</h4>
                        <div class="d-flex align-items-center cik">
                            <?php
                            if (isset($_SESSION['is_logged'])) {
                                if ($_SESSION['user_data']['level'] == 1) {
                                    echo '<button class="btn btn-primary mr-2" style="font-size: 15px;" onclick="window.open(\'print.php\', \'_blank\');">Cetak</button>';
                                }
                                echo '<button class="btn btn-primary mr-2" style="font-size: 15px;" data-toggle="modal" data-target="#addModal">Tambah</button>';
                            }
                            ?>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari..."
                                style="max-width: 175px; width: auto;">
                        </div>
                    </div>
                    <div class="tres" style="margin-top: 10px;">
                        <?php
                        function getAnggota($id_anggota, $_ = 0, $act = "edit")
                        {
                            global $koneksi;
                            $m = "";
                            $m .= '<div class="form-group">';
                            $r1 = mysqli_query($koneksi, "select * from anggotaa");
                            if (mysqli_num_rows($r1) > 0) {
                                $m .= '<label for="' . ($act == 'add' ? 'addNamaAnggota' : 'editNamaAnggota') . '">Nama Anggota</label>';
                                $m .= '<select required class="form-control" id="' . ($act == 'add' ? 'addNamaAnggota' : 'editNamaAnggota') . '" name="' . ($act == 'add' ? 'addNamaAnggota' : 'editNamaAnggota') . '">';
                                if ($_ === 1)
                                    $m .= '<option value="" selected disabled hidden>Pilih Anggota</option>';
                                for ($i = 0; $i < mysqli_num_rows($r1); $i++) {
                                    $r = mysqli_fetch_assoc($r1);

                                    $m .= '<option value="' . $r['id_anggota'] . '"' . ($id_anggota == $r['id_anggota'] && $_ == 0 ? "selected" : "") . '>' . $r['nama_anggota'] . '</option>';
                                }
                                $m .= '</select>';
                            }
                            $m .= '</div>';

                            return $m;
                        }

                        function getLembaga($id_lembaga, $i, $_ = 0, $act = "edit")
                        {
                            global $koneksi;
                            $m = "";
                            $m .= '<div class="form-group">';
                            $r1 = mysqli_query($koneksi, "select * from lembaga");
                            if (mysqli_num_rows($r1) > 0) {
                                $m .= '<label for="' . ($act == 'add' ? 'addNamaLembaga' : 'editNamaLembaga' . $id_lembaga . $i) . '">Nama Lembaga</label>';
                                $m .= '<select required class="form-control" id="' . ($act == 'add' ? 'addNamaLembaga' : 'editNamaLembaga' . $id_lembaga . $i) . '" name="' . ($act == 'add' ? 'addNamaLembaga' : 'editNamaLembaga') . '">';
                                if ($_ === 1)
                                    $m .= '<option value="" selected disabled hidden>Pilih Lembaga</option>';
                                for ($ii = 0; $ii < mysqli_num_rows($r1); $ii++) {
                                    $r = mysqli_fetch_assoc($r1);

                                    ?>
                                    <script>
                                        if (!__d.lembaga.find(x => x.id_lembaga == <?= $r['id_lembaga'] ?>)) {
                                            __d.lembaga.push({
                                                id_lembaga: <?= $r['id_lembaga'] ?>,
                                                nama_lembaga: "<?= $r['nama_lembaga'] ?>",
                                                kontak: "<?= $r['kontak'] ?>"
                                            });
                                        }
                                    </script>
                                    <?php

                                    $m .= '<option value="' . $r['id_lembaga'] . '"' . ($id_lembaga == $r['id_lembaga'] && $_ == 0 ? "selected" : "") . '>' . $r['nama_lembaga'] . '</option>';
                                }
                                $m .= '</select>';
                                $m .= '</div>';

                                mysqli_data_seek($r1, 0);

                                while ($r = mysqli_fetch_assoc($r1)) {
                                    if ($r['id_lembaga'] == $id_lembaga) {
                                        $m .= '<div class="form-group ' . ($act == 'add' ? 'fgAddLembaga d-none' : '') . '">';
                                        $m .= '<label for="' . ($act == 'add' ? 'addKontakLembaga' : 'editKontakLembaga' . $id_lembaga . $i) . '">No. Telp Lembaga  </label>';
                                        $m .= '<input class="form-control" id="' . ($act == 'add' ? 'addKontakLembaga' : 'editKontakLembaga' . $id_lembaga . $i) . '" value="' . ($act == 'add' ? "" : $r['kontak']) . '" readonly>';
                                        $m .= '</div>';
                                        break;
                                    }
                                }   
                            }

                            return $m;
                        }
                        function getKegiatan($id_kegiatan, $i, $_ = 0, $act = "edit")
                        {
                            global $koneksi;
                            global $upload_dir;
                            $m = "";
                            $m .= '<div class="form-group">';
                            $r1 = mysqli_query($koneksi, "SELECT * FROM kegiatan");
                            if (mysqli_num_rows($r1) > 0) {
                                $m .= '<label for="' . ($act == 'add' ? "addNamaKegiatan" : "editNamaKegiatan" . $id_kegiatan . $i) . '">Nama Kegiatan</label>';
                                $m .= '<select required class="form-control" id="' . ($act == 'add' ? "addNamaKegiatan" : "editNamaKegiatan" . $id_kegiatan . $i) . '" name="' . ($act == 'add' ? "addNamaKegiatan" : "editNamaKegiatan") . '">';
                                if ($_ === 1)
                                    $m .= '<option value="" selected disabled hidden>Pilih kegiatan</option>';
                                while ($r = mysqli_fetch_assoc($r1)) {
                                    ?>
                                    <script>
                                        if (!__d.kegiatan.find(x => x.id_kegiatan == <?= $r['id_kegiatan'] ?>)) {
                                            __d.kegiatan.push({
                                                id_kegiatan: <?= $r['id_kegiatan'] ?>,
                                                nama_kegiatan: "<?= $r['nama_kegiatan'] ?>",
                                                tanggal_kegiatan: "<?= $r['tanggal_kegiatan'] ?>",
                                                deskripsi: "<?= $r['deskripsi'] ?>",
                                                gambar: "<?= $r['gambar'] ?>",
                                            });
                                        }
                                    </script>
                                    <?php
                                    $m .= '<option value="' . $r['id_kegiatan'] . '"' . ($id_kegiatan == $r['id_kegiatan'] && $_ == 0 ? "selected" : "") . '>' . $r['nama_kegiatan'] . '</option>';
                                }
                                $m .= '</select>';
                                $m .= '</div>';

                                mysqli_data_seek($r1, 0);

                                while ($r = mysqli_fetch_assoc($r1)) {
                                    if ($r['id_kegiatan'] == $id_kegiatan) {
                                        $m .= '<div class="form-group ' . ($act == 'add' ? 'fgAddKegiatan d-none' : '') . '">';
                                        $m .= '<label for="' . ($act == 'add' ? "addTglKegiatan" : 'editTglKegiatan' . $id_kegiatan . $i) . '">Tanggal Kegiatan</label>';
                                        $m .= '<input class="form-control" id="' . ($act == 'add' ? "addTglKegiatan" : 'editTglKegiatan' . $id_kegiatan . $i) . '" value="' . ($act == 'add' ? '' : $r['tanggal_kegiatan']) . '" readonly>';
                                        $m .= '</div>';
                                        $m .= '<div class="form-group ' . ($act == 'add' ? 'fgAddKegiatan d-none' : '') . '">';
                                        $m .= '<label for="' . ($act == 'add' ? "addDeskripsiKegiatan" : 'editDeskripsiKegiatan' . $id_kegiatan . $i) . '">Deskripsi</label>';
                                        $m .= '<textarea class="form-control" id="' . ($act == 'add' ? "addDeskripsiKegiatan" : 'editDeskripsiKegiatan' . $id_kegiatan . $i) . '" readonly>' . ($act == 'add' ? '' : $r['deskripsi']) . '</textarea>';
                                        $m .= '</div>';
                                        $m .= '<div class="form-group ' . ($act == 'add' ? 'fgAddKegiatan d-none' : '') . '">';
                                        $m .= '<label for="' . ($act == 'add' ? 'addGambarKegiatan' : 'editGambarKegiatan' . $id_kegiatan . $i) . '">Gambar</label><br>';
                                        $m .= "<input id='" . ($act == 'add' ? 'addGambarKegiatanInput' : "editGambarKegiatanInput" . $id_kegiatan . $i) . "' class='form-control " . ($r["gambar"] == "" ? "" : ($act == 'add' ? '' : "d-none")) . "' value='" . ($act == 'add' ? '' : 'Tidak ada Gambar') . "' readonly>";
                                        $m .= "<a id='" . ($act == 'add' ? 'addGambarKegiatanA' : "editGambarKegiatanA" . $id_kegiatan . $i) . "' class='" . ($r["gambar"] != "" ? ($act == 'add' ? 'd-none' : '') : "d-none") . "' href='" . ($r['gambar'] == "" ? "" : ($act == 'add' ? '' : $upload_dir . $r['gambar'])) . "' target='_blank'><img id='" . ($act == 'add' ? 'addGambarKegiatan' : "editGambarKegiatan" . $id_kegiatan . $i) . "' class='gambar-keg gambar' alt='Gambar gagal dimuat' src='" . ($r['gambar'] == "" ? "" : ($act == 'add' ? '' : "img/uploaded/" . $r['gambar'])) . "' width='200px'></a>";
                                        $m .= '</div>';
                                        break;
                                    }
                                }
                            }

                            return $m;
                        }


                        $sql = "select ag.id_anggota, ag.nama_anggota, ag.jabatan, ag.alamat, ag.nomor_telepon as notelp_anggota, k.id_kegiatan ,k.nama_kegiatan, k.tanggal_kegiatan, k.gambar, k.deskripsi, l.id_lembaga , l.nama_lembaga, l.kontak as notelp_lembaga, lp.id_lpmd from anggotaa as ag, kegiatan as k, lembaga as l, lpmd as lp where lp.id_anggota = ag.id_anggota and lp.id_kegiatan = k.id_kegiatan and lp.id_lembaga = l.id_lembaga";
                        $result = mysqli_query($koneksi, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table lpmd' id='lpmd'>";
                            echo "<tr> <th>#</th> <th>Nama Anggota</th> <th>Nama Kegiatan</th> <th>Nama Lembaga</th> <th>No. Telepon Lembaga</th> <th>Tanggal Kegiatan</th> <th>Deskripsi</th> <th>Gambar</th>" . (isset($_SESSION['is_logged']) ? "<th>Aksi</th>" : "") . " </tr>";
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
                                echo "<td>" . ($row["gambar"] == "" ? "Tidak ada gambar" : "<a href='img/uploaded/" . $row['gambar'] . "' target='_blank'><img class='gambar-keg gambar' alt='Gambar gagal dimuat' src='img/uploaded/" . $row['gambar'] . "' width='175px'></a>") . "</td>";
                                if (isset($_SESSION['is_logged'])) {
                                    echo "<td><button class='btn btn-primary btn-edit' data-toggle='modal' data-target='#editModal" . $row['id_lpmd'] . "'>Edit</button><br>" . ("<button class='btn btn-primary mybtn-danger' data-toggle='modal' data-target='#confirmDeleteModal" . $row['id_lpmd'] . "'>Hapus</button>") . "</td>";
                                    ?>
                                    <div class="hohoho">
                                        <!-- Modal Hapus -->
                                        <?php
                                        echo '<div class="modal fade" id="confirmDeleteModal' . $row['id_lpmd'] . '" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">';
                                        echo '<div class="modal-dialog" role="document">';
                                        echo '<div class="modal-content">';
                                        echo '<div class="modal-header">';
                                        echo '<h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>';
                                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                        echo '<span aria-hidden="true">&times;</span></button></div>';
                                        echo '<div class="modal-body">';
                                        echo 'Apakah Anda yakin ingin menghapus data <b>No. ' . $i + 1 . '</b>?</div>';
                                        echo '<div class="modal-footer">';
                                        echo '<form action="proses.php" method="post">';
                                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
                                        echo '<input type="hidden" name="id_lpmd" value="' . $row['id_lpmd'] . '">';
                                        echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                                        echo '<input type="hidden" name="aksi" value="hapus-data">';
                                        echo '<button type="submit" class="btn btn-primary mybtn-danger">Hapus</button>';
                                        echo '</form></div></div></div></div>';
                                        ?>

                                        <!-- Modal Edit -->
                                        <?php
                                        echo '<div class="modal fade" id="editModal' . $row['id_lpmd'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $row['id_lpmd'] . '" aria-hidden="true">';
                                        echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                                        echo '<div class="modal-content">';
                                        echo '<div class="modal-header">';
                                        echo '<h5 class="modal-title" id="editModalLabel' . $row['id_lpmd'] . '">Edit Data LPMD</h5>';
                                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                        echo '<span aria-hidden="true">&times;</span></button></div>';
                                        echo '<div class="modal-body">';
                                        echo '<form action="proses.php" method="post">';
                                        echo '<input type="hidden" name="id_lpmd" value="' . $row['id_lpmd'] . '">';
                                        echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                                        echo '<input type="hidden" name="aksi" value="update-data">';
                                        echo getAnggota($row['id_anggota']);
                                        echo getLembaga($row['id_lembaga'], $i);
                                        echo getKegiatan($row['id_kegiatan'], $i);
                                        echo '<div class="modal-footer">';
                                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
                                        echo '<button type="submit" class="btn btn-primary mybtn-simpan">Simpan</button>';
                                        echo '</div></form></div></div></div></div>';
                                        ?>

                                        <!-- Modal Add -->
                                        <?php
                                        echo '<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">';
                                        echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                                        echo '<div class="modal-content">';
                                        echo '<div class="modal-header">';
                                        echo '<h5 class="modal-title" id="addModalLabel">Tambah Data LPMD</h5>';
                                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                        echo '<span aria-hidden="true">&times;</span></button></div>';
                                        echo '<div class="modal-body">';
                                        echo '<form action="proses.php" method="post">';
                                        echo '<input type="hidden" name="id_lpmd" value="">';
                                        echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                                        echo '<input type="hidden" name="aksi" value="tambah-data">';
                                        echo getAnggota($row['id_anggota'], 1, "add");
                                        echo getLembaga($row['id_lembaga'], $i, 1, "add");
                                        echo getKegiatan($row['id_kegiatan'], $i, 1, "add");
                                        echo '<div class="modal-footer">';
                                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
                                        echo '<button type="submit" class="btn btn-primary mybtn-simpan">Simpan</button>';
                                        echo '</div></form></div></div></div></div>';
                                        ?>
                                    </div>
                                    <?php
                                }
                                echo "</tr>";

                                ?>
                                <script>
                                    $("#editNamaKegiatan<?= $row['id_kegiatan'] . $i ?>").change(function () {
                                        var selectedValue = $(this).val();
                                        var d = __d.kegiatan.find(x => x.id_kegiatan == selectedValue);

                                        if (!d || d === undefined) return false;
                                        $("#editDeskripsiKegiatan<?= $row['id_kegiatan'] . $i ?>").val(d.deskripsi);
                                        $("#editTglKegiatan<?= $row['id_kegiatan'] . $i ?>").val(d.tanggal_kegiatan);

                                        if (!d.gambar || d.gambar == "") {
                                            $("#editGambarKegiatan<?= $row['id_kegiatan'] . $i ?>").attr("src", "");
                                            $("#editGambarKegiatanA<?= $row['id_kegiatan'] . $i ?>").attr("href", "");
                                            $("#editGambarKegiatanA<?= $row['id_kegiatan'] . $i ?>").addClass("d-none");
                                            $("#editGambarKegiatanInput<?= $row['id_kegiatan'] . $i ?>").removeClass("d-none");
                                        } else {
                                            $("#editGambarKegiatan<?= $row['id_kegiatan'] . $i ?>").attr("src", `img/uploaded/${d.gambar}`);
                                            $("#editGambarKegiatanA<?= $row['id_kegiatan'] . $i ?>").attr("href", `img/uploaded/${d.gambar}`);
                                            $("#editGambarKegiatanA<?= $row['id_kegiatan'] . $i ?>").removeClass("d-none");
                                            $("#editGambarKegiatanInput<?= $row['id_kegiatan'] . $i ?>").addClass("d-none");
                                        }
                                    });
                                    $("#addNamaKegiatan").change(function () {
                                        var selectedValue = $(this).val();
                                        var d = __d.kegiatan.find(x => x.id_kegiatan == selectedValue);

                                        if (!d || d === undefined) return false;
                                        $("#addDeskripsiKegiatan").val(d.deskripsi);
                                        $("#addTglKegiatan").val(d.tanggal_kegiatan);

                                        $(".fgAddKegiatan").removeClass('d-none');

                                        if (!d.gambar || d.gambar == "") {
                                            $("#addGambarKegiatan").attr("src", "");
                                            $("#addGambarKegiatanA").attr("href", "");
                                            $("#addGambarKegiatanA").addClass("d-none");
                                            $("#addGambarKegiatanInput").removeClass("d-none");
                                            $("#addGambarKegiatanInput").val("Tidak ada gambar");
                                        } else {
                                            $("#addGambarKegiatan").attr("src", `img/uploaded/${d.gambar}`);
                                            $("#addGambarKegiatanA").attr("href", `img/uploaded/${d.gambar}`);
                                            $("#addGambarKegiatanA").removeClass("d-none");
                                            $("#addGambarKegiatanInput").addClass("d-none");
                                        }
                                    });

                                    $("#editNamaLembaga<?= $row['id_lembaga'] . $i ?>").change(function () {
                                        var selectedValue = $(this).val();
                                        var d = __d.lembaga.find(x => x.id_lembaga == selectedValue);

                                        if (!d || d === undefined) return false;
                                        $("#editKontakLembaga<?= $row['id_lembaga'] . $i ?>").val(d.kontak);
                                    });
                                    $("#addNamaLembaga").change(function () {
                                        var selectedValue = $(this).val();
                                        var d = __d.lembaga.find(x => x.id_lembaga == selectedValue);

                                        if (!d || d === undefined) return false;
                                        $("#addKontakLembaga").val(d.kontak);

                                        $(".fgAddLembaga").removeClass('d-none');
                                    });
                                </script>
                                <?php
                            }
                            echo "</table>";
                        } else {
                            echo "Data LPMD tidak tersedia.";
                        }
                        ?>
                    </div>
                    <div class="ko">
                        <h3
                            style="font-weight: bold; border-left: 5px solid var(--prim-color); border-radius: 5px; padding-left: 15px; margin-bottom: 15px;">
                            Struktur Organisasi
                        </h3>
                        <?php include 'test.php' ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* Fungsi untuk elemen input pencarian data dalam tabel */
        $(document).ready(function () {
            var $row1 = $('.lpmd tbody tr:first-child');
            var $trows = $('.lpmd tbody tr');

            $('#searchInput').on('keyup', function () {
                var searchtxt = $(this).val().toLowerCase();
                var $result = $trows.filter(function () {
                    return $(this).text().toLowerCase().indexOf(searchtxt) > -1;
                });

                if ($result.length > 0) {
                    $trows.hide();
                    $row1.show();
                    $result.show();
                } else {
                    $trows.hide();
                    $row1.show();
                }
            });
        });
    </script>

    <?php include "footer.php"; ?>

</body>

</html>