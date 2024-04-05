<?php
include_once "scripts/connectDB.php";

$query = "SELECT s.site_id, s.site_name, s.address, p.product_name, p.unit_price, st.quantity
FROM site s
LEFT JOIN stock st ON s.site_id = st.site_id
LEFT JOIN product p ON st.product_id = p.product_id
ORDER BY s.site_name, p.product_name";

$result = mysqli_query($conn, $query);

if ($result) {
    echo '<div class="container">';
    echo '<h1 class="mb-5 mt-3">Készlet</h1>';

    $groupedResults = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $siteId = $row['site_id'];
        $siteName = $row['site_name'];
        $address = $row['address'];
        $productName = $row['product_name'];
        $unitPrice = $row['unit_price'];
        $quantity = $row['quantity'];

        // ha a site_id még nincs benne, inicializáljuk
        if (!isset($groupedResults[$siteId])) {
            $groupedResults[$siteId] = array(
                'siteName' => $siteName,
                'address' => $address,
                'products' => array(),
                'totalValue' => 0
            );
        }

        // groupedResult siteid mezőjének a product tömbjének értékei
        $groupedResults[$siteId]['products'][] = array(
            'productName' => $productName,
            'unitPrice' => $unitPrice,
            'quantity' => $quantity
        );

        // siteon található készlet összértékének frissítése
        $groupedResults[$siteId]['totalValue'] += ($unitPrice * $quantity);
    }

    // tablazat
    foreach ($groupedResults as $siteId => $siteDetails) {
        echo '<h4>' . $siteDetails['siteName'] . '</h4>';
        echo '<p>' . $siteDetails['address'] . '</p>';
        //itt valamiért még üres raktárnál is volt elem a productsban
        //tehát inkább csekkolom, hogy az az első "elem" NULL-e
        if ($siteDetails['products'][0]['productName'] === NULL) {
            echo "<p class='mb-5'><strong>A telephely raktárkészlete üres.</strong></p>";
        } else {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Termék</th>';
            echo '<th>Egységár</th>';
            echo '<th>Darabszám</th>';
            echo '<th>Érték</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($siteDetails['products'] as $product) {
                echo '<tr>';
                echo '<td>' . $product['productName'] . '</td>';
                echo '<td>' . $product['unitPrice'] . '</td>';
                echo '<td>' . $product['quantity'] . '</td>';
                echo '<td>' . ($product['unitPrice'] * $product['quantity']) . '</td>';
                echo '</tr>';
            }

            // site összértéke
            echo '<tr>';
            echo '<td colspan="3"></td>';
            echo '<td><strong>' . $siteDetails['totalValue'] . '</strong></td>';
            echo '</tr>';

            echo '</tbody>';
            echo '</table>';
        }
    }

    echo '</div>';
}

mysqli_close($conn);
?>
