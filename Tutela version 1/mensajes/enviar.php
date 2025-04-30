<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once '../includes/db.php';
include_once '../includes/functions.php';
include '../includes/header.php';

// Procesar el formulario al enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar datos
    $destinatario_id = intval($_POST['destinatario_id']);
    $mensaje = limpiarInput($_POST['mensaje']);

    if (empty($mensaje)) {
        setFlashMessage("El mensaje no puede estar vacío.", "error");
    } else {
        $remitente_id = $_SESSION['usuario']['id'];
        $stmt = $conexion->prepare("INSERT INTO mensajes (remitente_id, destinatario_id, mensaje) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $remitente_id, $destinatario_id, $mensaje);

        if ($stmt->execute()) {
            setFlashMessage("Mensaje enviado exitosamente.");
            redirigir("inbox.php");
        } else {
            setFlashMessage("Error al enviar el mensaje.", "error");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensaje</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Asegúrate de que la ruta del CSS sea correcta -->
</head>
<body>

<div class="container">
    <h1>Enviar Nuevo Mensaje</h1>
    <?php
      // Mostrar mensaje flash (si existe)
      $flash = getFlashMessage();
      if ($flash) {
         echo "<div class='flash " . $flash['tipo'] . "'>" . $flash['mensaje'] . "</div>";
      }
    ?>
    <form action="enviar.php" method="POST">
        <label for="destinatario_id">Destinatario:</label>
        <select name="destinatario_id" id="destinatario_id" required>
            <option value="">Seleccione un destinatario</option>
            <?php
            // Listar todos los usuarios, excluyendo el usuario actual
            $current_id = $_SESSION['usuario']['id'];
            $query = "SELECT id, nombre FROM usuarios WHERE id != ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i", $current_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($user = $result->fetch_assoc()) {
                echo '<option value="' . $user['id'] . '">' . htmlspecialchars($user['nombre']) . '</option>';
            }
            ?>
        </select>
        
        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" rows="5" required></textarea>
        
        <button type="submit" class="btn">Enviar Mensaje</button>
    </form>
    <p><a href="inbox.php" class="btn">Volver a la Bandeja de Entrada</a></p>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>

