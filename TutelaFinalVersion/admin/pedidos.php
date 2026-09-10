<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['role'] ?? 'USER') !== 'ADMIN') {
    http_response_code(403);
    exit('Acceso restringido.');
}

$mensaje = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $estado = $_POST['estado'] ?? 'pendiente';
        $permitidos = ['pendiente', 'en_preparacion', 'enviado', 'completado', 'cancelado'];
        if (!in_array($estado, $permitidos, true)) {
            throw new InvalidArgumentException('Estado no válido.');
        }
        $stmt = $conexion->prepare('UPDATE pedidos SET estado = :estado WHERE id = :id');
        $stmt->execute([':estado' => $estado, ':id' => (int) $_POST['pedido_id']]);
        $mensaje = 'Estado del pedido actualizado.';
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$pedidos = $conexion->query(
    'SELECT p.id, p.estado, p.fecha_pedido, u.nombre, u.email
     FROM pedidos p JOIN usuarios u ON u.id_usuario = p.usuario_id
     ORDER BY p.fecha_pedido DESC'
)->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pedidos - Administración</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

<?php include_once __DIR__ . '/nav.php'; ?>

<section id="main" class="wrapper style1">
  <div class="container">
    <h2>Gestión de Pedidos</h2>
    <?php if ($mensaje): ?><p style="color:green"><?= htmlspecialchars($mensaje) ?></p><?php endif; ?>
    <?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pedidos as $pedido): ?>
            <?php $pedidoId = (int) $pedido['id']; ?>
            <tr>
              <td><?= $pedidoId ?></td>
              <td><?= htmlspecialchars($pedido['nombre'] . ' (' . $pedido['email'] . ')') ?></td>
              <td><?= htmlspecialchars($pedido['fecha_pedido']) ?></td>
              <td>
                <form method="post">
                  <input type="hidden" id="pedido-id-<?= $pedidoId ?>" name="pedido_id" value="<?= $pedidoId ?>">
                  <label for="estado-pedido-<?= $pedidoId ?>" class="sr-only">Estado del pedido <?= $pedidoId ?></label>
                  <select id="estado-pedido-<?= $pedidoId ?>" name="estado">
                    <?php foreach (['pendiente','en_preparacion','enviado','completado','cancelado'] as $est): ?>
                      <option value="<?= $est ?>" <?= $pedido['estado'] === $est ? 'selected' : '' ?>><?= htmlspecialchars($est) ?></option>
                    <?php endforeach; ?>
                  </select>
              </td>
              <td><button type="submit">Guardar</button></form></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
</body>
</html>