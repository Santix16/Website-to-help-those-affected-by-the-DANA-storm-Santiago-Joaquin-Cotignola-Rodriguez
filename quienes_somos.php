<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Quiénes Somos - Tutela La DANA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/main.css">
  <style>
    .grid-boxes {
      display: grid;
      grid-template-columns: 1fr;
      gap: 2em;
      padding-top: 2em;
    }

    .box-item {
      background: white;
      color: #333;
      padding: 2em;
      border-radius: 1em;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      position: relative;
    }

    .box-item .step {
      position: absolute;
      top: -20px;
      left: -20px;
      background: #007bff;
      color: white;
      font-size: 1.2em;
      font-weight: bold;
      padding: 0.5em 0.9em;
      border-radius: 50%;
      box-shadow: 0 0 8px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body class="landing">

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

<!-- Banner -->
<section id="banner">
  <h2>¿Quiénes Somos?</h2>
  <p>Comprometidos con brindar ayuda directa y solidaria a quienes más lo necesitan.</p>
</section>

<!-- Contenido con cuadros numerados -->
<section class="wrapper style2 special">
  <div class="container">
    <header class="major">
      <h3>Conócenos</h3>
    </header>

    <div class="grid-boxes">
      <div class="box-item">
        <span class="step">1</span>
        <p>
          En <strong>Tutela La DANA</strong> trabajamos para brindar una respuesta rápida y eficaz ante situaciones de emergencia social, especialmente aquellas provocadas por la DANA (Depresión Aislada en Niveles Altos). Nos especializamos en la distribución de recursos esenciales como alimentos, ropa, productos de higiene y orientación solidaria.
        </p>
      </div>

      <div class="box-item">
        <span class="step">2</span>
        <p>
          Nuestra labor se fundamenta en la cooperación entre ciudadanos voluntarios, entidades públicas y organizaciones aliadas. Esta red de apoyo nos permite llegar a quienes más lo necesitan con soluciones prácticas, humanas y totalmente gratuitas.
        </p>
      </div>

      <div class="box-item">
        <span class="step">3</span>
        <p>
          En cada acción priorizamos la dignidad, la igualdad de acceso y el bienestar de las personas. Creemos que la solidaridad debe estar acompañada de una gestión responsable y transparente.
        </p>
      </div>

      <div class="box-item">
        <span class="step">4</span>
        <p>
          Si eres una persona afectada, aquí encontrarás un espacio seguro y accesible. Si deseas colaborar, eres parte del cambio. <strong>Juntos somos más fuertes.</strong>
        </p>
      </div>
    </div>

    <footer style="margin-top: 2em;">
      <a href="servicios.php" class="button special big">Explora nuestros servicios</a>
    </footer>
  </div>
</section>

<?php include("includes/footer.php"); ?>
</body>
</html>
