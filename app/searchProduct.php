<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvek</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Könyvek</h1>
    <!-- Kereső mező -->
    <form method="post">
        <input type="text" name="search" placeholder="Keresés..." value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
        <input type="submit" value="Keresés">
    </form>

    <!-- Könyvek megjelenítése táblázatban -->
    <table class="table mt-4" id="book-table">
        <thead>
            <tr>
                <th>Cím <i class="fas fa-sort-up" id="title-asc"></i> <i class="fas fa-sort-down" id="title-desc"></i></th>
                <th>Szerző <i class="fas fa-sort-up" id="author-asc"></i> <i class="fas fa-sort-down" id="author-desc"></i></th>
                <th>Ár</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "scripts/connectDB.php"; // Adatbázis csatlakozás

            $order_by = "k.cim ASC"; // Alapértelmezett rendezés cím szerint növekvő sorrendben
            if(isset($_GET['order'])) {
                switch($_GET['order']) {
                    case 'title_asc':
                        $order_by = "k.cim ASC";
                        break;
                    case 'title_desc':
                        $order_by = "k.cim DESC";
                        break;
                    case 'author_asc':
                        $order_by = "s.nev ASC";
                        break;
                    case 'author_desc':
                        $order_by = "s.nev DESC";
                        break;
                }
            }

            if(isset($_POST['search'])) {
                $search_term = '%' . $_POST['search'] . '%';
                $sql = "SELECT k.id, k.cim, s.nev AS szerzo, k.ar FROM KONYV k JOIN SZERZO s ON k.szerzo_id = s.id WHERE k.cim LIKE :search_term OR s.nev LIKE :search_term ORDER BY $order_by";
                $stmt = oci_parse($conn, $sql);
                oci_bind_by_name($stmt, ':search_term', $search_term);
                oci_execute($stmt);
            } else {
                $sql = "SELECT k.id, k.cim, s.nev AS szerzo, k.ar FROM KONYV k JOIN SZERZO s ON k.szerzo_id = s.id ORDER BY $order_by";
                $stmt = oci_parse($conn, $sql);
                oci_execute($stmt);
            }

            while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                echo "<tr>";
                echo "<td><h5 class='card-title'><a href='index.php?page=item&id=" . $row['ID'] . "'>" . $row['CIM'] . "</a></h5></td>";
                echo "<td>" . $row['SZERZO'] . "</td>";
                echo "<td>" . $row['AR'] . " Ft</td>";
                echo "</tr>";
            }

            oci_free_statement($stmt);
            oci_close($conn);
            ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById('title-asc').addEventListener('click', function() {
        sortTable('book-table', 0, true);
    });

    document.getElementById('title-desc').addEventListener('click', function() {
        sortTable('book-table', 0, false);
    });

    document.getElementById('author-asc').addEventListener('click', function() {
        sortTable('book-table', 1, true);
    });

    document.getElementById('author-desc').addEventListener('click', function() {
        sortTable('book-table', 1, false);
    });

    function sortTable(tableId, column, asc) {
        const tbody = document.getElementById(tableId).querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // Sort the rows
        rows.sort((a, b) => {
            const cellTextA = a.children[column].innerText.trim().toLowerCase();
            const cellTextB = b.children[column].innerText.trim().toLowerCase();
            return asc ? cellTextA.localeCompare(cellTextB) : cellTextB.localeCompare(cellTextA);
        });

        // Clear the table body
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }

        // Append the sorted rows to the table body
        rows.forEach(row => {
            tbody.appendChild(row);
        });
    }
</script>

</body>
</html>
