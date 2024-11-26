<?php
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Función para agregar producto al carrito
function addToCart($productId, $productName, $price, $quantity = 1) {
    $cart = $_SESSION['cart'];
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
    } else {
        $cart[$productId] = [
            'name' => $productName,
            'price' => $price,
            'quantity' => $quantity,
        ];
    }
    $_SESSION['cart'] = $cart;
}

// Función para eliminar un producto del carrito
function removeFromCart($productId) {
    $cart = $_SESSION['cart'];
    if (isset($cart[$productId])) {
        unset($cart[$productId]);
    }
    $_SESSION['cart'] = $cart;
}

// Función para obtener el total del carrito
function getCartTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $product) {
        $total += $product['price'] * $product['quantity'];
    }
    return $total;
}

// Manejar acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'add') {
            addToCart($_POST['id'], $_POST['name'], $_POST['price'], $_POST['quantity']);
        } elseif ($action === 'remove') {
            removeFromCart($_POST['id']);
        } elseif ($action === 'checkout') {
            header('Location: checkout.php');
            exit;
        }
    }
}

// Productos de ejemplo
$products = [
    ['id' => 1, 'name' => 'Producto A', 'price' => 10.00],
    ['id' => 2, 'name' => 'Producto B', 'price' => 15.00],
    ['id' => 3, 'name' => 'Producto C', 'price' => 20.00],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Tienda</h1>
    <h2>Productos</h2>
    <ul>
        <?php foreach ($products as $product): ?>
        <li>
            <strong><?= htmlspecialchars($product['name']) ?></strong> -
            $<?= number_format($product['price'], 2) ?>
            <form method="post" style="display:inline;">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                <input type="hidden" name="price" value="<?= $product['price'] ?>">
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit">Agregar al carrito</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>

    <h2>Carrito</h2>
    <ul>
        <?php foreach ($_SESSION['cart'] as $id => $product): ?>
        <li>
            <strong><?= htmlspecialchars($product['name']) ?></strong> -
            $<?= number_format($product['price'], 2) ?> x <?= $product['quantity'] ?> =
            $<?= number_format($product['price'] * $product['quantity'], 2) ?>
            <form method="post" style="display:inline;">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit">Eliminar</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total:</strong> $<?= number_format(getCartTotal(), 2) ?></p>
    <form method="post">
        <input type="hidden" name="action" value="checkout">
        <button type="submit">Procesar pago</button>
    </form>
</body>
</html>
