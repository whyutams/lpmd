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
    <title>LPMD - Lembaga</title>
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
                                Data Lembaga</h4>
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
                            $sql = "SELECT * FROM 6lembaga";
                            $result = mysqli_query($koneksi, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table lembaga' id='lembaga'>";
                                echo "<tr> <th>#</th> <th class='d-none'>ID</th> <th>Nama Lembaga</th> <th>Kontak</th><th>Aksi</th></tr>";
                                for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $i + 1 . "</th>";
                                    echo "<td class='d-none'>" . $row['id_lembaga'] . "</td>";
                                    echo "<td>" . $row["nama_lembaga"] . "</td>";
                                    echo "<td>" . $row["kontak"] . "</td>";
                                    echo "<td><button class='btn btn-primary btn-edit' data-toggle='modal' data-target='#editModal" . $row['id_lembaga'] . "'>Edit</button><br>" . ("<button class='btn btn-primary mybtn-danger' data-toggle='modal' data-target='#confirmDeleteModal" . $row['id_lembaga'] . "'>Hapus</button>") . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "Data lembaga tidak tersedia.";
                            }
                            echo '</div></div>';
                }
                ?>
                        <br>
                    </div>
                </div>

            </div>

            <script>
                /* Fungsi untuk elemen input pencarian data dalam tabel */
                $(document).ready(function () {
                    var $row1 = $('.lembaga tbody tr:first-child');
                    var $trows = $('.lembaga tbody tr');

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
                        echo '<div class="modal fade" id="confirmDeleteModal' . $row['id_lembaga'] . '" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">';
                        echo '<div class="modal-dialog" role="document">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span></button></div>';
                        echo '<div class="modal-body">';
                        echo 'Apakah Anda yakin ingin menghapus data "' . $row['nama_lembaga'] . '"?</div>';
                        echo '<div class="modal-footer">';
                        echo '<form action="proses.php" method="post">';
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
                        echo '<input type="hidden" name="id_lembaga" value="' . $row['id_lembaga'] . '">';
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
                        echo '<div class="modal fade" id="editModal' . $row['id_lembaga'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $row['id_lembaga'] . '" aria-hidden="true">';
                        echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="editModalLabel' . $row['id_lembaga'] . '">Edit Data Lembaga</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span></button></div>';
                        echo '<div class="modal-body">';
                        echo '<form action="proses.php" method="post">';
                        echo '<input type="hidden" name="id_lembaga" value="' . $row['id_lembaga'] . '">';
                        echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                        echo '<input type="hidden" name="aksi" value="update-data">';
                        echo '<div class="form-group">';
                        echo '<label for="editNama">Nama Lembaga</label>';
                        echo '<input type="text" class="form-control" id="editNama" name="editNama" value="' . $row['nama_lembaga'] . '">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="editKontak">Kontak</label>';
                        echo '<input type="text" class="form-control" id="editKontak" name="editKontak" value="' . $row['kontak'] . '">';
                        echo '</div>';
                        echo '<div class="modal-footer">';
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
                        echo '<button type="submit" class="btn btn-primary mybtn-simpan">Simpan</button>';
                        echo '</div></form></div></div></div></div>';
                    }
                }
                ?>

                <!-- Modal Add -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Tambah Data Lembaga</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="proses.php" method="post">
                                    <?php
                                    echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                                    ?>
                                    <input type="hidden" name="aksi" value="tambah-data">
                                    <div class="form-group">
                                        <label for="addNama">Nama Lembaga</label>
                                        <input type="text" class="form-control" id="addNama" name="addNama"
                                            placeholder="Masukkan nama lembaga" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addKontak">Kontak</label>
                                        <input type="text" class="form-control" id="addKontak" name="addKontak"
                                            placeholder="Masukkan kontak" required>
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

            <?php include "footer.php"; ?>
</body>

</html>