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
                <th>Törlés</th> <!-- Új oszlop a törlési gombnak -->
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
                        <td></td> <!-- Üres oszlop a törlési gombnak -->
                    </tr>";

                    $prevDate = $datum;
                }
                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $row['KONYV_CIM'] . "</td>";
                echo "<td>" . $row['MENNYISEG'] . "</td>";
                // Törlési gomb beszúrása
                echo "<td><button class='btn btn-danger' onclick='deletePurchase(\"" . $row['KONYV_ID'] . "\")'>Törlés</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
        function deletePurchase(bookId) {
            if (confirm('Biztosan törölni szeretné ezt a könyvet?')) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "deletePurchase.php?id=" + bookId, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Sikeres válasz esetén frissítheted az oldalt vagy végezhetsz más műveletet
                        // Pl. frissítés:
                        location.reload();
                    } else {
                        // Hiba esetén kezeld a hibát
                        console.log('Hiba történt a törlés során.');
                    }
                };
                xhr.send();
            }
        }
</script>
