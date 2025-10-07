<?php session_start();

// include ("users-pdo.php");

if (isset($_SESSION['user']) && $_SESSION['user']['logged'] === true) {
    session_destroy();
    header('Location: index.php');
    exit();
}
session_destroy();


header('Location: index.php');
exit();