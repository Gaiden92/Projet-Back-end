<?php
try {
    $pdo = new PDO(
        sprintf('mysql:host=localhost;dbname=swap;', DB_HOST, DB_NAME),
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::MYSQL_ATTR_INIT_COMMAND 	=> 'SET NAMES utf8',
            
        ]
    );
    
} catch(Exception $e) {
    die('Erreur de connexion à MySQL: ' . $e->getMessage());
}
?>