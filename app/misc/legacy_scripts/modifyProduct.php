<?php
include_once "connectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifyProduct"])) {
    // form adatok
    $selectedProductId = intval($_POST["selected_product"]);
    $newProductName = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $newDescription = mysqli_real_escape_string($conn, $_POST["description"]);
    $newUnitPrice = intval($_POST["unit_price"]);

    //a termék jelenlegi adatainak lekérése
    $existingProductQuery = "SELECT * FROM product WHERE product_id = $selectedProductId";
    $existingProductResult = mysqli_query($conn, $existingProductQuery);

    if ($existingProductResult && mysqli_num_rows($existingProductResult) > 0) {
        $existingProduct = mysqli_fetch_assoc($existingProductResult);

        // ha a user nem írt be új értékeket, akkor maradnak a régiek
        $productNameToUpdate = empty($newProductName) ? $existingProduct['product_name'] : $newProductName;
        $descriptionToUpdate = empty($newDescription) ? $existingProduct['description'] : $newDescription;
        $unitPriceToUpdate = empty($newUnitPrice) ? $existingProduct['unit_price'] : $newUnitPrice;

        $updateQuery = "UPDATE product SET 
                        product_name = '$productNameToUpdate',
                        description = '$descriptionToUpdate',
                        unit_price = $unitPriceToUpdate
                        WHERE product_id = $selectedProductId";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            header("Location: ../index.php?page=editProduct&modifysuccess=1");
        } else {
            header("Location: ../index.php?page=editProduct&modifyerror=1");
        }
    } else {
        // nincs ilyen termék?
        header("Location: ../index.php?page=editProduct&modifyerror=1");
    }
}


mysqli_close($conn);
?>