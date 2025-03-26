<?php
session_start();
include('constants.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === USER && $password === PASSWORD) {
        $_SESSION['logged_in'] = true;
        header('Location: dashboard.php'); 
    } else {
        echo "<script>alert('Usuário ou senha inválidos.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>window.location.href='index.php';</script>";
}
?>
