
<form action="admin_funcs/add/addStock.php" method="post">
    <label for="book_select"> Könyv </label> <br>
    <select name='book' id="book_select">
        <?php
        include 'admin_funcs/getBooks.php';
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        ?>
            <option value=<?php echo $row['ID'] ?>> <?php echo $row['CIM'] ?> </option>
        <?php
        }
        ?>
    </select> <br>

    <label for="store_select"> Áruház </label> <br>
    <select name='store' id="store_select">
        <?php
        include 'admin_funcs/getStores.php';
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        ?>
            <option value=<?php echo $row['ID'] ?>> <?php echo $row['CIM'] ?> </option>
        <?php
        }
        ?>
    </select> <br>

    <label for="amount_input"> Mennyiség </label> <br>
    <input type="number" name="amount" id="amount_input"> <br>

    <button type="submit" class="btn btn-success">Hozzáadás</button>
</form>