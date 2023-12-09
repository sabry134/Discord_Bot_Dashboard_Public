<?php
session_start();
if (!$_SESSION['logged_in']) {
    header('Location: error.php');
    exit();
}
require_once 'config.php';

$url = "https://github.com/login/oauth/authorize?client_id=$client_id&scope=repo";
header("Location: $url");
