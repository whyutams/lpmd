<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_data']) || !isset($_SESSION['is_logged'])) {
    header('location: logout.php');
    exit;
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
    <title>LPMD - Kegiatan</title>
</head>

<body>
    <div class="cont">
        <?php include 'navbar.php' ?>

        <div class="konten">
            <div class="container">
                <?php include "msginfo.php" ?>
                <?php
                if (isset($_SESSION["is_logged"])) {
                    ?>
                    <div class="ko">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4
                                style="font-weight: bold; border-left: 5px solid var(--prim-color); border-radius: 5px; padding-left: 15px; margin-bottom: 15px;">
                                Data Kegiatan</h4>
                            <div class="d-flex align-items-center cik">
                                <?php
                                if ($_SESSION['user_data']['level'] <= 2) {
                                    echo '<button class="btn btn-primary mr-2" style="font-size: 15px;" data-toggle="modal" data-target="#addModal">Tambah</button>';
                                }
                                ?>
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari..."
                                    style="max-width: 175px; width: auto;">
                            </div>
                        </div>
                        <div class="tres" style="margin-top: 10px;">
                            <?php
                            $sql = "SELECT * FROM kegiatan";
                            $result = mysqli_query($koneksi, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table kegiatan' id='kegiatan'>";
                                echo "<tr> <th>#</th> <th class='d-none'>ID</th> <th>Nama Kegiatan</th> <th>Tanggal Kegiatan</th> <th>Deskripsi</th><th>Gambar</th><th>Aksi</th></tr>";
                                for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $i + 1 . "</th>";
                                    echo "<td class='d-none'>" . $row['id_kegiatan'] . "</td>";
                                    echo "<td>" . $row["nama_kegiatan"] . "</td>";
                                    echo "<td>" . $row["tanggal_kegiatan"] . "</td>";
                                    echo "<td>" . $row["deskripsi"] . "</td>";
                                    echo "<td>" . ($row["gambar"] == "" ? "Tidak ada gambar" : "<a href='" . $upload_dir . $row['gambar'] . "' target='_blank'><img class='gambar-keg gambar' alt='Gambar gagal dimuat' src='" . $upload_dir . $row['gambar'] . "' width='175px'></a>") . "</td>";
                                    echo "<td><button class='btn btn-primary btn-edit' data-toggle='modal' data-target='#editModal" . $row['id_kegiatan'] . "'>Edit</button><br>" . ("<button class='btn btn-primary mybtn-danger' data-toggle='modal' data-target='#confirmDeleteModal" . $row['id_kegiatan'] . "'>Hapus</button>") . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "Data kegiatan tidak tersedia.";
                            }
                            echo '</div></div>';
                }
                ?>
                        <br>
                    </div>
                </div>

            </div>

            <script>
                $(document).ready(function () {
                    var $row1 = $('.kegiatan tbody tr:first-child');
                    var $trows = $('.kegiatan tbody tr');

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

            <div class="hohoho">
                <!-- Kumpulan Modal -->

                <!-- Modal Hapus -->
                <?php
                $result = mysqli_query($koneksi, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="modal fade" id="confirmDeleteModal' . $row['id_kegiatan'] . '" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">';
                        echo '<div class="modal-dialog" role="document">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span></button></div>';
                        echo '<div class="modal-body">';
                        echo 'Apakah Anda yakin ingin menghapus data "' . $row['nama_kegiatan'] . '"?</div>';
                        echo '<div class="modal-footer">';
                        echo '<form action="proses.php" method="post">';
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
                        echo '<input type="hidden" name="id_kegiatan" value="' . $row['id_kegiatan'] . '">';
                        echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                        echo '<input type="hidden" name="aksi" value="hapus-data">';
                        echo '<button type="submit" class="btn btn-primary mybtn-danger">Hapus</button>';
                        echo '</form></div></div></div></div>';
                    }
                }
                ?>

                <!-- Modal Edit -->
                <?php
                $result = mysqli_query($koneksi, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="modal fade" id="editModal' . $row['id_kegiatan'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $row['id_kegiatan'] . '" aria-hidden="true">';
                        echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="editModalLabel' . $row['id_kegiatan'] . '">Edit Data Kegiatan</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span></button></div>';
                        echo '<div class="modal-body">';
                        echo '<form action="proses.php" method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="id_kegiatan" value="' . $row['id_kegiatan'] . '">';
                        echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                        echo '<input type="hidden" name="aksi" value="update-data">';
                        echo '<div class="form-group">';
                        echo '<label for="editNama">Nama Kegiatan</label>';
                        echo '<input type="text" class="form-control" id="editNama" name="editNama" value="' . $row['nama_kegiatan'] . '">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="editTanggal">Tanggal Kegiatan</label>';
                        echo '<input class="form-control" id="editTanggal" name="editTanggal" type="date" value=' . $row['tanggal_kegiatan'] . '>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="editDeskripsi">Deskripsi</label>';
                        echo '<textarea class="form-control" id="editDeskripsi" name="editDeskripsi">' . $row['deskripsi'] . '</textarea>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="editGambar">Gambar</label><br>';
                        if ($row['gambar'] != '')
                            echo '<input class="d-none" type="text" name="editGambarOld" value="' . $row['gambar'] . '" readonly>';
                        echo '<img src="' . $upload_dir . $row['gambar'] . '" alt="Gambar gagal dimuat" class="' . ($row['gambar'] == '' ? 'd-none' : '') . ' gambar" id="editGambarView' . $row['id_kegiatan'] . '" width="200px" style="margin-bottom: 10px;">';
                        echo '<input type="file" accept="image/png, image/jpg, image/jpeg" class="" id="editGambar' . $row['id_kegiatan'] . '" name="editGambar" ' . ($row['gambar'] == '' ? 'required' : '') . '></div>';
                        echo '<div class="modal-footer">';
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
                        echo '<button type="submit" class="btn btn-primary mybtn-simpan">Simpan</button>';
                        echo '</div></form></div></div></div></div>';
                        ?>
                        <script>
                            $(document).ready(function () {
                                $('#editGambar<?= $row['id_kegiatan'] ?>').change(function () {
                                    let file = this.files[0];
                                    let reader = new FileReader();

                                    reader.onload = function (event) {
                                        let fileName = file.name;
                                        if (fileName === "") {
                                            $("#editGambarView<?= $row['id_kegiatan'] ?>").attr('src', "");
                                            $("#editGambarView<?= $row['id_kegiatan'] ?>").addClass("d-none");
                                            return;
                                        }

                                        $("#editGambarView<?= $row['id_kegiatan'] ?>").attr('src', event.target.result);
                                        $("#editGambarView<?= $row['id_kegiatan'] ?>").removeClass("d-none");
                                    };

                                    if (file) {
                                        reader.readAsDataURL(file);
                                    } else {
                                        $("#editGambarView<?= $row['id_kegiatan'] ?>").attr('src', "");
                                        $("#editGambarView<?= $row['id_kegiatan'] ?>").addClass("d-none");
                                    }
                                });
                            });
                        </script>
                        <?php
                    }
                }
                ?>

                <!-- Modal Add -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Tambah Data Kegiatan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="proses.php" method="post" enctype="multipart/form-data">
                                    <?php
                                    echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                                    ?>
                                    <input type="hidden" name="aksi" value="tambah-data">
                                    <div class="form-group">
                                        <label for="addNama">Nama Kegiatan</label>
                                        <input type="text" class="form-control" id="addNama" name="addNama"
                                            placeholder="Masukkan nama kegiatan" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addTanggal">Tanggal Kegiatan</label>
                                        <input type="date" class="form-control" id="addTanggal" name="addTanggal"
                                            value="<?= date("Y-m-d") ?>">

                                    </div>
                                    <div class="form-group">
                                        <label for="addDeskripsi">Deskripsi</label>
                                        <textarea class="form-control" id="addDeskripsi" name="addDeskripsi"
                                            placeholder="Masukkan deskripsi" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="addGambar">Gambar</label>
                                        <br>
                                        <img src="" alt="Gambar gagal dimuat" class="d-none gambar" id="addGambarView"
                                            width="200px" style="margin-bottom: 10px;">
                                        <input type="file" accept="image/png, image/jpg, image/jpeg" class=""
                                            id="addGambar" name="addGambar" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary mybtn-simpan">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                /* Fungsi untuk elemen input pencarian data dalam tabel */
                $(document).ready(function () {
                    $('#addGambar').change(function () {
                        let file = this.files[0];
                        let reader = new FileReader();

                        reader.onload = function (event) {
                            let fileName = file.name;
                            if (fileName === "") {
                                $("#addGambarView").attr('src', "");
                                $("#addGambarView").addClass("d-none");
                                return;
                            }

                            $("#addGambarView").attr('src', event.target.result);
                            $("#addGambarView").removeClass("d-none");
                        };

                        if (file) {
                            reader.readAsDataURL(file);
                        } else {
                            $("#addGambarView").attr('src', "");
                            $("#addGambarView").addClass("d-none");
                        }
                    });
                });
            </script>

            <?php include "footer.php"; ?>
</body>

</html>