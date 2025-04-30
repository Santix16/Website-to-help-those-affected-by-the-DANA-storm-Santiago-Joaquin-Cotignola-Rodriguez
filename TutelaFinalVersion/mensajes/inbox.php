<?php
session_start();

// Verificar que el usuario esté autenticado (ej. como administrador)
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once '../includes/db.php';

// Obtener todos los mensajes enviados desde el formulario de contacto
$query = "SELECT * FROM mensajes ORDER BY fecha_envio DESC";
$stmt = $conexion->prepare($query);
$stmt->execute();
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bandeja de Entrada</title>
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
      <li><a href="inbox.php">Mensaje</a></li>
      <li><a href="../pedidos/historial.php">Pedidos</a></li>
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
    <h1>Bandeja de Entrada</h1>

    <?php if (count($mensajes) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mensajes as $row): ?>
                    <tr>
                        <td><?php echo $row['id_mensaje']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['mensaje'])); ?></td>
                        <td><?php echo $row['fecha_envio']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay mensajes por mostrar.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
