<?php
include_once "connectDB.php";
session_start();

$shippingLocation = $_POST['shippingLocation'];

$getMaxId = '
    DECLARE
        id_max NUMBER;
    BEGIN
        SELECT MAX(id) INTO id_max
        FROM VASARLAS;

        :id_max := id_max;
    END;
';

$stmt = oci_parse($conn, $getMaxId);
oci_bind_by_name($stmt, ":id_max", $maxId, 5);
oci_execute($stmt);
$newId = $maxId + 1;

$userId = $_SESSION['user_id'];
$purchaseDate = date("Y-m-d H:i:s");

$insertPurchaseSql = "
    INSERT INTO VASARLAS (ID, DATUM, FELHASZNALO_ID, KONYV_ID, SZALLITASI_CIM, MENNYISEG)
    VALUES (:newId, TO_TIMESTAMP(:purchaseDate, 'YYYY-MM-DD HH24:MI:SS'), :userId, :bookId, :shippingLocation, :quantity)
";


foreach ($_SESSION['cart'] as $bookId => $quantity) {
    $stmt = oci_parse($conn, $insertPurchaseSql);
    oci_bind_by_name($stmt, ":newId", $newId);
    oci_bind_by_name($stmt, ":purchaseDate", $purchaseDate);
    oci_bind_by_name($stmt, ":userId", $userId);
    oci_bind_by_name($stmt, ":shippingLocation", $shippingLocation);
    oci_bind_by_name($stmt, ":bookId", $bookId);
    oci_bind_by_name($stmt, ":quantity", $quantity);
    oci_execute($stmt);
    oci_free_statement($stmt);
    $newId++;
}

oci_commit($conn);


$updateFunctionSql = "
    DECLARE
        ret BOOLEAN;
    BEGIN 
        ret := update_keszlet(:bookId, :quantity);
    END;
";
$stmt = oci_parse($conn, $updateFunctionSql);


foreach ($_SESSION['cart'] as $bookId => $quantity) {
    oci_bind_by_name($stmt, ":bookId", $bookId);
    oci_bind_by_name($stmt, ":quantity", $quantity);
    
    oci_execute($stmt);
}

unset($_SESSION["cart"]);

header('Location: ../index.php?page=myPurchases');
exit();

?>
