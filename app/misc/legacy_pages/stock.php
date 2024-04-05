<?php
    //admingombok
    if($_SESSION['role'] === "admin"){
        echo '
        <div class="container mt-4">
            <a class="float-right" href="?page=editStock">Készlet módosítása</a>
        </div>';
    }


    include_once "scripts/getStock.php";

?>