<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // csatlakozas a dbhez
    include_once "connectDB.php";

    // user input
    $email = mysqli_real_escape_string($conn, $_POST['login-email']);
    $password = mysqli_real_escape_string($conn, $_POST['login-password']);

    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Hiba: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        //echo $user;

        if (password_verify($password, $user['user_password'])) {
            // pw helyes
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['user_role'];

            mysqli_close($conn);
            header("Location: ../index.php?page=logreg&logsuccess=1");
            exit();
        } else {
            // pw helytelen
            mysqli_close($conn);
            header("Location: ../index.php?page=logreg&loginerror=1");
            exit();
        }

    } else {
        // user nem létezik
        header("Location: ../index.php?page=logreg&loginerror=1");
        mysqli_close($conn);
        exit();
    }
} else {
    // redirect a login pagere ha a login nem volt triggerelve
    header("Location: ../index.php?page=logreg");
    exit();
}

?>
