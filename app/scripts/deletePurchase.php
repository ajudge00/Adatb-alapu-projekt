<?php
include_once "scripts/getAllPurchases.php";

// Ellenőrizzük, hogy az azonosító paraméter meg lett-e adva az URL-ben
if(isset($_GET['id'])) {
    // Az azonosító biztonságosan beolvasása az URL-ből
    $bookId = $_GET['id']; // Változtattuk a változó nevét

    // Kapcsolódás az adatbázishoz (itt feltételezzük, hogy már van egy kapcsolódás)
    include_once "connectDB.php";

    $user_id = $_SESSION["user_id"];

    // SQL lekérdezés az adott könyv törlésére a felhasználó vásárlásai közül
    $sql = "DELETE FROM VASARLAS WHERE KONYV_ID = :book_id AND FELHASZNALO_ID = :user_id";

    // Prepare statement
    $stmt = oci_parse($conn, $sql);

    // Bind parameters
    oci_bind_by_name($stmt, ":book_id", $bookId); // Változtattuk a változó nevét
    oci_bind_by_name($stmt, ":user_id", $user_id); // Felhasználó azonosítójának hozzáadása

    // Execute statement
    if (oci_execute($stmt)) {
        // Sikeres törlés esetén nem irányítunk át sehová
        oci_close($conn); // Kapcsolat lezárása
        exit(); // Kilépünk a scriptből, hogy ne futtassuk tovább a kódot
    } else {
        echo "Hiba történt a vásárlás törlése közben.";
    }
} else {
    echo "Nincs megadva könyv azonosító a törléshez."; // Módosítottuk az üzenetet
}

// Kapcsolat lezárása
oci_close($conn);
?>