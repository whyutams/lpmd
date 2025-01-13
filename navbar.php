<?php

?>

<!-- Bagian Header -->
<div class="address-top text-center text-white">
    <b>Desa Bulila</b>
    Kec. Telaga, Kab. Gorontalo, Provinsi Gorontalo
</div>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        
        <a class="navbar-brand proj-title" href="index.php#" style="font-size: 25px; letter-spacing: 1px;  font-weight: bold;"><img src="./img/kab-gor.png" alt="" width="50px" class="logo"> LPMD    
        <!-- Logo Sementara -->
        <!-- &nbsp; <i class="fa-solid fa-hand-holding-heart"></i> -->
        </a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php#">Home</a>
                </li>
                <?php
                if (isset($_SESSION["is_logged"])) {
                    echo '<li class="nav-item"> <a class="nav-link" href="anggota.php">Anggota</a> </li> <li class="nav-item"> <a class="nav-link" href="kegiatan.php">Kegiatan</a> </li> <li class="nav-item"> <a class="nav-link" href="lembaga.php">Lembaga</a> </li> <li class="nav-item"> <a class="nav-link" href="index.php#lpmd">LPMD</a> </li> <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Akun (' . substr(strSlice($_SESSION['user_data']['nama_anggota'], " ", 0, 2), 0, 20) . ') </a> <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a> </div> </li> <div class="modal fade text-dark" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="logoutModalLabel">Logout</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> <div class="modal-body"> Apakah Anda yakin ingin keluar? </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button> <button type="button" class="btn btn-primary btn-logout" onclick="window.location = \'logout.php\'">Logout</button> </div> </div> </div> </div>';
                } else {
                    echo '<li class="nav-item"> <a class="nav-link" href="index.php#lpmd">LPMD</a> </li> <br> <li class="nav-item btnn"> <button class="btn btn-primary mybtn-login" data-toggle="modal" data-target="#loginModal"><strong>Login</strong></button> </li> <br>';
                    echo '<div class="modal fade text-dark" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true"> <div class="modal-dialog modal-dialog-centered" role="document"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="loginModalLabel">Login</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> <form action="" method="post"> <div class="modal-body"> <div class="form-group"> <label for="usernameInput1">Username</label> <input type="text" class="form-control" id="usernameInput1" aria-describedby="usernameHelp" placeholder="Masukkan Username" name="username" required> <small id="usernameHelp" class="form-text text-muted"></small> </div> <div class="form-group"> <label for="passwordInput1">Password</label> <input type="password" class="form-control" id="passwordInput1" aria-describedby="passwordHelp" placeholder="Masukkan Password" name="password" required> <small id="passwordHelp" class="form-text text-muted"></small> </div> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button> <button type="submit" class="btn btn-primary">Login</button> </div> </form> </div> </div> </div>';
                }
                ?>

                <script>
                    /* Untuk menyetel tab halaman yang aktif */
                    $(document).ready(function () {
                        $(".navbar .navbar-nav li.nav-item").each(function (i, e) {
                            let page = getPath();
                            page = page == 'index' ? 'home' : page;

                            let nbi = $(`.navbar .navbar-nav li.nav-item`).eq(i);
                            if (nbi.text().trim().toLowerCase() == page) {
                                nbi.addClass("active");
                                nbi.attr("aria-current", "page");
                            }
                        });
                    });

                </script>
            </ul>

        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


    </div>
</nav>

<noscript>
    <h3 class="text-center bg-warning text-white">Javascript Anda tidak aktif! Situs mungkin tidak berfungsi dengan baik.</h3>
</noscript>