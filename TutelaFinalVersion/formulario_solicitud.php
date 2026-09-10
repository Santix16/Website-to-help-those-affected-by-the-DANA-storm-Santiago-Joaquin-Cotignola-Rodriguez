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

// Mapeo directo entre la clave 'tipo' de la URL y el nombre exacto guardado en la tabla 'productos'
$mapaProductosBD = [
    'comida_preparada' => 'COMIDA PREPARADA (LISTO PARA CALENTAR)',
    'conservas'        => 'LATAS DE CONSERVA (ATÚN, LEGUMBRES, SOPA)',
    'pan_galletas'     => 'PAN Y GALLETAS SECAS',
    'leche'            => 'LECHE EN POLVO O UHT',
    'agua'             => 'AGUA POTABLE EMBOTELLADA (1L O 5L)',
    'frutas'           => 'FRUTAS NO PERECEDERAS',
    'arroz_pasta'      => 'PAQUETES DE ARROZ Y PASTA',
    'jabon'            => 'JABÓN Y CHAMPÚ',
    'papel'            => 'PAPEL HIGIÉNICO',
    'detergente'       => 'DETERGENTE Y LIMPIADORES',
    'ropa_mujer'       => 'ROPA PARA MUJER',
    'ropa_hombre'      => 'ROPA PARA HOMBRE',
    'ropa_nino'        => 'ROPA PARA NIÑOS',
    'calzado'          => 'CALZADO Y MANTAS'
];

$tipo = $_GET['tipo'] ?? $_POST['tipo'] ?? '';

// Lógica de detección de página de origen
$origen = $_GET['origen'] ?? $_POST['origen'] ?? '';

if (empty($origen) && isset($_SERVER['HTTP_REFERER'])) {
    $refererPath = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
    $origen = basename($refererPath);
}

// Validar que el origen pertenezca a las páginas permitidas
$paginasPermitidas = ['servicios_alimentos.php', 'servicios_limpieza.php', 'servicios_ropa.php', 'servicios.php'];
if (!in_array($origen, $paginasPermitidas, true)) {
    $origen = 'servicios.php';
}

$nombreServicio = $servicios[$tipo] ?? null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($nombreServicio === null) {
        $error = 'El servicio seleccionado no es válido.';
    } else {
        require_once __DIR__ . '/includes/db.php';

        try {
            $usuarioId = (int) ($_SESSION['usuario']['id'] ?? $_SESSION['usuario']['id_usuario'] ?? 0);
            if ($usuarioId <= 0) {
                throw new InvalidArgumentException('La sesión de usuario no es válida.');
            }

            // Obtenemos el nombre exacto registrado en la base de datos
            $nombreBD = $mapaProductosBD[$tipo] ?? $nombreServicio;

            // Consultar el producto_id real para mantener la integridad referencial
            $stmtProd = $conexion->prepare('SELECT id, nombre FROM productos WHERE nombre = :nombre LIMIT 1');
            $stmtProd->execute([':nombre' => $nombreBD]);
            $productoBD = $stmtProd->fetch(PDO::FETCH_ASSOC);

            $productoId = $productoBD ? (int)$productoBD['id'] : null;
            $nombreFinalProducto = $productoBD ? $productoBD['nombre'] : $nombreBD;

            // Inserción asignando las columnas 'producto', 'producto_id' y manteniendo el 'estado' limpio
            $stmt = $conexion->prepare(
                'INSERT INTO pedidos (usuario_id, producto, producto_id, estado) VALUES (:usuario_id, :producto, :producto_id, :estado)'
            );
            $stmt->execute([
                ':usuario_id'  => $usuarioId,
                ':producto'     => $nombreFinalProducto,
                ':producto_id'  => $productoId,
                ':estado'       => 'pendiente'
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
<?php include_once 'includes/header.php'; ?>

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
      <form method="post" action="formulario_solicitud.php?tipo=<?= urlencode($tipo) ?>&origen=<?= urlencode($origen) ?>" class="alt">
        <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="origen" value="<?= htmlspecialchars($origen, ENT_QUOTES, 'UTF-8') ?>">
        <p>Confirma la solicitud para que el equipo pueda gestionarla.</p>
        <ul class="actions">
          <li><button type="submit" class="button special">Confirmar solicitud</button></li>
          <li><a href="<?= htmlspecialchars($origen, ENT_QUOTES, 'UTF-8') ?>" class="button">Cancelar</a></li>
        </ul>
      </form>
    <?php else: ?>
      <p>El servicio solicitado no existe.</p>
      <a href="<?= htmlspecialchars($origen, ENT_QUOTES, 'UTF-8') ?>" class="button">Volver</a>
    <?php endif; ?>
  </div>
</section>

<?php include_once 'includes/footer.php'; ?>
</body>
</html>