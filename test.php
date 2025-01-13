<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .structure {
        text-align: center;
    }

    .structure .row {
        border: 2px solid #00000050;
        border-radius: 15px;
        padding: 10px;
    }

    .structure .box {
        border: 2px solid var(--prim-color);
        padding: 8px 10px;
        margin: 5px auto;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: fit-content;
    }

    .structure .box span {
        padding: 0px 10px 0px 10px !important;
    }

    .box .position {
        font-weight: bold;
        font-size: 12px;
    }

    .line-vertical {
        height: 30px;
        width: 2px;
        background-color: var(--prim-color);
        margin: 0 auto;
    }

    .line-horizontal {
        height: 2px;
        width: 100%;
        max-width: 300px;
        background-color: var(--prim-color);
        margin: 10px auto;
    }

    .branch {
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        max-width: 600px;
        margin: 0 auto;
    }

    .branch .col {
        margin: 10px;
    }

    .row-custom {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 0 -5px;
    }

    .row-custom .col-custom {
        flex: 0 0 calc(40% - 20px);
        max-width: calc(40% - 20px);
        margin: 5px;
    }

    .box {
        padding: 102px;
    }

    .col-custom {
        flex: 0 0 calc(45% - 20px);
        max-width: calc(45% - 20px);
        margin: 5px;
    }

    @media (max-width: 768px) {
        .col-custom {
            flex: 0 0 100%;
            max-width: 100%;
            margin: 5px 0;
        }
    }
</style>

<?php
$result = mysqli_query($koneksi, "select * from anggotaa");

$ketua_lpmd = "";
$wakil_lpmd = "";
$bendahara = "";
$sekretaris = "";
$anggota = [];

if (mysqli_num_rows($result) > 0) {
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $row = mysqli_fetch_assoc($result);
        $jabatan = strtolower($row['jabatan']);
        if($jabatan == "ketua") $ketua_lpmd = $row['nama_anggota']; 
        if($jabatan == "wakil ketua") $wakil_lpmd = $row['nama_anggota']; 
        if($jabatan == "bendahara") $bendahara = $row['nama_anggota']; 
        if($jabatan == "sekretaris") $sekretaris = $row['nama_anggota']; 
        if($jabatan == "anggota") array_push($anggota,  $row['nama_anggota']);
    }
}


?>

<div class="container structure">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="box"><span class="position">Kepala Desa</span><br>Yusrin Tine</div>
            <div class="line-vertical"></div>
            <div class="box"><span class="position">Ketua</span><br><?= $ketua_lpmd ?></div>
            <div class="line-vertical"></div>
            <div class="box"><span class="position">Wakil Ketua</span><br><?= $wakil_lpmd ?></div>
            <div class="line-vertical"></div>
            <div class="line-horizontal"></div>
            <div class="branch">
                <div class="col">
                    <div class="box"><span class="position">Bendahara</span><br><?= $bendahara ?></div>
                </div>
                <div class="col">
                    <div class="box"><span class="position">Sekretaris</span><br><?= $sekretaris ?></div>
                </div>
            </div>
            <div class="row-custom">
                <?php
                foreach ($anggota as $member) { ?>
                    <div class="col-custom">
                        <div class="box">
                            <span class="position">Anggota</span><br>
                            <?php echo $member; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>