<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

// Obtener el ID del usuario actual
$id_usuario = $_SESSION['usuario']['id'] ?? $_SESSION['usuario']['id_usuario'];

try {
    // Obtener los pedidos del usuario
    $stmt = $conexion->prepare("SELECT * FROM pedidos WHERE usuario_id = :id_usuario ORDER BY fecha_pedido DESC");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener pedidos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historial de Pedidos</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<!-- Contenido -->
<section class="wrapper style1">
  <div class="container" style="padding: 2em;">
      <h1>Historial de Pedidos</h1>

      <!-- Enlace para añadir nuevo pedido -->
      <p><a href="../servicios.php" class="button">Añadir un nuevo pedido</a></p>

      <?php if (count($pedidos) > 0): ?>
          <div class="table-wrapper">
              <table class="orders-history">
                  <thead>
                      <tr>
                          <th>ID Pedido</th>
                          <th>Fecha</th>
                          <th>Estado</th>
                          <th>Acciones</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($pedidos as $pedido): ?>
                          <tr>
                              <td><?php echo (int)$pedido['id']; ?></td>
                              <td><?php echo htmlspecialchars($pedido['fecha_pedido'], ENT_QUOTES, 'UTF-8'); ?></td>
                              <td><?php echo htmlspecialchars($pedido['estado'], ENT_QUOTES, 'UTF-8'); ?></td>
                              <td><a href="pedido.php?id=<?php echo (int)$pedido['id']; ?>" class="button small">Ver Detalles</a></td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
      <?php else: ?>
          <p>No tienes pedidos registrados.</p>
      <?php endif; ?>
  </div>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>