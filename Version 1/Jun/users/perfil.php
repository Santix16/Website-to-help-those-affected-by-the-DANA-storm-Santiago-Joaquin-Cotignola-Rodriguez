<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
    // Si el usuario no está logueado, mostrar el mensaje
    $mostrarMensaje = true;
} else {
    // Si está logueado, asignamos la variable para mostrar la información
    $mostrarMensaje = false;
}
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil - TELE-DANA</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

    <!-- Header -->
    <header id="header" class="alt">
        <h1><strong><a href="index.php">TELE-DANA</a></strong></h1>
        <nav id="nav">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="tienda.php">Tienda</a></li>
                <li><a href="pedidos/historial.php">Pedidos</a></li>
                <li><a href="carrito/index.php">Carrito</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <!-- Banner -->
    <section id="banner">
        
    </section>

    <!-- Si el usuario no está logueado, mostrar el mensaje -->
    <?php if ($mostrarMensaje): ?>
    <section id="mensaje" class="wrapper style1">
        <div class="container 75%">
            <div class="row 200%">
                <div class="6u 12u$(medium)">
                    <header class="major">
                        <h2>Por favor, inicie sesión</h2>
                        <p>Para acceder a tu perfil, necesitas estar logueado.</p>
                    </header>
                </div>
                <div class="6u$ 12u$(medium)">
                    <p>Si ya tienes cuenta, por favor, inicia sesión para ver y editar tu perfil.</p>
                    <ul class="actions">
                        <li><a href="../login.html" class="button special big">Iniciar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php else: ?>
        <!-- Si está logueado, mostrar su información -->
        <section id="one" class="wrapper style1">
            <div class="container 75%">
                <div class="row 200%">
                    <div class="6u 12u$(medium)">
                        <header class="major">
                            <h2>Tu información</h2>
                            <p>Detalles de tu perfil</p>
                        </header>
                    </div>
                    <div class="6u$ 12u$(medium)">
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['email']); ?></p>
                        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['telefono']); ?></p>
                        <p><strong>Valoración:</strong> ☆ (4.5/5)</p>
                        <p><strong>Sobre mí:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['sobre_mi']); ?></p>
                        <p><strong>Productos en venta:</strong></p>
                        <ul>
                            <li>Producto 1</li>
                            <li>Producto 2</li>
                            <li>Producto 3</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

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
        © 2025 TELE-DANA. Todos los derechos reservados. |
        <a href="legal/legal.html">Términos de Uso</a> |
        <a href="legal/privacidad.html">Protección de Datos</a>
    </div>

    <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/skel.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>

</body>
</html>




