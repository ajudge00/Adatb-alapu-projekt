<?php
//ez a fájl intézi hogy melyik oldal legyen betöltve a page paraméter alapján

$page = isset($_GET['page']) ? $_GET['page'] : 'products';


$protectedNormal = ["admin"];

$protectedUnregistered = [];
$protectedUnregistered = array_merge($protectedNormal, ["myPurchases"]);


// csekk hogy be van e jelentkezve --> vedett oldalak
if (!isset($_SESSION['user_id']) && in_array($page, $protectedUnregistered)) {
    header("Location: index.php");
    exit();
}

// csekk hogy admin e --> adminvédett oldalak
if(isset($_SESSION['role']) && $_SESSION['admin'] !== true && in_array($page, $protectedNormal)){
    header("Location: index.php");
    exit();
}


// ide kerülnek az oldalak :)
switch ($page) {
    case 'stores':
        include('stores.php');
        break;
    case 'admin':
        include('admin.php');
        break;
    case 'searchProduct':
        include('searchProduct.php');
        break;
    case 'logreg':
        include('logreg.php');
        break;
    case 'item':
        include('item.php');
        break;
    case 'myPurchases':
        include('myPurchases.php');
        break;
    case 'connection':
        include('connection.php');
        break;
    case 'cart':
        include('cart.php');
        break;
    default:
        include('products.php');
        break;
}
?>