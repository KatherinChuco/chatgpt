<?php
session_start();

// Base de datos simulada (sin conexión real)
$productos = [
    1 => ['nombre' => 'Producto A', 'precio' => 100, 'stock' => 2],
    2 => ['nombre' => 'Producto B', 'precio' => 50, 'stock' => 1]
];

// 1. Falsificación de registros (Log Forging)
$usuario = $_GET['usuario'];
error_log("Usuario ingresó: $usuario");

// 2. Inyección de XSS al mostrar productos
$idProducto = $_GET['producto'];  // No validado
echo "<h3>Detalles del producto:</h3>";
echo "Nombre: " . $productos[$idProducto]['nombre'] . "<br>";
echo "Precio: $" . $_GET['precio'] . "<br>"; // XSS posible en precio

// 3. Simulación de compra (Race Condition)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productoId = $_POST['id']; // Sin verificar entrada
    $cantidad = $_POST['cantidad'];

    if ($productos[$productoId]['stock'] >= $cantidad) {
        $productos[$productoId]['stock'] -= $cantidad;
        // Escribe stock actualizado sin control de concurrencia
        file_put_contents('stock.txt', $productos[$productoId]['stock']);
        echo "Compra realizada con éxito.<br>";
    } else {
        echo "Stock insuficiente.<br>";
    }
}

// 4. Infracción de privacidad (mensaje de error)
$conexion = mysqli_connect("localhost", "root", "password", "tienda");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error()); // Expone información sensible
}

// 5. Gestión insegura de contraseñas
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    file_put_contents('passwords.txt', $password);  // Guardado en texto plano
}

// Formulario de compra
?>
<form method="POST">
    <input type="text" name="id" placeholder="ID del producto">
    <input type="number" name="cantidad" placeholder="Cantidad">
    <button type="submit">Comprar</button>
</form>

<form method="POST">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Guardar Contraseña</button>
</form>
