<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['role'] ?? 'USER') !== 'ADMIN') {
    http_response_code(403);
    exit('Acceso restringido.');
}

define('ESTADO_PENDIENTE_RECOGIDA', 'Pendiente de Recogida');

$mensaje = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $estado = $_POST['estado'] ?? ESTADO_PENDIENTE_RECOGIDA;
        $permitidos = [ESTADO_PENDIENTE_RECOGIDA, 'En Camino', 'Recogido', 'Cancelado'];
        if (!in_array($estado, $permitidos, true)) {
            throw new InvalidArgumentException('Estado no válido.');
        }
        $stmt = $conexion->prepare('UPDATE donaciones SET estado = :estado WHERE id_donacion = :id');
        $stmt->execute([':estado' => $estado, ':id' => (int) $_POST['donacion_id']]);
        $mensaje = 'Estado de la donación actualizado.';
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$donaciones = $conexion->query(
    'SELECT d.*, u.nombre AS usuario_nombre, u.email AS usuario_email, p.nombre AS producto_nombre
     FROM donaciones d
     JOIN usuarios u ON d.id_usuario = u.id_usuario
     JOIN productos p ON d.producto_id = p.id
     ORDER BY d.fecha_donacion DESC'
)->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Donaciones - Administración</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

<?php include_once __DIR__ . '/nav.php'; ?>

<section id="main" class="wrapper style1">
  <div class="container">
    <h2>Gestión de Donaciones</h2>
    <?php if ($mensaje): ?><p style="color:green"><?= htmlspecialchars($mensaje) ?></p><?php endif; ?>
    <?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Donante</th>
            <th>Producto</th>
            <th>Cant.</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Estado</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($donaciones)): ?>
            <tr><td colspan="8">No hay donaciones registradas.</td></tr>
          <?php else: ?>
            <?php foreach ($donaciones as $donacion): ?>
              <?php $donacionId = (int) $donacion['id_donacion']; ?>
              <tr>
                <td><?= $donacionId ?></td>
                <td><?= htmlspecialchars($donacion['usuario_nombre']) ?><br><small>(<?= htmlspecialchars($donacion['usuario_email']) ?>)</small></td>
                <td><?= htmlspecialchars($donacion['producto_nombre']) ?></td>
                <td><?= (int) $donacion['cantidad'] ?></td>
                <td><?= htmlspecialchars($donacion['direccion_recogida']) ?></td>
                <td><?= htmlspecialchars($donacion['telefono_contacto']) ?></td>
                <td>
                  <form method="post">
                    <input type="hidden" id="donacion-id-<?= $donacionId ?>" name="donacion_id" value="<?= $donacionId ?>">
                    <label for="estado-donacion-<?= $donacionId ?>" class="sr-only">Estado de donación <?= $donacionId ?></label>
                    <select id="estado-donacion-<?= $donacionId ?>" name="estado">
                      <?php foreach ([ESTADO_PENDIENTE_RECOGIDA, 'En Camino', 'Recogido', 'Cancelado'] as $est): ?>
                        <option value="<?= $est ?>" <?= ($donacion['estado'] ?? '') === $est ? 'selected' : '' ?>><?= htmlspecialchars($est) ?></option>
                      <?php endforeach; ?>
                    </select>
                </td>
                <td><button type="submit">Guardar</button></form></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
</body>
</html>