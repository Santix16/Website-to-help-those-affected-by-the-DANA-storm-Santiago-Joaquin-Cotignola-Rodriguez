<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>TELE-DANA - Servicios</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="landing">

<!-- Header -->
<header id="header" class="alt">
  <h1><strong><a href="index.php">TELE-DANA</a></strong></h1>
  <nav id="nav">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="contacto.php">Contacto</a></li>
      <li><a href="carrito.php">Carrito</a></li>
      <li><a href="perfil.php">Usuario</a></li>
      <li><a href="mensajes.php">Mensajes</a></li>
      <li><a href="logout.php">Cerrar sesión</a></li>
    </ul>
  </nav>
</header>

<!-- Banner -->
<section id="banner" style="
  background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('img/ayuda_dana.jpg');
  background-size: cover;
  background-position: center;
  color: white;
  text-align: center;">
  <div style="padding: 4em 1em;">
    <h2>Bienvenido a TELE-DANA</h2>
    <p>Explora nuestros servicios y ayuda a los afectados por la DANA</p>
  </div>
</section>

<!-- Servicios -->
<section class="wrapper style1">
  <div class="container">
    <header class="major special">
      <h2>Servicios disponibles</h2>
      <p>Selecciona una opción para comenzar</p>
    </header>
    <div class="feature-grid">
      <div class="feature">
        <div class="image rounded"><img src="img/servicio1.jpg" alt="Servicio 1"></div>
        <div class="content">
          <header><h4>Asistencia en emergencias</h4></header>
          <p>Apoyo a personas afectadas por la DANA a través de nuestros voluntarios.</p>
        </div>
      </div>
      <div class="feature">
        <div class="image rounded"><img src="img/servicio2.jpg" alt="Servicio 2"></div>
        <div class="content">
          <header><h4>Donaciones</h4></header>
          <p>Canaliza tu ayuda económica o en especie hacia quienes más lo necesitan.</p>
        </div>
      </div>
      <div class="feature">
        <div class="image rounded"><img src="img/servicio3.jpg" alt="Servicio 3"></div>
        <div class="content">
          <header><h4>Reparación de viviendas</h4></header>
          <p>Solicita ayuda o colabora en la recuperación de infraestructuras dañadas.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer compacto -->
<footer id="footer" style="
  padding: 0.8em 0;
  background: #f5f5f5;
  font-size: 0.8em;
  text-align: center;
  box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);">
  <div class="container">
    <p style="margin: 0;">© 2025 TELE-DANA. Todos los derechos reservados.</p>
    <a href="legal/legal.html">Términos de Uso</a> |
    <a href="legal/privacidad.html">Protección de Datos</a>
  </div>
</footer>

<!-- Scripts del tema -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>

