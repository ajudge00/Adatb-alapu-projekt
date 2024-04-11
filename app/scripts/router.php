<?php
//ez a fájl intézi hogy melyik oldal legyen betöltve a page paraméter alapján

$page = isset($_GET['page']) ? $_GET['page'] : 'products';


$protectedNormal = [/* normál regisztrált felhasználóktól védett oldalak ide! */];

$protectedUnregistered = [];
$protectedUnregistered = array_merge($protectedNormal, [/* vengég felhasználóktól védett oldalak ide! */]);


// csekk hogy be van e jelentkezve --> vedett oldalak
if (!isset($_SESSION['user_id']) && in_array($page, $protectedUnregistered)) {
    header("Location: index.php");
    exit();
}

// csekk hogy admin e --> adminvédett oldalak
if(isset($_SESSION['role']) && $_SESSION['role'] !== 'admin' && in_array($page, $protectedNormal)){
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
    default:
        include('products.php');
        break;
}
?>