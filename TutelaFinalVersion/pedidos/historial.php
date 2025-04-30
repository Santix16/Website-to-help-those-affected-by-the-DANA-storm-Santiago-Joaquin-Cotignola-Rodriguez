<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include("../includes/db.php");

// Obtener el ID del usuario actual
$id_usuario = $_SESSION['usuario']['id'];

try {
    // Obtener los pedidos del usuario
    $stmt = $conexion->prepare("SELECT * FROM pedidos WHERE id_cliente = :id_usuario ORDER BY fecha_pedido DESC");
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
<body>

<!-- Header -->
<header id="header" class="alt">
  <h1><strong><a href="../index.php">Tutela La DANA</a></strong></h1>
  <nav id="nav">
    <ul>
      <li><a href="../index.php">Inicio</a></li>
      <li><a href="../servicios.php">Servicios</a></li>
      <li><a href="../quienes_somos.php">Quiénes Somos</a></li>
      <li><a href="../contacto/contacto.php">Contacto</a></li>
      <li><a href="../carrito/index.php">Carrito</a></li>
      <li><a href="../users/perfil.php">Usuario</a></li>
      <li><a href="../mensajes/inbox.php">Mensaje</a></li>
      <li><a href="historial.php">Pedidos</a></li>
      <?php if (isset($_SESSION['usuario'])): ?>
        <li><a href="../logout.php">Cerrar sesión</a></li>
      <?php else: ?>
        <li><a href="../login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<!-- Contenido -->
<div class="container" style="padding: 2em;">
    <h1>Historial de Pedidos</h1>

    <?php if (count($pedidos) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha</th>
                    <th>Total Tónkens</th>
                    <th>Estado</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo $pedido['id_pedido']; ?></td>
                        <td><?php echo $pedido['fecha_pedido']; ?></td>
                        <td><?php echo $pedido['total_tonkens']; ?></td>
                        <td><?php echo $pedido['estado']; ?></td>
                        <td><a href="pedido.php?id=<?php echo $pedido['id_pedido']; ?>">Ver Detalles</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes pedidos registrados.</p>
    <?php endif; ?>
</div>

<?php include("../includes/footer.php"); ?>
</body>
</html>
