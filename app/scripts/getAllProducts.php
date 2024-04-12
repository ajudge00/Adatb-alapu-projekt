<?php

include "scripts/connectDB.php";

$sql = '
    DECLARE
        konyv_cursor SYS_REFCURSOR;
    BEGIN
        OPEN konyv_cursor FOR
            SELECT k.id, cim, sz.nev as szerzo, ki.kiado_nev, oldalszam, leiras, nyelv, m.mufaj_nev, m.almufaj_nev, k.ar
            FROM konyv k
            LEFT JOIN szerzo sz ON sz.id = k.szerzo_id
            LEFT JOIN kiado ki ON ki.id = k.kiado_id
            LEFT JOIN mufaj m ON m.id = k.mufaj_id;

        :cursor := konyv_cursor;
    END;
';

$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

?>
