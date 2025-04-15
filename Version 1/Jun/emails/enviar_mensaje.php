<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/functions.php';

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión para enviar mensajes.";
    exit();
}

// Verificar que se haya recibido el ID del mensaje
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "No se especificó el ID del mensaje.";
    exit();
}

$mensaje_id = intval($_GET['id']);

// Consulta para obtener el mensaje y los datos del remitente y destinatario
$stmt = $conexion->prepare("
    SELECT m.mensaje, u_dest.email AS email_destinatario, u_dest.nombre AS nombre_destinatario, 
           u_rem.nombre AS nombre_remitente, u_rem.email AS email_remitente
    FROM mensajes m
    JOIN usuarios u_dest ON m.destinatario_id = u_dest.id
    JOIN usuarios u_rem ON m.remitente_id = u_rem.id
    WHERE m.id = ?
");
$stmt->bind_param("i", $mensaje_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Mensaje no encontrado.";
    exit();
}

$mensaje = $result->fetch_assoc();

// Construcción del correo
$to = $mensaje['email_destinatario'];
$subject = "Nuevo mensaje de " . $mensaje['nombre_remitente'];
$message = "Hola " . htmlspecialchars($mensaje['nombre_destinatario']) . ",\n\n";
$message .= "Has recibido un nuevo mensaje de " . htmlspecialchars($mensaje['nombre_remitente']) . ":\n\n";
$message .= "-------------------------------------------------\n";
$message .= htmlspecialchars($mensaje['mensaje']) . "\n";
$message .= "-------------------------------------------------\n\n";
$message .= "Puedes responder iniciando sesión en TELE-DANA.\n\n";
$message .= "Saludos,\n";
$message .= "El equipo de TELE-DANA";

// Configuración del encabezado del email
$headers = "From: no-reply@tele-dana.com\r\n";
$headers .= "Reply-To: " . $mensaje['email_remitente'] . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Enviar el email
if (mail($to, $subject, $message, $headers)) {
    echo "<div class='message'>Mensaje enviado correctamente a " . htmlspecialchars($to) . "</div>";
} else {
    echo "<div class='error'>Error al enviar el mensaje.</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enviar Mensaje - TELE-DANA</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Vinculación con el archivo CSS -->
</head>
<body>

<?php include '../includes/header.php'; ?> <!-- Incluir header.php -->

<!-- Aquí puedes agregar contenido relevante, si es necesario -->
<div class="container">
    <h2>Mensaje Enviado</h2>
    <p>El mensaje ha sido enviado correctamente al destinatario.</p>
    
    <!-- Enlace para ir a enviar_pedido.php -->
    <p><a href="enviar_pedido.php" class="btn">Ir a Enviar Pedido</a></p>

    <p><a href="productos.php" class="btn">Volver a la Tienda</a></p>
</div>

<?php include '../includes/footer.php'; ?> <!-- Incluir footer.php -->

</body>
</html>


