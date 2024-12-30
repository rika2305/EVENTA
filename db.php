<?php
$host = 'localhost';
$dbname = 'users';
$username = 'root'; // Sesuaikan dengan username database Anda
$password = '';     // Sesuaikan dengan password database Anda

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
