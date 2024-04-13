
<?php
include "scripts/getAllProducts.php";
?>

<table>
    <tr>
        <th> Cím </th>
        <th> Szerző </th>
        <th> Kiadó </th>
        <th> Oldalszám </th>
        <th> Leírás </th>
        <th> Nyelv </th>
        <th> Műfaj </th>
        <th> Ár </th>
    </tr>
    <?php
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        ?>
            <tr>
                <form action="admin_funcs/mod/modBook.php" method="post">
                    <input type="hidden" name="id" value = "<?php echo $row['ID']; ?>">

                    <td> <input type="text" name="title" id="title_input" value="<?php echo $row['CIM']; ?>"> </td>

                    <td>
                        <select name='author' id="author_select">
                        <?php
                        include "admin_funcs/getAuthors.php";
                        while (($author_row = oci_fetch_array($author_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                        ?>
                            <option value="<?php echo $author_row['ID']; ?>" <?php if ($author_row['ID'] == $row['SZERZO_ID']) echo 'selected = "selected"'; ?> > <?php echo $author_row['NEV']; ?> </option>
                        <?php
                        }
                        ?>
                        </select> 
                    </td>

                    <td>
                        <select name='publisher' id="publisher_select">
                        <?php
                        include "admin_funcs/getPublishers.php";
                        while (($publisher_row = oci_fetch_array($publisher_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                        ?>
                            <option value="<?php echo $publisher_row['ID']; ?>" <?php if ($publisher_row['ID'] == $row['KIADO_ID']) echo 'selected = "selected"'; ?> > <?php echo $publisher_row['NEV']; ?> </option>
                        <?php
                        }
                        ?>
                        </select> 
                    </td>
                </form>
            </tr>
        <?php
        }
        ?>
</table>

<!-- <form action="admin_funcs/add/addBook.php" method="post">
    <label for="title_input"> Cím </label> <br>
    <input type="text" name="title" id="title_input"> <br>

    <label for="author_select"> Szerző </label> <br>
    <select name='author' id="author_select">
        <?php
        include 'admin_funcs/getAuthors.php';
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        ?>
            <option value=<?php echo $row['ID'] ?>> <?php echo $row['NEV'] ?> </option>
        <?php
        }
        ?>
    </select> <br>

    <label for="publisher_select"> Kiadó </label> <br>
    <select name='publisher' id="publisher_select">
        <?php
        include 'admin_funcs/getPublishers.php';
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        ?>
            <option value=<?php echo $row['ID'] ?>> <?php echo $row['NEV'] ?> </option>
        <?php
        }
        ?>
    </select> <br>

    <label for="title_input"> Oldalszám </label> <br>
    <input type="number" name="page_count" id="page_count_input"> <br>

    <label for="desc_input"> Leírás </label> <br>
    <input type="text" name="desc" id="desc_input"> <br>

    <label for="lang_input"> Nyelv </label> <br>
    <input type="text" name="lang" id="lang_input"> <br>

    <label for="genre_select"> Műfaj </label> <br>
    <select name='genre' id="genre_select">
        <?php
        include 'admin_funcs/add/getGenres.php';
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        ?>
            <option value=<?php echo $row['ID'] ?>> <?php echo $row['NEV'] . ', ' . $row['ALMUFAJ_NEV'] ?> </option>
        <?php
        }
        ?>
    </select> <br>

    <label for="price_input"> Ár </label> <br>
    <input type="number" name="price" id="price_input"> <br>

    <button type="submit" class="btn btn-success">Hozzáadás</button>
</form> -->