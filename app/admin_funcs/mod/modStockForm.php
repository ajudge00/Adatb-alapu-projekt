
<?php
include "getStocksAll.php";
?>

<table>
    <tr>
        <th> Cím </th>
        <th> Könyv </th>
        <th> Mennyiseg </th>
    </tr>
    <?php
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        ?>
            <form action="admin_funcs/mod/modStock.php" method="post">
                <tr>
                    <input type="hidden" name="store" value = "<?php echo $row['ARUHAZ_ID']; ?>">

                    <input type="hidden" name="book" value = "<?php echo $row['KONYV_ID']; ?>">

                    <td>
                        <?php
                        include "admin_funcs/getStores.php";
                        while (($store_row = oci_fetch_array($store_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                        ?>
                            <!-- <option value="<?php echo $store_row['ID']; ?>" <?php if ($store_row['ID'] == $row['ARUHAZ_ID']) echo 'selected = "selected"'; ?> > <?php echo $store_row['CIM']; ?> </option> -->
                            <?php if ($store_row['ID'] == $row['ARUHAZ_ID']) echo $store_row['CIM']; ?>
                        <?php
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        include "admin_funcs/getBooks.php";
                        while (($book_row = oci_fetch_array($book_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                        ?>
                            <!-- <option value="<?php echo $book_row['ID']; ?>" <?php if ($book_row['ID'] == $row['KONYV_ID']) echo 'selected = "selected"'; ?> > <?php echo $book_row['CIM']; ?> </option> -->
                            <?php if ($book_row['ID'] == $row['KONYV_ID']) echo $book_row['CIM']; ?>
                        <?php
                        }
                        ?>
                    </td>

                    <td> <input type="number" name="amount" id="amount_input" value="<?php echo $row['MENNYISEG']; ?>"> </td>

                    <td> <button type="submit" name="submit" value="mod" class="btn btn-success"> Módosítás </button> </td>

                    <td> <button type="submit" name="submit" value="del" class="btn btn-danger"> Törlés </button> </td>
                </tr>
            </form>
        <?php
        }
        ?>
</table>

<!-- <form action="admin_funcs/add/addStore.php" method="post">
    <label for="address_input"> Cím </label> <br>
    <input type="text" name="address" id="adress_input"> <br>

    <button type="submit" class="btn btn-success">Hozzáadás</button>
</form> -->