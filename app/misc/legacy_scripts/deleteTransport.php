<?php
include "connectDB.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteTransport'])){
    $transportToDelete = mysqli_real_escape_string($conn, $_POST['transport_id']);

    $deleteQuery = "DELETE FROM transport WHERE transport_id = $transportToDelete";
    $result = mysqli_query($conn, $deleteQuery);

    if($result){
        header("Location: ../index.php?page=editTransports&deletesuccess=1");
    }else{
        header("Location: ../index.php?page=editTransports&deleteerror=1");
    }
}