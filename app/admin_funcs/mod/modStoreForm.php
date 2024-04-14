
<?php
include "getStoresAll.php";
?>

<table>
    <tr>
        <th> Cím </th>
    </tr>
    <?php
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        ?>
            <form action="admin_funcs/mod/modStore.php" method="post">
                <tr>
                    <input type="hidden" name="id" value = "<?php echo $row['ID']; ?>">

                    <td> <input type="text" name="address" id="adress_input" value="<?php echo $row['CIM']; ?>"> </td>

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