<?php
include_once "connectDB.php";

//alapértelmezetten daily aggregation
$aggregationType = isset($_GET['aggregation']) ? $_GET['aggregation'] : 'daily';

if ($aggregationType === 'daily') {
    //pontos dátum aggregáció (napi)
    $groupBy = 'transport_date';
} else {
    //csak hogy hanyadik hét az évben pl 202347
    $groupBy = 'YEARWEEK(transport_date)';
}

$query = "SELECT 
            $groupBy AS grouping_key,
            transport_date,
            origin.site_name AS origin_site,
            dest.site_name AS dest_site,
            product.product_name,
            quantity
        FROM transport
        INNER JOIN site AS origin ON transport.origin_site_id = origin.site_id
        INNER JOIN site AS dest ON transport.dest_site_id = dest.site_id
        INNER JOIN product ON transport.product_id = product.product_id
        ORDER BY grouping_key DESC, transport_date DESC, origin_site, dest_site, product_name";

//ez így néz ki $groupBy = 'YEARWEEK(transport_date)' esetén:
//"grouping_key"	"transport_date"	"origin_site"	    "dest_site"	        "product_name"	    "quantity"
//"202443"	        "2024-11-01"	    "Leafy Logistics"	"Pine & Ship Co."	"Breville facsaró"	"15"
//"202351"	        "2023-12-20"	    "Whisked Wil..."	 "Acorn Express"	 "Jaccard 48-Blade"	"10"

$result = mysqli_query($conn, $query);

if ($result) {
    echo '<div class="container">';
    echo '<h1 class="mb-5 mt-3">Szállítmányok</h1>';

    $dailyColour = 'btn-muted';
    $weeklyColour = 'btn-muted';
    $notmovedColour = 'btn-muted';

    if(isset($_GET['aggregation']) || !isset($_GET['notmoved'])){
        if($aggregationType === 'daily') $dailyColour = 'btn-primary';
        if($aggregationType === 'weekly') $weeklyColour = 'btn-primary';

        //gombok színváltogatással
        echo '<a href="?page=transports&aggregation=daily"><button class="mb-2 btn ' . $dailyColour . '">Napi aggregáció</button></a>';
        echo '<a href="?page=transports&aggregation=weekly"><button class="mb-2 btn ' . $weeklyColour . '">Heti aggregáció</button></a>';
        echo '<a href="?page=transports&notmoved=1"><button class="mb-2 btn ' . $notmovedColour . '">A hónapban nem mozgatott</button></a>';

        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>' . ($aggregationType === 'daily' ? 'Dátum' : 'Hét') . '</th>';
        echo '<th>Honnan</th>';
        echo '<th>Hova</th>';
        echo '<th>Szállítandó termék</th>';
        echo '<th>Mennyiség</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $currentGroup = null;

        while ($row = mysqli_fetch_assoc($result)) {
            $key = $row['grouping_key'];
            $date = $row['transport_date'];
            $origin = $row['origin_site'];
            $dest = $row['dest_site'];
            $product = $row['product_name'];
            $quantity = $row['quantity'];

            $firstDayOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($date)));
            $lastDayOfWeek = date('Y-m-d', strtotime('sunday this week', strtotime($date)));

            echo '<tr>';
            //ez intézi azt hogy egy nap/hét csak egyszer legyen kiírva és ne minden sorban
            echo '<td>' . ($currentGroup !== $key ?
                    ($aggregationType === 'daily' ? $date : "$firstDayOfWeek - $lastDayOfWeek") : '') . '</td>';
            echo '<td>' . $origin . '</td>';
            echo '<td>' . $dest . '</td>';
            echo '<td>' . $product . '</td>';
            echo '<td>' . $quantity . '</td>';
            echo '</tr>';

            $currentGroup = $key;
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }else{
        //JELENLEGI HÓNAPBAN NEM MOZGATOTT ÁRUK
        $currentMonth = '20' . date('y-m');
        //nem mozgatott --> vagy nem szerepel a transport táblában (transport értékei null-ak a join után
        //vagy szerepel, de nem e havi szállítással

        $query = "SELECT 
                        product.product_id, 
                        product.product_name, 
                        transport.transport_date,
                        origin_sites.site_name AS origin_site_name,
                        dest_sites.site_name AS dest_site_name,
                        quantity
                    FROM 
                        product
                    LEFT JOIN 
                        transport ON product.product_id = transport.product_id
                    LEFT JOIN 
                        site AS origin_sites ON transport.origin_site_id = origin_sites.site_id
                    LEFT JOIN 
                        site AS dest_sites ON transport.dest_site_id = dest_sites.site_id
                    WHERE 
                        CONCAT(YEAR(transport.transport_date), MONTH(transport.transport_date)) != CONCAT(YEAR(CURDATE()), MONTH(CURDATE())) OR 
                         transport.transport_date IS NULL
                    ORDER BY product_name";

        $result = mysqli_query($conn, $query);

        $notmovedColour = 'btn-primary';
        echo '<a href="?page=transports&aggregation=daily"><button class="mb-2 btn ' . $dailyColour . '">Napi aggregáció</button></a>';
        echo '<a href="?page=transports&aggregation=weekly"><button class="mb-2 btn ' . $weeklyColour . '">Heti aggregáció</button></a>';
        echo '<a href="?page=transports&notmoved=1"><button class="mb-2 btn ' . $notmovedColour . '">A hónapban nem mozgatott</button></a>';

        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Szállítandó termék</th>';
        echo '<th>Dátum</th>';
        echo '<th>Honnan</th>';
        echo '<th>Hova</th>';
        echo '<th>Mennyiség</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $previousProd = "";
        while($row = mysqli_fetch_assoc($result)){
            $productName = $row['product_name'];
            $date = $row['transport_date'];
            $origin = $row['origin_site_name'];
            $dest = $row['dest_site_name'];
            $quantity = $row['quantity'];
            $no = "<strong>-</strong>";

            echo "<tr>";
            //itt ez intézi hogy csak az első előfordulásnál legyen productName
            if($previousProd !== $productName){
                echo "<td>" . $productName . "</td>";
            }else{
                echo "<td></td>";
            }
            echo "<td>" . ($date === null ? $no : $date) . "</td>";
            echo "<td>" . ($origin === null ? $no : $origin) . "</td>";
            echo "<td>" . ($dest === null ? $no : $dest) . "</td>";
            echo "<td>" . ($quantity === null ? $no : $quantity) . "</td>";
            echo "</tr>";

            $previousProd = $productName;
        }

    }
} else {
    echo "Hiba: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
