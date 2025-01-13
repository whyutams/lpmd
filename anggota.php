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
    <title>LPMD - Anggota</title>
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
                                Data Anggota</h4>
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
                            $sql = "SELECT * FROM anggotaa order by level";
                            $result = mysqli_query($koneksi, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table anggota' id='anggota'>";
                                echo "<tr> <th>#</th> <th class='d-none'>ID</th> <th>Nama Anggota</th> <th>Jabatan</th> <th>Alamat</th> <th>No. HP</th>" . ($_SESSION['user_data']['level'] <= 2 ? "<th>Level</th><th>Username</th>" : "") . (isset($_SESSION["is_logged"]) ? "<th>Aksi</th>" : "") . "</tr>";
                                for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<tr " . ($_SESSION['user_data']['id_anggota'] == $row['id_anggota'] ? "style='font-weight: bold;'" : "") . ">";
                                    echo "<th scope='row'>" . $i + 1 . "</th>";
                                    echo "<td class='d-none'>" . $row['id_anggota'] . "</td>";
                                    echo "<td>" . $row["nama_anggota"] . ($_SESSION['user_data']['id_anggota'] == $row['id_anggota'] ? "<b> (Anda)</b>" : "") . "</td>";
                                    echo "<td>" . $row["jabatan"] . "</td>";
                                    echo "<td>" . $row["alamat"] . "</td>";
                                    echo "<td>" . $row["nomor_telepon"] . "</td>";
                                    if ($_SESSION['user_data']['level'] <= 2) {
                                        echo "<td>" . ($row["level"] == 1 ? "Administrator" : ($row["level"] == 2 ? "Moderator" : "User")) . "</td>";
                                        echo "<td>" . $row["username"] . "</td>";
                                    }
                                    if (isset($_SESSION["is_logged"]))
                                        echo "<td>" . ($_SESSION['user_data']['id_anggota'] == $row['id_anggota'] || ($_SESSION['user_data']['level'] <= $row['level'] && $_SESSION['user_data']['level'] < 3) ? "<button class='btn btn-primary btn-edit' data-toggle='modal' data-target='#editModal" . $row['id_anggota'] . "'>Edit</button><br>" : "") . ($_SESSION['user_data']['id_anggota'] == $row['id_anggota'] || $_SESSION['user_data']['level'] >= $row['level'] ? "" : "<button class='btn btn-primary mybtn-danger' data-toggle='modal' data-target='#confirmDeleteModal" . $row['id_anggota'] . "'>Hapus</button>") . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "Data anggota tidak tersedia.";
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
                    var $row1 = $('.anggota tbody tr:first-child');
                    var $trows = $('.anggota tbody tr');

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
                        echo '<div class="modal fade" id="confirmDeleteModal' . $row['id_anggota'] . '" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">';
                        echo '<div class="modal-dialog" role="document">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span></button></div>';
                        echo '<div class="modal-body">';
                        echo 'Apakah Anda yakin ingin menghapus data "' . $row['nama_anggota'] . '"?</div>';
                        echo '<div class="modal-footer">';
                        echo '<form action="proses.php" method="post">';
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
                        echo '<input type="hidden" name="id_anggota" value="' . $row['id_anggota'] . '">';
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
                        echo '<div class="modal fade" id="editModal' . $row['id_anggota'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $row['id_anggota'] . '" aria-hidden="true">';
                        echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="editModalLabel' . $row['id_anggota'] . '">Edit Data Anggota</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span></button></div>';
                        echo '<div class="modal-body">';
                        echo '<form action="proses.php" method="post">';
                        echo '<input type="hidden" name="id_anggota" value="' . $row['id_anggota'] . '">';
                        echo '<input type="hidden" name="from_path" value="' . getPath() . '">';
                        echo '<input type="hidden" name="aksi" value="update-data">';
                        echo '<div class="form-group">';
                        echo '<label for="editNama">Nama Anggota</label>';
                        echo '<input type="text" class="form-control" id="editNama" name="editNama" value="' . $row['nama_anggota'] . '">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="editJabatan">Jabatan</label>';
                        echo '<select class="form-control" id="editJabatan" name="editJabatan" ' . ($_SESSION['user_data']['level'] <= 2 && $_SESSION['user_data']['id_anggota'] != $row['id_anggota'] && ($_SESSION['user_data']['level'] != $row['level']) ? 'style="cursor: pointer;"' : 'disabled') . '>';
                        // echo '<option value="Ketua" ' . ($row['jabatan'] == 'Ketua' ? 'selected' : '') . ($_SESSION['user_data']['level'] == 1 ? '' : 'style="cursor: no-drop; background-color: #eee;" disabled') . '>Ketua</option>';
                        echo '<option value="Ketua" ' . ($row['jabatan'] == 'Ketua' ? 'selected' : '') . 'disabled' . '>Ketua</option>';
                        echo '<option value="Wakil Ketua" ' . ($row['jabatan'] == 'Wakil Ketua' ? 'selected ' : '') . ($_SESSION['user_data']['level'] == 1 ? '' : 'style="cursor: no-drop; background-color: #eee"' . ($_SESSION['user_data']['level'] == 2 ? 'disabled' : '')) . '>Wakil Ketua</option>';
                        echo '<option value="Sekretaris" ' . ($row['jabatan'] == 'Sekretaris' ? 'selected' : '') . '>Sekretaris</option>';
                        echo '<option value="Bendahara" ' . ($row['jabatan'] == 'Bendahara' ? 'selected' : '') . '>Bendahara</option>';
                        echo '<option value="Anggota" ' . ($row['jabatan'] == 'Anggota' ? 'selected' : '') . '>Anggota</option>';
                        echo '</select>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="editAlamat">Alamat</label>';
                        echo '<textarea class="form-control" id="editAlamat" name="editAlamat">' . $row['alamat'] . '</textarea>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="editNoHP">No. HP</label>';
                        echo '<input type="text" class="form-control" id="editNoHP" name="editNomor" value="' . $row['nomor_telepon'] . '">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="editLevel">Level</label>';
                        echo '<select class="form-control" id="editLevel" name="editLevel" ' . ($_SESSION['user_data']['level'] == 1 && $_SESSION['user_data']['id_anggota'] != $row['id_anggota'] ? 'style="cursor: pointer;"' : 'disabled') . '>';
                        echo '<option value="1" ' . ($row['level'] == 1 ? 'selected' : '') . '>Administrator</option>';
                        echo '<option value="2" ' . ($row['level'] == 2 ? 'selected' : '') . '>Moderator</option>';
                        echo '<option value="3" ' . ($row['level'] == 3 ? 'selected' : '') . '>User</option>';
                        echo '</select>';
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
                                <h5 class="modal-title" id="addModalLabel">Tambah Data Anggota</h5>
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
                                        <label for="addNama">Nama Anggota</label>
                                        <input type="text" class="form-control" id="addNama" name="addNama"
                                            placeholder="Masukkan nama anggota" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addJabatan">Jabatan</label>
                                        <select class="form-control" id="addJabatan" name="addJabatan">
                                            <?php
                                            echo '<option value="Ketua" ' . ($_SESSION['user_data']['level'] <= 2 ? "disabled" : "") . '>Ketua</option>';
                                            echo '<option value="Wakil Ketua" ' . ($_SESSION['user_data']['level'] == 2 ? "disabled" : "") . '>Wakil Ketua</option>';
                                            ?>
                                            <option value="Sekretaris">Sekretaris</option>
                                            <option value="Bendahara">Bendahara</option>
                                            <option value="Anggota" selected>Anggota</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="addAlamat">Alamat</label>
                                        <textarea class="form-control" id="addAlamat" name="addAlamat"
                                            placeholder="Masukkan alamat" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="addNoHP">No. HP</label>
                                        <input type="text" class="form-control" id="addNoHP" name="addNoHP"
                                            placeholder="Masukkan No. HP" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addLevel">Level</label>
                                        <?php
                                        echo '<select class="form-control" id="addLevel" name="addLevel" ' . ($_SESSION['user_data']['level'] == 2 ? "disabled" : "") . '>'
                                            ?>
                                        <option value="1">Administrator</option>
                                        <option value="2">Moderator</option>
                                        <option value="3" selected>User</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="addUsername">Username</label>
                                        <input type="text" class="form-control" id="addUsername" name="addUsername"
                                            placeholder="Masukkan Username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addPassword">Password</label>
                                        <input type="text" class="form-control" id="addPassword" name="addPassword"
                                            placeholder="Masukkan Password" required>
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