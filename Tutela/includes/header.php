<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include_once __DIR__ . '/config.php'; // Asegura que BASE_URL esté disponible

// Función para marcar el enlace activo
function isActive($path) {
    return strpos($_SERVER['REQUEST_URI'], $path) !== false ? 'class="active"' : '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutela La DANA</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="landing">

<header id="header" class="alt">
    <h1><a href="<?= BASE_URL ?>index.php"><strong>Tutela La DANA</strong></a></h1>
    <nav id="nav">
        <ul>
            <li><a href="<?= BASE_URL ?>index.php" <?= isActive('/index.php') ?>>Inicio</a></li>
            <li><a href="<?= BASE_URL ?>servicios.php" <?= isActive('/servicios.php') ?>>Servicios</a></li>
            <li><a href="<?= BASE_URL ?>quienes_somos.php" <?= isActive('/quienes_somos') ?>>Quiénes Somos</a></li>
            <li><a href="<?= BASE_URL ?>contacto/contacto.php" <?= isActive('/contacto') ?>>Contacto</a></li>
            <li><a href="<?= BASE_URL ?>carrito/index.php" <?= isActive('/carrito') ?>>Carrito</a></li>
            <li><a href="<?= BASE_URL ?>users/perfil.php" <?= isActive('/perfil.php') ?>>Usuario</a></li>
            <li><a href="<?= BASE_URL ?>mensajes/inbox.php" <?= isActive('/inbox.php') ?>>Mensaje</a></li>
            <li><a href="<?= BASE_URL ?>pedidos/historial.php" <?= isActive('/historial.php') ?>>Pedidos</a></li>

            <?php if (isset($_SESSION['usuario'])): ?>
                <li><a href="<?= BASE_URL ?>logout.php">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>login.php" <?= isActive('/login.php') ?>>Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<a href="#menu" class="navPanelToggle" aria-label="Abrir menú"><span class="fa fa-bars"></span></a>

