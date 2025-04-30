<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/functions.php';

// Verificar si existe el carrito en la sesión, si no, inicializarlo
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrito de Compras - DANA</title>
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="stylesheet" href="../assets/css/main.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body class="landing">

<!-- Header -->
<header id="header" class="alt">
    <h1><strong><a href="../index.html">Spatial</a></strong> by Templated</h1>
    <nav id="nav">
        <ul>
            <li><a href="../index.html">Home</a></li>
            <li><a href="../productos/index.php">Productos</a></li>
            <li><a href="contacto/contacto.php">Contacto</a></li>
            <li><a href="../pedidos/historial.php">Pedidos</a></li>
        </ul>
    </nav>
</header>

<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>

<!-- Banner -->
<section id="banner">

    <?php if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])): ?>
        <!-- Si el usuario NO ha iniciado sesión -->
        <section id="banner">
            <h2>Acceso Restringido</h2>
            <p style="text-align:center; font-size: 1.2em; color: #888;">
                Debes <a href="../login.html">iniciar sesión</a> para acceder al carrito de compras.
            </p>
        </section>
    <?php else: ?>
        <h2>Carrito de Compras</h2>
        <p>Revisa los productos que has agregado a tu carrito.</p>
        <!-- Si el usuario está logueado, muestra el carrito -->
        <section id="one" class="wrapper style1">
            <div class="container 75%">
                <div class="row 200%">
                    <div class="12u">
                        <header class="major">
                            <h2>Tu Carrito de Compras</h2>
                        </header>

                        <?php
                        if (empty($_SESSION['carrito'])) {
                            echo "<p>No has agregado ningún producto al carrito.</p>";
                        } else {
                            $total = 0;
                            echo '<table border="1" cellpadding="10" cellspacing="0">';
                            echo '<thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario (tonkens)</th>
                                        <th>Subtotal (tonkens)</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';

                            // Recorrer cada producto en el carrito
                            foreach ($_SESSION['carrito'] as $producto_id => $cantidad) {
                                // Consultar información del producto
                                $stmt = $conexion->prepare("SELECT nombre, precio_tonkens FROM productos WHERE id = ?");
                                $stmt->bind_param("i", $producto_id);
                                $stmt->execute();
                                $resultado = $stmt->get_result();
                                if ($resultado && $resultado->num_rows > 0) {
                                    $producto = $resultado->fetch_assoc();
                                    $subtotal = $cantidad * $producto['precio_tonkens'];
                                    $total += $subtotal;

                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
                                    echo "<td>" . $cantidad . "</td>";
                                    echo "<td>" . $producto['precio_tonkens'] . "</td>";
                                    echo "<td>" . $subtotal . "</td>";
                                    echo "<td>
                                            <a href='eliminar_del_carrito.php?id=" . $producto_id . "' onclick=\"return confirm('¿Estás seguro de eliminar este producto?');\">Eliminar</a>
                                        </td>";
                                    echo "</tr>";
                                }
                            }
                            echo '</tbody></table>';
                            echo "<p><strong>Total:</strong> " . $total . " tonkens</p>";
                            echo '<p><a href="checkout.php" class="button special big">Finalizar Compra</a></p>';
                        }
                        ?>

                        <p><a href="../productos/index.php" class="button big">Continuar Comprando</a></p>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</section>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <ul class="icons">
            <li><a href="#" class="icon fa-facebook"></a></li>
            <li><a href="#" class="icon fa-twitter"></a></li>
            <li><a href="#" class="icon fa-instagram"></a></li>
        </ul>
    </div>
</footer>

<div class="copyright">
    © 2025 DANA. Todos los derechos reservados. |
    <a href="../legal/legal.html">Términos de Uso</a> |
    <a href="../legal/privacidad.html">Protección de Datos</a>
</div>

<!-- Scripts -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/skel.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>
















