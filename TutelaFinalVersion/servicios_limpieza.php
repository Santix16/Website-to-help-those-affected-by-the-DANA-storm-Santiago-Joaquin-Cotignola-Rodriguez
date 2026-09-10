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

<?php include_once 'includes/header.php'; ?>

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
