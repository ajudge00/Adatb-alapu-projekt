<?

// csatlakozás az adatbázishoz

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, "raktar");

if ($conn->connect_error) {
    die("Csatlakozás sikertelen: " . $conn->connect_error);
}