<?php

session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "pinkvault";

$heart = mysqli_connect(
    $host,
    $user,
    $pass,
    $db
);

if (!$heart) {
    die("Oopsie! Database tidak terhubung 💔");
}