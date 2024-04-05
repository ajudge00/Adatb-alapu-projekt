<?php
//admingombok
if($_SESSION['role'] === "admin"){
    echo '
        <div class="container mt-4">
            <a class="float-right" href="?page=editTransports">Szállítmányok módosítása</a>
        </div>';
}


include_once "scripts/getTransports.php";

?>