<?php session_start(); ?>

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

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tutela La Dana - Ayuda a los afectados por la DANA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/main.css"> <!-- Estilo Spatial -->
</head>
<body class="landing">

<!-- Banner principal -->
<section id="banner" style="
  background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('img/ayuda_dana.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  text-align: center;
  color: white;
">
  <div style="padding: 4em 1em;">
    <h2>Bienvenido a Tutela La DANA</h2>
    <p>Unidos para ayudar a los afectados por la DANA</p>
    <ul class="actions">
      <li><a href="register.php" class="button special big">Únete a la causa</a></li>
    </ul>
  </div>
</section>



<!-- Footer -->
<?php include("includes/footer.php"); ?>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
