<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once __DIR__ . '/../includes/db.php';

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
<body class="landing">

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<!-- Contenido -->
<section class="wrapper style1">
    <div class="container" style="padding: 2em;">
        <h1>Bandeja de Entrada</h1>

        <!-- Enlace para enviar un nuevo mensaje -->
        <p><a href="enviar.php" class="button">Enviar Nuevo Mensaje</a></p>

        <?php if (count($mensajes) > 0): ?>
            <div class="table-wrapper">
                <table>
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
                                <td><?php echo (int) $row['id_mensaje']; ?></td>
                                <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($row['mensaje'], ENT_QUOTES, 'UTF-8')); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha_envio'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No hay mensajes por mostrar.</p>
        <?php endif; ?>
    </div>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>