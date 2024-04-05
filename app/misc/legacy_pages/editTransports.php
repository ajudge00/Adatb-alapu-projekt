<div class="container mt-5">
    <!-- szállítmány hozzáadása -->
    <h2>Új szállítmány felvétele</h2>
    <form action="scripts/addTransport.php" method="post" class="mb-5">
        <div class="form-group">
            <label for="origin_site_id">Honnan?</label>
            <select class="form-control" name="origin_site_id" required>
                <?php
                    //létező originok
                    include_once "scripts/connectDB.php";
                    $siteQuery = "SELECT site_id, site_name, address FROM site ORDER BY site_name";
                    $siteResult = mysqli_query($conn, $siteQuery);

                    while ($siteRow = mysqli_fetch_assoc($siteResult)) {
                        echo "<option value='{$siteRow['site_id']}'>{$siteRow['site_name']} ({$siteRow['address']})</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="dest_site_id">Hova?</label>
            <select class="form-control" name="dest_site_id" required>
                <?php
                    //létező destinationök
                    include_once "scripts/connectDB.php";
                    $siteQuery = "SELECT site_id, site_name, address FROM site ORDER BY site_name";
                    $siteResult = mysqli_query($conn, $siteQuery);

                    while ($siteRow = mysqli_fetch_assoc($siteResult)) {
                        echo "<option value='{$siteRow['site_id']}'>{$siteRow['site_name']} ({$siteRow['address']})</option>";
                    }

                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date">Mikor?</label><br>
            <input type="date" name="date" required/><br>
        </div>
        <div class="form-group">
            <label for="product_id">Mit?</label>
            <select class="form-control" name="product_id" required>
                <?php
                    //létező termékek
                    $productQuery = "SELECT product_id, product_name FROM product ORDER BY product_name";
                    $productResult = mysqli_query($conn, $productQuery);

                    while ($productRow = mysqli_fetch_assoc($productResult)) {
                        echo "<option value='{$productRow['product_id']}'>{$productRow['product_name']}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Mennyiség?</label>
            <input type="number" class="form-control" name="quantity" required>
        </div>

        <?php
            if(isset($_GET['transporterror'])){
                switch ($_GET['transporterror']){
                    case 1:
                        echo "<h6 class='text-danger'>Érvénytelen dátum</h6>";
                        break;
                    case 2:
                        echo "<h6 class='text-danger'>A kiindulási pontnak és az úticélnak különbözőnek kell lennie!</h6>";
                        break;
                    case 3:
                        echo "<h6 class='text-danger'>Nincs ennyi raktáron a megadott áruból!</h6>";
                        break;
                    case 4:
                        echo "<h6 class='text-danger'>Hozzáadás sikertelen</h6>";
                        break;
                    default:
                        echo "<h6 class='text-success'>Sikeres hozzáadás</h6>";
                }
            }
        ?>

        <button type="submit" class="btn btn-primary" name="addTransport">Szállítmány hozzáadása</button>
    </form>
</div>

<div class="container mt-5">
    <h2>Szállítmány törlése</h2>
    <form action="scripts/deleteTransport.php" method="post" class="mb-5">
        <div class="form-group">
            <label for="transport_id">Válasszon szállítmányt:</label>
            <select class="form-control" name="transport_id" required>
                <?php
                    include_once "scripts/connectDB.php";
                    $transportQuery = "SELECT transport_id, transport_date, origin.site_name AS origin_site,
                                        dest.site_name AS dest_site, product.product_name, quantity 
                                       FROM transport
                                       INNER JOIN site AS origin ON transport.origin_site_id = origin.site_id
                                       INNER JOIN site AS dest ON transport.dest_site_id = dest.site_id
                                       INNER JOIN product ON transport.product_id = product.product_id
                                       ORDER BY transport_date DESC, origin_site, dest_site, product_name";
                    $transportResult = mysqli_query($conn, $transportQuery);

                    while ($transportRow = mysqli_fetch_assoc($transportResult)) {
                        echo "<option value='{$transportRow['transport_id']}'>
                                {$transportRow['transport_date']} - Ind.: {$transportRow['origin_site']}, 
                                Cél: {$transportRow['dest_site']} ({$transportRow['product_name']}, 
                                {$transportRow['quantity']} db)
                              </option>";
                    }
                ?>
            </select>
        </div>

        <?php
            if(isset($_GET['deleteerror']) && $_GET['deleteerror'] === '1'){
                echo "<h6 class='text-danger'>Sikertelen törlés</h6>";
            } else if(isset($_GET['deletesuccess']) && $_GET['deletesuccess'] === '1'){
                echo "<h6 class='text-success'>Sikeres törlés</h6>";
            }
        ?>

        <button type="submit" class="btn btn-danger mt-3" name="deleteTransport">Szállítmány törlése</button>
    </form>
</div>
