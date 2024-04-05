<div class="container mt-5">
    <!-- termék hozzáadása -->
    <h2>Termék hozzáadása</h2>
    <form action="scripts/addProduct.php" method="post" class="mb-5">
        <div class="form-group">
            <label for="product_name">Termék neve:</label>
            <input type="text" class="form-control" name="product_name" required>
        </div>

        <div class="form-group">
            <label for="description">Leírás:</label>
            <input type="text" class="form-control" name="description" required>
        </div>

        <div class="form-group">
            <label for="unit_price">Egységár:</label>
            <input type="number" class="form-control" name="unit_price" required>
        </div>
        <?php
            if(isset($_GET['adderror']) && $_GET['adderror'] === '1'){
                echo
                    "<h6 class='text-danger'>Már van ilyen nevű termék</h6>";
            }else if(isset($_GET['addsuccess']) && $_GET['addsuccess'] === '1'){
                echo
                    "<h6 class='text-success'>Termék hozzáadása sikeres</h6>";
            }else if(isset($_GET['adderror']) && $_GET['adderror'] === '2'){
                echo
                "<h6 class='text-danger'>Termék hozzáadása sikertelen</h6>";
            }
        ?>
        <button type="submit" class="btn btn-primary" name="addProduct">Hozzáadás</button>
    </form>


    <!-- termék szerkesztése-->
    <h2>Termék szerkesztése</h2>
    <form action="scripts/modifyProduct.php" method="post">
        <div class="form-group">
            <label for="selected_product">Módosítandó termék:</label>
            <select class="form-control" name="selected_product" required>
                <?php
                    //módosítható termékek listája
                    include_once "scripts/connectDB.php";
                    $productQuery = "SELECT product_id, product_name FROM product ORDER BY product_name";
                    $productResult = mysqli_query($conn, $productQuery);

                    while ($row = mysqli_fetch_assoc($productResult)) {
                        echo "<option value='{$row['product_id']}'>{$row['product_name']}</option>";
                    }

                    mysqli_close($conn);
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="product_name">Termék új neve:</label>
            <input type="text" class="form-control" name="product_name">
        </div>

        <div class="form-group">
            <label for="description">Új leírás:</label>
            <input type="text" class="form-control" name="description">
        </div>

        <div class="form-group">
            <label for="unit_price">Új egységár:</label>
            <input type="number" class="form-control" name="unit_price">
        </div>

        <button type="submit" class="btn btn-success mb-5" name="modifyProduct">Termék módosítása</button>
    </form>

</div>