<?php
include "scripts/getAllProducts.php";
?>

<div class="container mt-5">
    <h1 class="mb-4">Könyveink</h1>
    <div class="row">
        <?php
            while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 text-center">
                            <img src="assets/productImages/literally.jpg" class="card-img-top productImage" alt="könyv kép" style="max-width: 75%; display: block; margin-left: auto; margin-right: auto;">

                            <div class="card-body">
                                <h5 class="card-title"><a href="?page=item&id=<?php echo $row['ID'] ?>"><?php echo $row['CIM']; ?></a></h5>
                                <p class="card-text"><?php echo $row['SZERZO']; ?></p>
                                <p class="card-text" style="font-size: 1.3rem"><strong><?php echo $row['AR'] . ' Ft'; ?></strong></p>
                            </div>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>

