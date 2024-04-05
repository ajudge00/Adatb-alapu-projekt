<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "connectDB.php";

    $fullname = mysqli_real_escape_string($conn, $_POST['register-fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['register-email']);
    $password = mysqli_real_escape_string($conn, $_POST['register-password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['register-confirm-password']);

    //két jelszó nem egyezik
    if ($password !== $confirmPassword) {
        header("Location: ../index.php?page=logreg&regerror=1");
        exit();
    }


    $existingEmails = "SELECT email FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $existingEmails);
    if(mysqli_num_rows($result) > 0) {
        //ezzel az emaillel már van user
        mysqli_close($conn);
        header("Location: ../index.php?page=logreg&regerror=2");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (full_name, email, user_password, user_role) VALUES ('$fullname', '$email', '$hashedPassword', 'normal')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: ../index.php?page=logreg&regerror=0");
        mysqli_close($conn);
        exit();
    } else {
        header("Location: ../index.php?page=logreg&regerror=3");
        mysqli_close($conn);
        exit();
    }
} else {
    header("Location: ../index.php?page=logreg");
    exit();
}
?>
