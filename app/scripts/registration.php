<?php
session_start();

include "connectDB.php";

// User input extraction
$name = $_POST['registration-name'];
$email = $_POST['registration-email'];
$password = $_POST['registration-password'];
$password_confirm = $_POST['registration-password-confirm'];

// Check if passwords match
if ($password !== $password_confirm) {
    header("Location: ../index.php?page=logreg&registrationerror=1&errormsg=A két jelszó nem egyezik");
    exit();
}

// Check if email is already registered
$sql_check_email = 'SELECT COUNT(*) FROM FELHASZNALO WHERE email = :email';
$stmt_check_email = oci_parse($conn, $sql_check_email);
oci_bind_by_name($stmt_check_email, ':email', $email);
oci_execute($stmt_check_email);
$row = oci_fetch_array($stmt_check_email);
$email_count = $row[0];
oci_free_statement($stmt_check_email);

if ($email_count > 0) {
    header("Location: ../index.php?page=logreg&registrationerror=1&errormsg=Ezzel az email-címmel már létezik felhasználó");
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user into database
$sql_insert_user = 'INSERT INTO FELHASZNALO (NEV, EMAIL, JELSZO) VALUES (:name, :email, :password)';
$stmt_insert_user = oci_parse($conn, $sql_insert_user);
oci_bind_by_name($stmt_insert_user, ':name', $name);
oci_bind_by_name($stmt_insert_user, ':email', $email);
oci_bind_by_name($stmt_insert_user, ':password', $hashed_password);
oci_execute($stmt_insert_user);

oci_free_statement($stmt_insert_user);
oci_close($conn);

header("Location: ../index.php?page=logreg&registrationsuccess=1");
exit();

?>
