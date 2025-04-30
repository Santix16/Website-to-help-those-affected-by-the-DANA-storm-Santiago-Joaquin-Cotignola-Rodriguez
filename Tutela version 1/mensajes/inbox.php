<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once '../includes/db.php';         // Conexión a la base de datos
include_once '../includes/functions.php';  // Funciones reutilizables
include '../includes/header.php';          // Cabecera común

// Obtener el ID del usuario logueado
$user_id = $_SESSION['usuario']['id'];

// Consulta para obtener los mensajes dirigidos al usuario
$query = "SELECT m.id, m.mensaje, m.fecha, u.nombre AS remitente 
          FROM mensajes m
          JOIN usuarios u ON m.remitente_id = u.id
          WHERE m.destinatario_id = ? 
          ORDER BY m.fecha DESC";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandeja de Entrada</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Asegúrate de que la ruta del CSS sea correcta -->
</head>
<body>

<div class="container">
    <h1>Bandeja de Entrada</h1>
    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Remitente</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['remitente']); ?></td>
                        <td><?php echo htmlspecialchars($row['mensaje']); ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td>
                            <a href="ver_mensaje.php?id=<?php echo $row['id']; ?>" class="btn">Ver</a>
                            <a href="eliminar_mensaje.php?id=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('¿Estás seguro de eliminar este mensaje?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes mensajes en tu bandeja de entrada.</p>
    <?php endif; ?>
    <p><a href="enviar.php" class="btn">Enviar Nuevo Mensaje</a></p>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>
