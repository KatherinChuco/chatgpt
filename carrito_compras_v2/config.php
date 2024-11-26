<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'tienda');
define('DB_USER', 'root');  // Cambia esto por tus credenciales de DB
define('DB_PASS', '');      // Cambia esto por tus credenciales de DB

function getDB() {
    $dbConnection = null;
    try {
        $dbConnection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
    return $dbConnection;
}
?>
