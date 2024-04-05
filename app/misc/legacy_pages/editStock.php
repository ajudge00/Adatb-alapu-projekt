<div class="container mt-5">
    <!-- telephely hozzáadása -->
    <h2>Telephely hozzáadása</h2>
    <form action="scripts/addSite.php" method="post" class="mb-5">
        <div class="form-group">
            <label for="site_name">Telephely neve:</label>
            <input type="text" class="form-control" name="site_name" required>
        </div>

        <div class="form-group">
            <label for="address">Telephely címe:</label>
            <input type="text" class="form-control" name="address" required>
        </div>

        <?php
            if(isset($_GET['adderror']) && $_GET['adderror'] === '1'){
                echo
                "<h6 class='text-danger'>Már van ilyen nevű/című telephely</h6>";
            }else if(isset($_GET['addsuccess']) && $_GET['addsuccess'] === '1'){
                echo
                "<h6 class='text-success'>Telephely hozzáadása sikeres</h6>";
            }else if(isset($_GET['adderror']) && $_GET['adderror'] === '2'){
                echo
                "<h6 class='text-danger'>Telephely hozzáadása sikertelen</h6>";
            }
        ?>
        <button type="submit" class="btn btn-primary" name="addSite">Telephely hozzáadása</button>
    </form>
</div>

<div class="container mt-5">
    <h2>Készlet módosítása</h2>
    <form action="scripts/modifyStock.php" method="post">

        <div class="form-group">
            <label for="site_id">Válasszon telephelyet:</label>
            <select class="form-control" name="site_id" required>
                <?php
                    //létező telephelyek lekérése
                    include_once "scripts/connectDB.php";
                    $siteQuery = "SELECT site_id, site_name FROM site ORDER BY site_name";
                    $siteResult = mysqli_query($conn, $siteQuery);

                    while ($siteRow = mysqli_fetch_assoc($siteResult)) {
                        echo "<option value='{$siteRow['site_id']}'>{$siteRow['site_name']}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="product_id">Válasszon terméket:</label>
            <select class="form-control" name="product_id" required>
                <?php
                    //létező termékek lekérése
                    $productQuery = "SELECT product_id, product_name FROM product ORDER BY product_name";
                    $productResult = mysqli_query($conn, $productQuery);

                    while ($productRow = mysqli_fetch_assoc($productResult)) {
                        echo "<option value='{$productRow['product_id']}'>{$productRow['product_name']}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Mennyiség: (pozitív érték hozzáad, negatív érték töröl)</label>
            <input type="number" class="form-control" name="quantity" required>
        </div>

        <?php
            // errorok
            if(isset($_GET['modifyerror'])){
                echo $_GET['modifyerror'] === '1' ?
                    "<h6 class='text-danger'>Nem lehet többet törölni, mint amennyi van!</h6>":
                    "<h6 class='text-danger'>Nincs ilyen termék a megadott telephelyen</h6>";
                exit();
            }

            // siker
            if(isset($_GET['modifysuccess']) && $_GET['modifysuccess'] === '1'){
                $modification = "";

                if (isset($_SESSION['stockResult']) && $_SESSION['stockResult'] === '0'){
                    $modification = "megadott termék törölve a telephely készletéből";
                }else if(isset($_SESSION['stockResult'])){
                    $tmp = $_SESSION['stockResult'];
                    $modification =
                        "régi mennyiség: " . substr($tmp, 0, strpos($tmp, ';')) .
                        ", új mennyiség: " .
                        substr($tmp, strpos($tmp, ';') + 1);
                }

                echo "<h6 class='text-success'>Készlet módosítása sikeres ($modification)</h6>";
            }

            unset($_SESSION['stockResult']);
        ?>

        <button type="submit" class="btn btn-warning" name="addStock">Készlet hozzáadása/törlése</button>
    </form>
</div>