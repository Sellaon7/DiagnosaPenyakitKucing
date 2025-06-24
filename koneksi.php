<?php
$host = '127.0.0.1';
$db = 'jst_kucing';
$user = 'root'; // ganti dengan user database Anda
$pass = ''; // ganti dengan password database Anda

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
