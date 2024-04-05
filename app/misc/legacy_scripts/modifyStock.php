<?php
session_start();
include_once "connectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addStock"])) {
    //echo "valami";

    $siteId = intval($_POST["site_id"]);
    $productId = intval($_POST["product_id"]);
    $quantity = intval($_POST["quantity"]);

    //entry jelenlegi adatainak lekérése
    $existingStockQuery = "SELECT quantity FROM stock WHERE site_id = $siteId AND product_id = $productId";
    $existingStockResult = mysqli_query($conn, $existingStockQuery);

    if ($existingStockResult && mysqli_num_rows($existingStockResult) > 0) {
        $existingQuantity = mysqli_fetch_assoc($existingStockResult)['quantity'];

        $newQuantity = $existingQuantity + $quantity;

        if ($newQuantity < 0) {
            // többet próbál törölni mint amennyi van
            header("Location: ../index.php?page=editStock&modifyerror=1");
            exit();
        } elseif ($newQuantity == 0) {
            // töröljük az összeset mert kinullázódott
            $removeEntryQuery = "DELETE FROM stock WHERE site_id = $siteId AND product_id = $productId";
            mysqli_query($conn, $removeEntryQuery);

            //session változó az üzenethez
            $_SESSION['stockResult'] = "0";

        } else {
            // update
            $updateQuantityQuery = "UPDATE stock SET quantity = $newQuantity WHERE site_id = $siteId AND product_id = $productId";
            mysqli_query($conn, $updateQuantityQuery);

            //session változó az üzenethez
            $_SESSION['stockResult'] = "$existingQuantity;$newQuantity";
        }

        header("Location: ../index.php?page=editStock&modifysuccess=1");
    } else {
        header("Location: ../index.php?page=editStock&modifyerror=2");
    }
}

mysqli_close($conn);
?>
