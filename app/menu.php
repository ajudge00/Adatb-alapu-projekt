<?php
    $colorProducts = "";
    $colorStores = "";
    $colorLogreg = "";
    $colorAdmin = "";
    $colorUserButton = "";

    if(isset($_GET['page'])){
        switch ($_GET['page']){
            case 'products':
                $colorProducts = "text-white";
                break;
            case 'stores':
                $colorStores = "text-white";
                break;
            case 'logreg':
                $colorLogreg = "text-white";
                break;
            case 'admin':
                $colorUserButton = "text-white";
                break;
            case 'myPurchases':
                $colorUserButton = "text-white";
        }
    }else{
        $colorProducts = "text-white";
    }


    //menü
    $menuItems = '
        <li class="nav-item">
            <a class="nav-link ' . $colorProducts . '" href="?page=products">Könyveink</a>
        </li>
        <li class="nav-item">
            <a class="nav-link ' . $colorStores . '" href="?page=stores">Áruházaink</a>
        </li>
    ';

    if (isset($_SESSION['user_id'])) {
        // bejelentkezett user jobb menüje
        $topRightButtons = '
            <li class="nav-item">
                <a class="nav-link" href="scripts/logout.php">Kijelentkezés</a>
            </li>
        ';

        $userButtons = '';
        if($_SESSION['admin'] == 1) {
            $userButtons = '
                <li class="nav-item">
                    <a class="nav-link ' . $colorUserButton . '" href="?page=admin">Admin funkciók</a>
                </li>
            ';
        } else {
            $userButtons = '
                <li class="nav-item">
                    <a class="nav-link ' . $colorUserButton . '" href="?page=myPurchases">Vásárlásaim</a>
                </li>
            ';
        }

        $topRightButtons = $userButtons . $topRightButtons;
    } else {
        // nem bejelentkezett user jobb menüje
        $topRightButtons = '
            <li class="nav-item">
                <a class="nav-link ' . $colorLogreg . '" href="?page=logreg">Bejelentkezés</a>
            </li>
        ';
    }


    // keresés gomb
    $topRightButtons .= '
        <li class="nav-item">
            <a class="nav-link img-fluid" href="?page=searchProduct"><img class="search-icon img-fluid" src="assets/icons/magnifying-glass-solid.png" alt="Keresés"></a>
        </li>
    ';
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <!-- Logó -->
    <a class="navbar-brand" href="index.php">
        <img src="pics/logo1.png" height="50" alt="logo">
    </a>

    <!-- Toggle gomb kicsi kepernyoknek mert bootstrap is power -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php echo $menuItems; ?>
        </ul>

        <!-- Login/Register gomb -->
        <ul class="navbar-nav ml-auto">
            <?php echo $topRightButtons; ?>
        </ul>
    </div>
</nav>