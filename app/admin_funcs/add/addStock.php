<?php
include "../../scripts/connectDB.php";

$store = $_POST["store"];
$book = $_POST["book"];
$amount = $_POST["amount"];

$sql = 'INSERT INTO keszlet (aruhaz_id, konyv_id, mennyiseg) 
VALUES (:aruhaz, :konyv, :mennyiseg)';

$stid = oci_parse($conn, $sql);
if (!$stid) {
    $m = oci_error($conn);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

oci_bind_by_name($stid, ':aruhaz', $store);
oci_bind_by_name($stid, ':konyv', $book);
oci_bind_by_name($stid, ':mennyiseg', $amount);

$r = oci_execute($stid);
if (!$r) {
    $m = oci_error($stid);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

echo "Record added successfully.";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../index.php?page=admin");