<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$servicios = [
    'ropa_mujer' => 'Ropa para mujer',
    'ropa_hombre' => 'Ropa para hombre',
    'ropa_nino' => 'Ropa para niños',
    'calzado' => 'Calzado y mantas',
    'comida_preparada' => 'Comida preparada',
    'conservas' => 'Latas de conserva',
    'pan_galletas' => 'Pan y galletas',
    'leche' => 'Leche en polvo o UHT',
    'agua' => 'Agua potable',
    'frutas' => 'Frutas no perecederas',
    'arroz_pasta' => 'Arroz y pasta',
    'jabon' => 'Jabón y champú',
    'papel' => 'Papel higiénico',
    'detergente' => 'Detergente y limpiadores'
];

$tipo = $_GET['tipo'] ?? $_POST['tipo'] ?? '';
$nombreServicio = $servicios[$tipo] ?? null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($nombreServicio === null) {
        $error = 'El servicio seleccionado no es válido.';
    } else {
        require_once __DIR__ . '/includes/db.php';

        try {
            $usuarioId = (int) ($_SESSION['usuario']['id'] ?? 0);
            if ($usuarioId <= 0) {
              throw new InvalidArgumentException('La sesión de usuario no es válida.');
            }

            $estado = 'solicitud:' . $tipo;
            $stmt = $conexion->prepare(
                'INSERT INTO pedidos (usuario_id, estado, total_tonkens) VALUES (:usuario_id, :estado, 0)'
            );
            $stmt->execute([
                ':usuario_id' => $usuarioId,
                ':estado' => $estado
            ]);

            header('Location: pedidos/historial.php?solicitud=1');
            exit();
        } catch (Throwable $exception) {
            $error = 'No se pudo guardar la solicitud. Comprueba la conexión con la base de datos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Solicitar ayuda - Tutela La DANA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="landing">
<header id="header" class="alt">
  <h1><strong><a href="index.php">Tutela La DANA</a></strong></h1>
  <nav id="nav">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="servicios.php">Servicios</a></li>
      <li><a href="carrito/index.php">Carrito</a></li>
      <li><a href="pedidos/historial.php">Pedidos</a></li>
      <li><a href="logout.php">Cerrar sesión</a></li>
    </ul>
  </nav>
</header>

<section id="main" class="wrapper style1">
  <div class="container" style="max-width: 700px;">
    <header class="major special">
      <h2>Solicitar ayuda</h2>
      <?php if ($nombreServicio !== null): ?>
        <p>Has seleccionado: <strong><?= htmlspecialchars($nombreServicio, ENT_QUOTES, 'UTF-8') ?></strong></p>
      <?php endif; ?>
      <?php if ($error !== null): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>
    </header>

    <?php if ($nombreServicio !== null && $error === null): ?>
      <form method="post" action="formulario_solicitud.php?tipo=<?= urlencode($tipo) ?>" class="alt">
        <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') ?>">
        <p>Confirma la solicitud para que el equipo pueda gestionarla.</p>
        <ul class="actions">
          <li><button type="submit" class="button special">Confirmar solicitud</button></li>
          <li><a href="servicios.php" class="button">Cancelar</a></li>
        </ul>
      </form>
    <?php else: ?>
      <p>El servicio solicitado no existe.</p>
      <a href="servicios.php" class="button">Volver a servicios</a>
    <?php endif; ?>
  </div>
</section>

<?php include_once 'includes/footer.php'; ?>
</body>
</html>
