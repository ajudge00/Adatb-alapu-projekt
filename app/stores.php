<?php
include "scripts/connectDB.php"; // Adatbázis csatlakozás

// SQL lekérdezés futtatása az áruházak címeire
$sql = "SELECT cim FROM ARUHAZ";
$stmt = oci_parse($conn, $sql);

// Lekérdezés végrehajtása
oci_execute($stmt);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áruházaink</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Áruházaink címei</h1>

<table>
<tr><th>Cím:</th></tr>

<?php
// Táblázat létrehozása és adatok kiírása
while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    echo "</tr>\n";
}
?>

</table>

<?php
// Statement és kapcsolat lezárása
oci_free_statement($stmt);
oci_close($conn);
?>
</body>
</html>
