<?php
include "connectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addProduct"])) {
    // adatok a formbol
    $productName = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $unitPrice = intval(abs(($_POST["unit_price"])));

    // csekk hogy létezik e már product ezzel a névvel
    $checkQuery = "SELECT * FROM product WHERE product_name = '$productName'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // már van ilyen nevű termék
        header("Location: ../index.php?page=editProduct&adderror=1");
    } else {
        $insertQuery = "INSERT INTO product (product_name, description, unit_price) VALUES ('$productName', '$description', $unitPrice)";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            header("Location: ../index.php?page=editProduct&addsuccess=1");
        } else {
            header("Location: ../index.php?page=editProduct&adderror=2");
        }
    }
}


mysqli_close($conn);
?>
