<?php
    include_once "scripts/connectDB.php";

        $query = "SELECT p.product_id, p.product_name, p.description, p.unit_price,
                    s.site_name, s.address, st.quantity
                FROM product p
                LEFT JOIN
                    (SELECT product_id, site_id, quantity
                    FROM stock) st ON p.product_id = st.product_id
                LEFT JOIN
                    site s ON st.site_id = s.site_id
                ORDER BY
                    p.product_name";

    $result = mysqli_query($conn, $query);

    if ($result) {
    echo '<div class="container">';
        echo '<h1 class="mb-5 mt-3">Összes termék</h1>';

        $groupedResults = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $productId = $row['product_id'];
            $productName = $row['product_name'];
            $description = $row['description'];
            $unitPrice = $row['unit_price'];
            $siteName = $row['site_name'];
            $address = $row['address'];
            $quantity = $row['quantity'];

            // ha még nincs az arrayben az adott id, inicializáljuk
            if (!isset($groupedResults[$productId])) {
                $groupedResults[$productId] = array(
                    'productName' => $productName,
                    'description' => $description,
                    'unitPrice' => $unitPrice,
                    'sites' => array(),
                    'totalQuantity' => 0
                );
            }

            // utána betesszük az adatokat
            $groupedResults[$productId]['sites'][] = array(
                'siteName' => $siteName,
                'address' => $address,
                'quantity' => $quantity
            );

            // és növeljük a termék összmennyiséget
            $groupedResults[$productId]['totalQuantity'] += $quantity;
        }

        // termékek szerint csoportosítva
        foreach ($groupedResults as $productId => $productDetails) {
            echo '<h4>' . $productDetails['productName'] . '</h4>';
            echo '<p>' . $productDetails['description'] . ' - Egységár: ' . $productDetails['unitPrice'] . ' USD</p>';
            if($productDetails['totalQuantity'] === 0){
                echo "<p class='mb-5'><strong>A termék nincs raktáron.</strong></p>";
            }else{
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Telephely</th>';
                echo '<th>Telephely címe</th>';
                echo '<th>Darabszám</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($productDetails['sites'] as $site) {
                    echo '<tr>';
                    echo '<td>' . $site['siteName'] . '</td>';
                    echo '<td>' . $site['address'] . '</td>';
                    echo '<td>' . $site['quantity'] . '</td>';
                    echo '</tr>';
                }

                //összmennyiség kiírása
                echo '<tr>';
                echo '<td colspan="2"></td>';
                if($productDetails['sites'][0]['quantity'] != $productDetails['totalQuantity']){
                    echo '<td><strong>' . $productDetails['totalQuantity'] . '</strong></td>';
                }
                echo '</tr>';

                echo '</tbody>';
                echo '</table>';
            }

        }

        echo '</div>';
    }

mysqli_close($conn);

?>