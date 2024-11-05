<?php
session_start();

if (!isset($_SESSION['Username'])) {
    echo "Sesión no iniciada. Redirigiendo a login.php";
    header("Location: login.php");
    exit();
} else {
    echo "Sesión iniciada como: " . $_SESSION['Username'];
}
?>