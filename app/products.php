<?php
include "scripts/connectDB.php";

include "scripts/getProducts.php";
?>

<div class="container mt-5">
    <h1 class="mb-4">Könyveink</h1>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Cím</th>
                    <th>Szerző</th>
                    <th>Kiadó</th>
                    <th>Oldalszám</th>
                    <th>Leírás</th>
                    <th>Nyelv</th>
                    <th>Műfaj</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                    echo "<tr>";
                    echo "<td>".$row['CIM']."</td>";
                    echo "<td>".$row['SZERZO']."</td>";
                    echo "<td>".$row['KIADO_NEV']."</td>";
                    echo "<td>".$row['OLDALSZAM']."</td>";
                    echo "<td>".$row['LEIRAS']."</td>";
                    echo "<td>".$row['NYELV']."</td>";
                    echo "<td>".$row['ALMUFAJ_NEV']."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
