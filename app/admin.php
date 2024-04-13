<?php
include "scripts/connectDB.php";
?>

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
                <a href="?page=admin&func=modBook"> Könyv</a>
            </li>
            <li>
                <a href="?page=admin&func=modStore"> Áruház</a>
            </li>
            <li>
                <a href="?page=admin&func=modStock"> Készlet</a>
            </li>
            <li>
                <a href="?page=admin&func=modPublisher"> Kiadó</a>
            </li>
            <li>
                <a href="?page=admin&func=modGenre"> Műfaj</a>
            </li>
            <li>
                <a href="?page=admin&func=modAuthor"> Szerző</a>
            </li>
        </ul>
    </ul>
</div>

<div>
    <?php
    $func = isset($_GET['func']) ? $_GET['func'] : null;

    switch ($func) {
        case 'addBook' :
            include_once('admin_funcs/add/addBookForm.php');
            break;
        case 'addStore':
            include_once('admin_funcs/add/addStoreForm.php');
            break;
        case 'addStock':
            include_once('admin_funcs/add/addStockForm.php');
            break;
        case 'addPublisher':
            include_once('admin_funcs/add/addPublisherForm.php');
            break;
        case 'addGenre':
            include_once('admin_funcs/add/addGenreForm.php');
            break;
        case 'addAuthor':
            include_once('admin_funcs/add/addAuthorForm.php');
            break;

        case 'modBook' :
            include_once('admin_funcs/mod/modBookForm.php');
            break;
        default :
            echo '<p> Nincs funkció kiválasztva </p>';
    }
    ?>
</div>