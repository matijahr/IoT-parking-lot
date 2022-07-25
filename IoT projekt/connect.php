<?php
final class DBConfig
{
    const HOST = 'localhost';
    const DB_NAME = 'iot project';
    const USERNAME = 'root';
    const PASS = '';
}

try {
    $conn = new PDO(
        "mysql:host=" . DBConfig::HOST . ";dbname=" . DBConfig::DB_NAME,
        DBConfig::USERNAME,
        DBConfig::PASS
    );
    

} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

