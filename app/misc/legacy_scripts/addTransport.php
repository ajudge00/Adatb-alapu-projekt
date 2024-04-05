<?php
include_once "connectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addTransport"])) {
    // adatok a formból
    $originSiteId = intval($_POST["origin_site_id"]);
    $destSiteId = intval($_POST["dest_site_id"]);
    $transportDate = $_POST["date"];
    $productId = intval($_POST["product_id"]);
    $quantity = intval($_POST["quantity"]);

    // a dátum nem lehet a mai napnál korábbi
    $today = date("Y-m-d");
    if ($transportDate < $today) {
        header("Location: ../index.php?page=editTransports&transporterror=1");
        exit();
    }

    // az origin és a destination nem lehet ugyanaz
    if ($originSiteId == $destSiteId) {
        header("Location: ../index.php?page=editTransports&transporterror=2");
        exit();
    }

    // az origin sitenál raktáron kell lennie a terméknek
    $stockQuery = "SELECT quantity FROM stock WHERE site_id = $originSiteId AND product_id = $productId";
    $stockResult = mysqli_query($conn, $stockQuery);

    if ($stockResult && mysqli_num_rows($stockResult) > 0) {
        $availableStock = mysqli_fetch_assoc($stockResult)['quantity'];

        //a user a lehetségesnél többet akar transzportálni az áruból
        if ($quantity > $availableStock) {
            header("Location: ../index.php?page=editTransports&transporterror=3");
            exit();
        }
    } else {
        header("Location: ../index.php?page=editTransports&transporterror=4");
        exit();
    }

    $insertQuery = "INSERT INTO transport (product_id, origin_site_id, dest_site_id, transport_date, quantity) 
                    VALUES ($productId, $originSiteId, $destSiteId, '$transportDate', $quantity)";

    mysqli_query($conn, $insertQuery);

    /* origin frissitese?
    $updateStockQuery = "UPDATE stock SET quantity = quantity - $quantity 
                         WHERE site_id = $originSiteId AND product_id = $productId";

    mysqli_query($conn, $updateStockQuery);
    */

    header("Location: ../index.php?page=editTransports&transporterror=0");
    exit();
}

mysqli_close($conn);
?>
