<?php
require_once 'config.php';

function obtenerProductos() {
    $db = getDB();
    $query = "SELECT * FROM productos";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$productos = obtenerProductos();
?>
