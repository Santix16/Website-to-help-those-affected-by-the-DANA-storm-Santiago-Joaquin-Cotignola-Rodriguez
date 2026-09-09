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
  <title>Servicio de Alimentos</title>
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
<section id="servicio-comida" class="wrapper style1">
  <div class="container">
    <header class="major">
      <h2>Servicios de Comida</h2>
      <p>Alimentos disponibles para personas afectadas por la DANA. Puedes solicitar cada producto individualmente según tus necesidades.</p>
    </header>

    <div class="box alt">
      <div class="row uniform 50%">

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/alimentos.jpg" alt="Comida preparada" /></span>
          <h4>Comida preparada (listo para calentar)</h4>
          <a href="formulario_solicitud.php?tipo=comida_preparada" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/alimentos.jpg" alt="Latas de conserva" /></span>
          <h4>Latas de conserva (atún, legumbres, sopa)</h4>
          <a href="formulario_solicitud.php?tipo=conservas" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/alimentos.jpg" alt="Pan y galletas" /></span>
          <h4>Pan y galletas secas</h4>
          <a href="formulario_solicitud.php?tipo=pan_galletas" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/alimentos.jpg" alt="Leche en polvo" /></span>
          <h4>Leche en polvo o UHT</h4>
          <a href="formulario_solicitud.php?tipo=leche" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/alimentos.jpg" alt="Agua potable" /></span>
          <h4>Agua potable embotellada (1L o 5L)</h4>
          <a href="formulario_solicitud.php?tipo=agua" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/alimentos.jpg" alt="Frutas" /></span>
          <h4>Frutas no perecederas</h4>
          <a href="formulario_solicitud.php?tipo=frutas" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/alimentos.jpg" alt="Arroz y pasta" /></span>
          <h4>Paquetes de arroz y pasta</h4>
          <a href="formulario_solicitud.php?tipo=arroz_pasta" class="button small">Solicitar</a>
        </div>

      </div>
    </div>
  </div>
</section>

<?php include_once 'includes/footer.php'; ?>
</body>
</html>
