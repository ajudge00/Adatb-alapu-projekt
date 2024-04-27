<?php


include "scripts/connectDB.php"; // Adatbázis kapcsolat

// Függvény a könyv részleteinek lekérdezésére könyvazonosító alapján
function konyvRészletek($konyv_id, $kapcsolat) {
    $sql = "SELECT k.cim, s.szerzo, k.ar FROM KONYV k INNER JOIN Szerzo s ON k.szerzo_id = s.id WHERE k.id = :konyv_id";

    // Lekérdezés előkészítése
    $stmt = oci_parse($kapcsolat, $sql);

    // Paraméter beállítása és bindelése
    oci_bind_by_name($stmt, ":konyv_id", $konyv_id);

    // Lekérdezés végrehajtása
    oci_execute($stmt);

    // Eredmény fetchelése
    $row = oci_fetch_assoc($stmt);

    // Lekérdezés lezárása
    oci_free_statement($stmt);

    return $row;
}

?>

<div class="container mt-5">
    <h2>A kosarad</h2>
    <?php
    if (!empty($_SESSION["cart"])) {
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Cím</th>";
        echo "<th>Szerző</th>";
        echo "<th>Ár</th>";
        echo "<th>Mennyiség</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($_SESSION["cart"] as $konyv_id => $mennyiseg) {
            // Lekérdezés a könyv részleteinek lekérésére
            $sql = "SELECT k.cim, s.nev AS szerzo, k.ar  FROM KONYV k INNER JOIN (SELECT id, nev FROM SZERZO) s ON k.szerzo_id = s.id WHERE k.id = :konyv_id";

            // Lekérdezés előkészítése
         

            // Paraméter beállítása és bindelése
            oci_bind_by_name($stmt, ":konyv_id", $konyv_id);

            // Lekérdezés végrehajtása
            oci_execute($stmt);

            // Eredmény fetchelése
            $row = oci_fetch_assoc($stmt);

            if ($row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['cim']) . "</td>"; // Kimenet escapelése
                echo "<td>" . htmlspecialchars($row['szerzo']) . "</td>"; // Kimenet escapelése
                echo "<td>" . htmlspecialchars($row['ar']) . " Ft</td>"; // Kimenet escapelése
                echo "<td>" . htmlspecialchars($mennyiseg) . "</td>"; // Kimenet escapelése
                echo "</tr>";
            } else {
                echo "<tr>";
                echo "<td colspan='4'>Nem sikerült betölteni a könyv részleteit.</td>";
                echo "</tr>";
            }
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>A kosarad üres</p>";
    }
    ?>
</div>