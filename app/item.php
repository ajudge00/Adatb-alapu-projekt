<?php
include "scripts/getItem.php";
?>

<div class="container mt-5">
    <p><?php echo ucfirst($mufaj_nev) . ' > ' . ucfirst($almufaj_nev); ?></p>
    <div class="row">
        <div class="col-md-4">
            <img src="assets/productImages/literally.jpg" class="img-fluid" alt="Product Image">
        </div>
        <div class="col-md-8">
            <h6><?php echo $szerzo; ?></h6>
            <h2><?php echo $cim; ?></h2>
            <h3 class="mt-3"><?php echo $ar; ?> Ft</h3>
            <div class="row mt-5">
                <div class="col-md-6">
                    <p><strong>Kiadó:</strong></p>
                    <p><strong>Oldalszám:</strong></p>
                    <p><strong>Nyelv:</strong></p>
                    <p><strong>Kategória:</strong></p>
                    <p><strong>Műfaj:</strong></p>
                </div>
                <div class="col-md-6">
                    <p><?php echo $kiado_nev; ?></p>
                    <p><?php echo $oldalszam; ?></p>
                    <p><?php echo $nyelv; ?></p>
                    <p><?php echo $mufaj_nev; ?></p>
                    <p><?php echo $almufaj_nev; ?></p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3>Szinopszis</h3>
                    <p><?php echo $leiras; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
