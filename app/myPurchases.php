<?php
include_once "scripts/getAllPurchases.php";
?>

<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Vásárlás időpontja</th>
                <th>Szállítási cím</th>
                <th>Könyv címe</th>
                <th>Mennyiség</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $prevDate = null;
            while ($row = oci_fetch_assoc($stmt)) {
                $datum = $row["DATUM"];
                if ($prevDate !== $datum) {
                    echo "
                    <tr>
                        <td colspan=1><strong>" . $datum . "</strong></td>
                        <td colspan=3>" . $row['SZALLITASI_CIM'] . "</td>
                    </tr>";

                    $prevDate = $datum;
                }
                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $row['KONYV_CIM'] . "</td>";
                echo "<td>" . $row['MENNYISEG'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

