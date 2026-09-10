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

<?php include_once 'includes/header.php'; ?>

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
          <span class="image fit"><img src="images/ropa.jpg" alt="Ropa mujer" /></span>
          <h4>Ropa para mujer</h4>
          <a href="formulario_solicitud.php?tipo=ropa_mujer" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/ropa.jpg" alt="Ropa hombre" /></span>
          <h4>Ropa para hombre</h4>
          <a href="formulario_solicitud.php?tipo=ropa_hombre" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/ropa.jpg" alt="Ropa niño" /></span>
          <h4>Ropa para niños</h4>
          <a href="formulario_solicitud.php?tipo=ropa_nino" class="button small">Solicitar</a>
        </div>

        <div class="4u 12u$(medium)">
          <span class="image fit"><img src="images/ropa.jpg" alt="Calzado" /></span>
          <h4>Calzado y mantas</h4>
          <a href="formulario_solicitud.php?tipo=calzado" class="button small">Solicitar</a>
        </div>

      </div>
    </div>
    <hr />
    <!-- Botón de retorno a la página principal de servicios -->
    <ul class="actions align-center">
      <li><a href="servicios.php" class="button special">← Volver a Servicios Principales</a></li>
    </ul>
  </div>
</section>

<?php include_once 'includes/footer.php'; ?>
</body>
</html>
