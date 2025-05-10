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
  <title>Servicio de Ropa</title>
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
      <li><a href="mensajes/inbox.php">Mensaje</a></li>
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
      <h2>Ropa y Calzado</h2>
      <p>Productos textiles donados disponibles para quien lo necesite.</p>
    </header>

    <div class="box alt">
      <div class="row uniform 50%">

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/ropa_mujer.jpg" alt="Ropa mujer" /></span>
          <h4>Ropa para mujer</h4>
          <a href="formulario_solicitud.php?tipo=ropa_mujer" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/ropa_hombre.jpg" alt="Ropa hombre" /></span>
          <h4>Ropa para hombre</h4>
          <a href="formulario_solicitud.php?tipo=ropa_hombre" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/ropa_niño.jpg" alt="Ropa niño" /></span>
          <h4>Ropa para niños</h4>
          <a href="formulario_solicitud.php?tipo=ropa_nino" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/calzados.jpg" alt="Calzado" /></span>
          <h4>Calzado y mantas</h4>
          <a href="formulario_solicitud.php?tipo=calzado" class="button small">Solicitar</a>
        </div>

      </div>
    </div>
  </div>
</section>

<?php include("includes/footer.php"); ?>
</body>
</html>
