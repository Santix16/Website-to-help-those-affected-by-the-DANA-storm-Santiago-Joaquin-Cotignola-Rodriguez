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

<?php include_once 'includes/header.php'; ?>

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
