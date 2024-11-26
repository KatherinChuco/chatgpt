<?php
session_start();
require_once 'productos.php';

// Verificar si se ha añadido un producto al carrito
if (isset($_GET['accion']) && $_GET['accion'] == 'agregar' && isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Verificar si el carrito ya existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto]['cantidad']++;
    } else {
        // Agregar el producto al carrito
        $_SESSION['carrito'][$id_producto] = [
            'producto' => $productos[$id_producto],
            'cantidad' => 1
        ];
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Productos disponibles</h1>
    <ul>
        <?php foreach ($productos as $producto): ?>
            <li>
                <strong><?php echo htmlspecialchars($producto['nombre']); ?></strong> - $<?php echo $producto['precio']; ?>
                <a href="index.php?accion=agregar&id=<?php echo $producto['id']; ?>">Agregar al carrito</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <hr>
    <a href="carrito.php">Ver mi carrito</a>
</body>
</html>
