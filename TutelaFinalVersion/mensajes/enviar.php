<?php
session_start();

// Función para guardar el mensaje flash en la sesión
function setFlashMessage($mensaje, $tipo = 'success') {
    $_SESSION['flash_message'] = [
        'mensaje' => $mensaje,
        'tipo' => $tipo
    ];
}

// Función para obtener y eliminar el mensaje flash de la sesión
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']); // Eliminar el mensaje después de mostrarlo
        return $flash;
    }
    return null;
}

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once '../includes/db.php';
include '../includes/header.php';

// Procesar el formulario al enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar datos
    $destinatario = trim($_POST['destinatario']);
    $mensaje = trim($_POST['mensaje']);

    // Validación
    if (empty($destinatario) || empty($mensaje)) {
        setFlashMessage("El destinatario y el mensaje no pueden estar vacíos.", "error");
    } else {
        $remitente_id = $_SESSION['usuario']['id'];

        // Buscar el ID del destinatario por su nombre
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $destinatario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si se encuentra el destinatario
            $destinatario_id = $result->fetch_assoc()['id'];

            // Insertar mensaje
            $stmt = $conexion->prepare("INSERT INTO mensajes (remitente_id, destinatario_id, mensaje) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $remitente_id, $destinatario_id, $mensaje);

            if ($stmt->execute()) {
                setFlashMessage("Mensaje enviado exitosamente.");
                header("Location: inbox.php");
                exit(); // Redirigir a la bandeja de entrada
            } else {
                setFlashMessage("Error al enviar el mensaje.", "error");
            }
        } else {
            setFlashMessage("Destinatario no encontrado.", "error");
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
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container" style="margin-top: 100px;"> <!-- Aumentar el margen superior para evitar solapamiento con el header -->
    <h1>Enviar Nuevo Mensaje</h1>

    <?php
      // Mostrar mensaje flash (si existe)
      $flash = getFlashMessage();
      if ($flash) {
         echo "<div class='flash " . $flash['tipo'] . "'>" . $flash['mensaje'] . "</div>";
      }
    ?>

    <form action="enviar.php" method="POST">
        <label for="destinatario">Destinatario (nombre del usuario):</label>
        <input type="text" name="destinatario" id="destinatario" required placeholder="Escribe el nombre del destinatario">
        
        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" rows="5" required placeholder="Escribe tu mensaje aquí"></textarea>
        
        <button type="submit" class="btn">Enviar Mensaje</button>
    </form>

    <p><a href="inbox.php" class="btn">Volver a la Bandeja de Entrada</a></p>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>

