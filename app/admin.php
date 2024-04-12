<?php
include "scripts/connectDB.php";
?>

<!-- <p>Admin funkciók ide</p>

<form action="scripts/addPublisher.php" method="post">
    <input type="text" name="" id="">
    <button type="submit" class="btn btn-success">Hozzáadás</button>
</form> -->

<div>
    <ul id="functionList">
        Adatok kezelése
        <ul id = "addList">
            Adatok felvétele
            <li>
                <a href="?page=admin&func=addBook"> Könyv</a>
            </li>
            <li>
                <a href="?page=admin&func=addStore"> Áruház</a>
            </li>
            <li>
                <a href="?page=admin&func=addStock"> Készlet</a>
            </li>
            <li>
                <a href="?page=admin&func=addPublisher"> Kiadó</a>
            </li>
            <li>
                <a href="?page=admin&func=addGenre"> Műfaj</a>
            </li>
            <li>
                <a href="?page=admin&func=addAuthor"> Szerző</a>
            </li>
        </ul>
        <ul id = "modifyList">
            Adatok módosítása
            <li>
                <a href="?page=admin&func=modifyBook"> Könyv</a>
            </li>
            <li>
                <a href="?page=admin&func=modifyStore"> Áruház</a>
            </li>
            <li>
                <a href="?page=admin&func=modifyStock"> Készlet</a>
            </li>
            <li>
                <a href="?page=admin&func=modifyPublisher"> Kiadó</a>
            </li>
            <li>
                <a href="?page=admin&func=modifyGenre"> Műfaj</a>
            </li>
            <li>
                <a href="?page=admin&func=modifyAuthor"> Szerző</a>
            </li>
        </ul>
    </ul>
</div>

<div>
    <?php
    $func = isset($_GET['func']) ? $_GET['func'] : null;

    switch ($func) {
        case 'addBook' :
            include_once('admin_funcs/addBookForm.php');
            break;
        default :
            echo '<p> Nincs funkció kiválasztva </p>';
    }
    ?>
</div>