<?php

// csatlakozás az adatbázishoz

$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
        (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
        (SID = orania2)
    )
)";


$conn = oci_connect('C##D48N9S', 'orakulum2002', $tns, 'UTF8');

if (!$conn) {
    $error_message = oci_error();
    echo "Csatlakozás sikertelen: " . $error_message['message'];
    exit;
} else {
    echo "Sikeres csatlakozás!";
}

?>