<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Servicio de Limpieza</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<!-- Header -->
<header id="header" class="alt">
  <h1><strong><a href="index.php">Tutela La DANA</a></strong></h1>
  <nav id="nav">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="servicios.php">Servicios</a></li>
      <li><a href="quienes_somos.php">Quiénes Somos</a></li>
      <li><a href="contacto/contacto.php">Contacto</a></li>
      <li><a href="carrito/index.php">Carrito</a></li>
      <li><a href="users/perfil.php">Usuario</a></li>
      <li><a href="pedidos/historial.php">Pedidos</a></li>
      <?php if (isset($_SESSION['usuario'])): ?>
        <li><a href="logout.php">Cerrar sesión</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<!-- Contenido -->
<section class="wrapper style1">
  <div class="container">
    <header class="major">
      <h2>Productos de Limpieza</h2>
      <p>Artículos disponibles para higiene personal y del hogar.</p>
    </header>

    <div class="box alt">
      <div class="row uniform 50%">

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/limpieza.jpg" alt="Jabón" /></span>
          <h4>Jabón y champú</h4>
          <a href="formulario_solicitud.php?tipo=jabon" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/limpieza.jpg" alt="Papel Higiénico" /></span>
          <h4>Papel higiénico</h4>
          <a href="formulario_solicitud.php?tipo=papel" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/limpieza.jpg" alt="Detergente" /></span>
          <h4>Detergente y limpiadores</h4>
          <a href="formulario_solicitud.php?tipo=detergente" class="button small">Solicitar</a>
        </div>

      </div>
    </div>
  </div>
</section>

<?php include_once 'includes/footer.php'; ?>
</body>
</html>
