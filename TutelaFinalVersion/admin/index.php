<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['role'] ?? 'USER') !== 'ADMIN') {
    http_response_code(403);
    exit('Acceso restringido. Necesitas una cuenta de administrador.');
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Administración - Tutela La DANA</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

<?php include_once __DIR__ . '/nav.php'; ?>

<section id="main" class="wrapper style1">
  <div class="container">
    <header class="major">
      <h2>Panel de Control</h2>
      <p>Selecciona una opción para administrar el sistema o acceder como usuario.</p>
    </header>

    <h3>Módulos de Gestión</h3>
    <div class="row 50%">
      <div class="4u 12u$(xsmall)"><a href="donaciones.php" class="button special fit">Gestión de Donaciones</a></div>
      <div class="4u 12u$(xsmall)"><a href="pedidos.php" class="button special fit">Gestión de Pedidos</a></div>
      <div class="4u$ 12u$(xsmall)"><a href="stock.php" class="button special fit">Control de Stock</a></div>
      <div class="3u$ 12u$(xsmall)"><a href="mensajes.php" class="button special fit">Gestión de Mensajes</a></div>
    </div>
  </div>
</section>

</body>
</html>