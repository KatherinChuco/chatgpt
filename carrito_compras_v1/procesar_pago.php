<?php
session_start();

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    echo "Tu carrito está vacío. No puedes proceder al pago.";
    exit;
}

// Calcular el total
$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['producto']['precio'] * $item['cantidad'];
}

// Procesar el pago (simulado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simular pago exitoso
    unset($_SESSION['carrito']);
    echo "¡Pago realizado con éxito! Tu compra ha sido procesada.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Pago</title>
</head>
<body>
    <h1>Procesar pago</h1>
    <p>Total a pagar: $<?php echo $total; ?></p>
    
    <form method="post">
        <h3>Detalles de pago</h3>
        <label for="tarjeta">Número de tarjeta:</label><br>
        <input type="text" id="tarjeta" name="tarjeta" required><br><br>
        
        <label for="fecha">Fecha de vencimiento:</label><br>
        <input type="text" id="fecha" name="fecha" required><br><br>
        
        <button type="submit">Pagar</button>
    </form>

    <br>
    <a href="carrito.php">Volver al carrito</a>
</body>
</html>
