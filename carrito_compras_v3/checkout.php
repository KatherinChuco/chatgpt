<?php
session_start();

// Simular procesamiento de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí podrías integrar una API de pago (como Stripe o PayPal)
    $_SESSION['cart'] = []; // Vaciar el carrito tras el pago
    $message = "¡Pago procesado con éxito! Gracias por tu compra.";
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
    <h1>Procesar Pago</h1>
    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php else: ?>
        <p>¿Estás seguro de que deseas procesar el pago?</p>
        <form method="post">
            <button type="submit">Confirmar Pago</button>
        </form>
    <?php endif; ?>
    <a href="index.php">Volver a la tienda</a>
</body>
</html>
