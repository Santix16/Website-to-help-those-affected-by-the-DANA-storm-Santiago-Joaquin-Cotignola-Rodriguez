<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['role'] ?? 'USER') !== 'ADMIN') {
    http_response_code(403);
    exit('Acceso restringido. Necesitas una cuenta de administrador.');
}

$mensaje = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    try {
        if ($accion === 'estado') {
            $estado = $_POST['estado'] ?? 'pendiente';
            $permitidos = ['pendiente', 'en_preparacion', 'enviado', 'completado', 'cancelado'];
            if (!in_array($estado, $permitidos, true)) {
                throw new InvalidArgumentException('Estado no valido.');
            }
            $stmt = $conexion->prepare('UPDATE pedidos SET estado = :estado WHERE id = :id');
            $stmt->execute([':estado' => $estado, ':id' => (int) $_POST['pedido_id']]);
            $mensaje = 'Estado del pedido actualizado.';
        } elseif ($accion === 'stock') {
            $stock = filter_var($_POST['stock'] ?? null, FILTER_VALIDATE_INT);
            if ($stock === false || $stock < 0) {
                throw new InvalidArgumentException('El stock debe ser un numero igual o mayor que cero.');
            }
            $stmt = $conexion->prepare('UPDATE productos SET stock = :stock WHERE id = :id');
            $stmt->execute([':stock' => $stock, ':id' => (int) $_POST['producto_id']]);
            $mensaje = 'Stock actualizado.';
        }
    } catch (Throwable $exception) {
        $error = $exception->getMessage();
    }
}

$pedidos = $conexion->query(
    'SELECT p.id, p.estado, p.total_tonkens, p.fecha_pedido, u.nombre, u.email
     FROM pedidos p JOIN usuarios u ON u.id_usuario = p.usuario_id
     ORDER BY p.fecha_pedido DESC'
)->fetchAll(PDO::FETCH_ASSOC);
$productos = $conexion->query('SELECT id, nombre, precio_tonkens, stock FROM productos ORDER BY nombre')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administracion - Tutela La DANA</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">
<header id="header" class="alt"><h1><a href="../index.php">Tutela La DANA</a></h1><nav id="nav"><ul><li><a href="../index.php">Inicio</a></li><li><a href="logout.php">Cerrar sesion</a></li></ul></nav></header>
<section id="main" class="wrapper style1"><div class="container">
  <header class="major"><h2>Panel de administracion</h2><p>Gestiona solicitudes, estados y disponibilidad de ayuda.</p></header>
  <?php if ($mensaje): ?><p style="color:green"><?= htmlspecialchars($mensaje) ?></p><?php endif; ?>
  <?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  <h3>Pedidos</h3>
  <div class="table-wrapper"><table><thead><tr><th>ID</th><th>Usuario</th><th>Total</th><th>Fecha</th><th>Estado</th><th>Guardar</th></tr></thead><tbody>
    <?php foreach ($pedidos as $pedido): ?><tr><td><?= (int) $pedido['id'] ?></td><td><?= htmlspecialchars($pedido['nombre'] . ' (' . $pedido['email'] . ')') ?></td><td><?= (int) $pedido['total_tonkens'] ?></td><td><?= htmlspecialchars($pedido['fecha_pedido']) ?></td><td><form method="post"><input type="hidden" name="accion" value="estado"><input type="hidden" name="pedido_id" value="<?= (int) $pedido['id'] ?>"><label for="estado-<?= (int) $pedido['id'] ?>">Estado del pedido <?= (int) $pedido['id'] ?></label><select id="estado-<?= (int) $pedido['id'] ?>" name="estado"><?php foreach (['pendiente','en_preparacion','enviado','completado','cancelado'] as $estado): ?><option value="<?= $estado ?>" <?= $pedido['estado'] === $estado ? 'selected' : '' ?>><?= htmlspecialchars($estado) ?></option><?php endforeach; ?></select></td><td><button type="submit">Guardar</button></form></td></tr><?php endforeach; ?>
  </tbody></table></div>
  <h3>Stock</h3><div class="table-wrapper"><table><thead><tr><th>Producto</th><th>Precio</th><th>Stock</th><th>Guardar</th></tr></thead><tbody>
    <?php foreach ($productos as $producto): ?><tr><td><?= htmlspecialchars($producto['nombre']) ?></td><td><?= (int) $producto['precio_tonkens'] ?></td><td><form method="post"><input type="hidden" name="accion" value="stock"><input type="hidden" name="producto_id" value="<?= (int) $producto['id'] ?>"><label for="stock-<?= (int) $producto['id'] ?>">Unidades disponibles de <?= htmlspecialchars($producto['nombre']) ?></label><input id="stock-<?= (int) $producto['id'] ?>" type="number" min="0" name="stock" value="<?= (int) $producto['stock'] ?>" required></td><td><button type="submit">Actualizar</button></form></td></tr><?php endforeach; ?>
  </tbody></table></div>
</div></section>
</body></html>
