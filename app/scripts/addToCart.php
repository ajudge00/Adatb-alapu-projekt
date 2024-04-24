<?php
session_start(); // Start session if not already started

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["book_id"])) {
        $book_id = $_POST["book_id"];
        
        // Add book_id to cart session variable
        $_SESSION["cart"][$book_id] = isset($_SESSION["cart"][$book_id]) ? $_SESSION["cart"][$book_id] + 1 : 1;
        
        // Set a flag to indicate that item has been added to cart
        $_SESSION["cart_added"] = true;
    }
}

// Redirect back to the previous page
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>
