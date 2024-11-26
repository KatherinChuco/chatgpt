<?php
require_once 'vendor/autoload.php';

session_start();
\Stripe\Stripe::setApiKey('tu_clave_secreta_de_stripe');

// Verificar el carrito
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    die("Tu carrito está vacío.");
}

// Calcular el total
$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['producto']['precio'] * $item['cantidad'];
}

// Crear un Checkout Session con Stripe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Crear sesión de pago en Stripe
    try {
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => array_map(function($item) {
                return [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item['producto']['nombre'],
                        ],
                        'unit_amount' => $item['producto']['precio'] * 100, // Convertir a centavos
                    ],
                    'quantity' => $item['cantidad'],
                ];
            }, $_SESSION['carrito']),
            'mode' => 'payment',
            'success_url' => 'https://tusitio.com/success',
            'cancel_url' => 'https://tusitio.com/cancel',
        ]);

        // Redirigir a Stripe Checkout
        header("Location: " . $session->url);
        exit;

    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<form method="POST">
    <button type="submit">Pagar con Stripe</button>
</form>
