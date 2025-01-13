<?php
/* Untuk menampilkan informasi keberhasilan operasi CRUD dalam database */
if (isset($_GET['info'])) {
    if ($_GET['info'] == 'data-added') {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
            Data berhasil ditambahkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
    } else if ($_GET['info'] == 'data-notadded') {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                Data gagal ditambahkan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
    } else if ($_GET['info'] == 'data-deleted') {
        ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                    Data berhasil dihapus.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        <?php
    } else if ($_GET['info'] == 'data-notdeleted') {
        ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                        Data gagal dihapus.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
        <?php
    } else if ($_GET['info'] == 'data-idanggotanotfound') {
        ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                            Data Anggota tidak ditemukan.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
        <?php
    } else if ($_GET['info'] == 'data-updated') {
        ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                                Data berhasil diubah.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <?php
    } else if ($_GET['info'] == 'data-notupdated') {
        ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                                    Data gagal diubah.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
        <?php
    } else if ($_GET['info'] == 'data-idkegiatannotfound') {
        ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                                        Data Kegiatan tidak ditemukan.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
        <?php
    } else if ($_GET['info'] == 'data-idlpmdnotfound') {
        ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                                            Data LPMD tidak ditemukan.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
        <?php
    }
}
?>