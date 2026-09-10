<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Servicios - Tutela La DANA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="landing">

<?php include_once 'includes/header.php'; ?>

<!-- Banner -->
<section id="banner">
  <h2>Nuestros Servicios</h2>
  <p>Accede a apoyo alimentario, productos esenciales y más, todo en un solo lugar.</p>
  <ul class="actions">
    <li><a href="#servicios" class="button special big">Explorar Servicios</a></li>
  </ul>
</section>

<!-- Sección de Categorías -->
<section id="servicios" class="wrapper style2 special">
  <div class="container">
    <header class="major">
      <h2>Categorías Principales</h2>
      <p>Selecciona el tipo de servicio que necesitas</p>
    </header>
    <div class="row 150%">
      <!-- Alimentos -->
      <div class="4u 12u$(medium)">
        <div class="image fit captioned">
          <img src="images/alimentos.jpg" alt="Alimentos" />
          <h3>Alimentos</h3>
          <p>Agua potable, comidas preparadas, frutas y verduras.</p>
          <?php if (isset($_SESSION['usuario'])): ?>
            <a href="servicios_alimentos.php" class="button small">Ver alimentos</a>
          <?php else: ?>
            <a href="login.php" class="button small">Iniciar sesión para alimentos</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Limpieza -->
      <div class="4u 12u$(medium)">
        <div class="image fit captioned">
          <img src="images/limpieza.jpg" alt="Limpieza" />
          <h3>Limpieza</h3>
          <p>Productos de higiene personal y limpieza del hogar.</p>
          <?php if (isset($_SESSION['usuario'])): ?>
            <a href="servicios_limpieza.php" class="button small">Ver limpieza</a>
          <?php else: ?>
            <a href="login.php" class="button small">Iniciar sesión para limpieza</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Ropa -->
      <div class="4u 12u$(medium)">
        <div class="image fit captioned">
          <img src="images/ropa.jpg" alt="Ropa" />
          <h3>Ropa</h3>
          <p>Ropa donada, mantas y calzado de emergencia.</p>
          <?php if (isset($_SESSION['usuario'])): ?>
            <a href="servicios_ropa.php" class="button small">Ver ropa</a>
          <?php else: ?>
            <a href="login.php" class="button small">Iniciar sesión para ropa</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include_once 'includes/footer.php'; ?>
</body>
</html>
