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
        $stock = filter_var($_POST['stock'] ?? null, FILTER_VALIDATE_INT);
        if ($stock === false || $stock < 0) {
            throw new InvalidArgumentException('El stock debe ser un número mayor o igual a cero.');
        }
        $stmt = $conexion->prepare('UPDATE productos SET stock = :stock WHERE id = :id');
        $stmt->execute([':stock' => $stock, ':id' => (int) $_POST['producto_id']]);
        $mensaje = 'Stock actualizado.';
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$productos = $conexion->query('SELECT id, nombre, stock FROM productos ORDER BY nombre')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Stock - Administración</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

<?php include_once __DIR__ . '/nav.php'; ?>

<section id="main" class="wrapper style1">
  <div class="container">
    <h2>Control de Stock de Productos</h2>
    <?php if ($mensaje): ?><p style="color:green"><?= htmlspecialchars($mensaje) ?></p><?php endif; ?>
    <?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad en Stock</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos as $producto): ?>
            <?php $productoId = (int) $producto['id']; ?>
            <tr>
              <td><?= htmlspecialchars($producto['nombre']) ?></td>
              <td>
                <form method="post">
                  <input type="hidden" id="producto-id-<?= $productoId ?>" name="producto_id" value="<?= $productoId ?>">
                  <label for="stock-producto-<?= $productoId ?>" class="sr-only">Cantidad en stock para <?= htmlspecialchars($producto['nombre']) ?></label>
                  <input type="number" id="stock-producto-<?= $productoId ?>" min="0" name="stock" value="<?= (int) $producto['stock'] ?>" required>
              </td>
              <td><button type="submit">Actualizar</button></form></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
</body>
</html>