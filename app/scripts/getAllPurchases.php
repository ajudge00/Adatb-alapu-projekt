<?php
include_once "connectDB.php";

$sql = "
    SELECT K.CIM AS KONYV_CIM, V.SZALLITASI_CIM, V.MENNYISEG, TO_CHAR(V.DATUM, 'YYYY.MM.DD. HH24:MI') AS DATUM
    FROM VASARLAS V
    LEFT JOIN KONYV K ON V.KONYV_ID = K.ID
    WHERE V.FELHASZNALO_ID = :user_id
    ORDER BY V.DATUM DESC
";

$user_id = $_SESSION["user_id"];

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":user_id", $user_id);

oci_execute($stmt);



?>