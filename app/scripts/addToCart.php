<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["item_id"])) {
        $item_id = $_POST["item_id"];

        if (isset($_COOKIE["cart"])) {
            $cart = json_decode($_COOKIE["cart"], true);
        } else {
            $cart = [];
        }

        if (array_key_exists($item_id, $cart)) {
            $cart[$item_id]++;
        } else {
            $cart[$item_id] = 1;
        }

        setcookie("cart", json_encode($cart), time() + (86400 * 30), "/");


        $_SESSION["cart_added"] = true;
    }
}


header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>
