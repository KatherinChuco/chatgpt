<?php
session_start();

// Verificar si el carrito existe
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    echo "Tu carrito está vacío.";
    exit;
}

// Calcular el total
$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['producto']['precio'] * $item['cantidad'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito de Compras</title>
</head>
<body>
    <h1>Mi carrito de compras</h1>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
            <tr>
                <td><?php echo $item['producto']['nombre']; ?></td>
                <td>$<?php echo $item['producto']['precio']; ?></td>
                <td><?php echo $item['cantidad']; ?></td>
                <td>$<?php echo $item['producto']['precio'] * $item['cantidad']; ?></td>
                <td>
                    <a href="carrito.php?accion=eliminar&id=<?php echo $id; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <hr>
    <h3>Total: $<?php echo $total; ?></h3>
    <a href="procesar_pago.php">Procesar pago</a>
    <br>
    <a href="index.php">Seguir comprando</a>

    <?php
    // Eliminar producto del carrito
    if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar' && isset($_GET['id'])) {
        $id_producto = $_GET['id'];
        unset($_SESSION['carrito'][$id_producto]);
        header("Location: carrito.php");
        exit;
    }
    ?>
</body>
</html>
