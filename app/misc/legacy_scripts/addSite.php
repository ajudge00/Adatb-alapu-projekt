<?php
include "connectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addSite"])) {
    // adatok a formból
    $siteName = mysqli_real_escape_string($conn, $_POST["site_name"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);

    // csekk hogy létezik e már site ezzel a névvel vagy címmel
    $checkQueryName = "SELECT * FROM site WHERE site_name = '$siteName'";
    $checkResultName = mysqli_query($conn, $checkQueryName);
    $checkQueryAddress = "SELECT * FROM site WHERE address = '$address'";
    $checkResultAddress = mysqli_query($conn, $checkQueryAddress);

    if ($checkResultName && (mysqli_num_rows($checkResultName) > 0 || mysqli_num_rows($checkResultAddress) > 0)) {
        // már van ilyen nevű/című telephely
        header("Location: ../index.php?page=editStock&adderror=1");
    } else {
        $insertQuery = "INSERT INTO site (site_name, address) VALUES ('$siteName', '$address')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            header("Location: ../index.php?page=editStock&addsuccess=1");
        } else {
            header("Location: ../index.php?page=editStock&adderror=2");
        }
    }
}


mysqli_close($conn);
?>
