<?php
$databaseHost = 'localhost';
$databaseName = 'nexusolutions_db';
$databaseUser = 'root';
$databasePassword = '';

try {
    $pdo = new PDO(
        "mysql:host=$databaseHost;dbname=$databaseName;charset=utf8mb4",
        $databaseUser,
        $databasePassword
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $connectionError) {
    die("Database Connection Failed: " . $connectionError->getMessage());
}
?>