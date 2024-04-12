<?php
    $colorProducts = "";
    $colorStores = "";
    $colorLogreg = "";
    $colorAdmin = "";

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
            case 'admin':
                $colorAdmin = "text-white";
        }
    }else{
        $colorProducts = "text-white";
    }


    //menü
    if (isset($_SESSION['user_id'])) {
        // bejelentkezett user menüje. egyelőre ugyanolyan, mint a nem bejelentkezetté, kivéve, hogy itt elő van készítve a kijelentkezés gomb
        $menuItems = '
            <li class="nav-item">
                <a class="nav-link ' . $colorProducts . '" href="?page=products">Könyveink</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ' . $colorStores . '" href="?page=stores">Áruházaink</a>
            </li>
        ';

        // kijelentkezés
        $topRightButtons = '
            <li class="nav-item">
                <a class="nav-link" href="scripts/logout.php">Kijelentkezés</a>
            </li>
        ';
    } else {
        // nem bejelentkezett user menüje
        $menuItems = '
            <li class="nav-item">
                <a class="nav-link ' . $colorProducts . '" href="?page=products">Könyveink</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ' . $colorStores . '" href="?page=stores">Áruházaink</a>
            </li>
        ';

        // bejelentkezés/regisztráció
        $topRightButtons = '
            <li class="nav-item">
                <a class="nav-link ' . $colorAdmin . '" href="?page=admin">Admin funkciók</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ' . $colorLogreg . '" href="?page=logreg">Bejelentkezés</a>
            </li>
        ';
    }

    // keresés gomb
    $topRightButtons .= '
        <li class="nav-item">
            <a class="nav-link img-fluid" href="?page=searchProduct"><img class="search-icon img-fluid" src="assets/icons/magnifying-glass-solid.png" alt="Keresés"></a>
        </li>'
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