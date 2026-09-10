<?php
// enviar_pedido.php
session_start();
include_once __DIR__ . '/../includes/db.php';

// Verificar que se haya recibido el ID del pedido mediante GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "No se especificó el ID del pedido.";
    exit();
}

$order_id = intval($_GET['id']);

// Consulta para obtener los detalles del pedido y los datos del usuario que lo realizó
$stmt = $conexion->prepare("
    SELECT p.*, u.email, u.nombre
    FROM pedidos p
    JOIN usuarios u ON p.usuario_id = u.id
    WHERE p.id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Pedido no encontrado.";
    exit();
}

$order = $result->fetch_assoc();

// Construir el contenido del email
$to = $order['email'];
$subject = "Confirmación de Pedido - TELE-DANA";
$message = "Estimado " . htmlspecialchars($order['nombre']) . ",\n\n";
$message .= "Gracias por tu pedido en TELE-DANA.\n";
$message .= "Aquí tienes los detalles de tu pedido:\n";
$message .= "-------------------------------------------------\n";
$message .= "ID Pedido: " . $order['id'] . "\n";
$message .= "Fecha: " . ($order['fecha'] ?? $order['fecha_pedido'] ?? '') . "\n";
$message .= "Estado: " . $order['estado'] . "\n";
$message .= "-------------------------------------------------\n\n";
$message .= "Te agradecemos por confiar en nosotros. Pronto recibirás más información sobre el envío.\n\n";
$message .= "Saludos cordiales,\n";
$message .= "El equipo de TELE-DANA";

// Definir las cabeceras del email
$headers = "From: no-reply@tele-dana.com\r\n";
$headers .= "Reply-To: soporte@tele-dana.com\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Enviar el email
if (mail($to, $subject, $message, $headers)) {
    echo "<div class='message'>Email de confirmación enviado correctamente a " . htmlspecialchars($to) . "</div>";
} else {
    echo "<div class='error'>Error al enviar el email de confirmación.</div>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Pedido - TELE-DANA</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<!-- Contenido -->
<div class="container">
    <h2>Confirmación de Pedido</h2>
    <p>El pedido ha sido procesado y un correo de confirmación ha sido enviado.</p>
    <p><a href="enviar_mensaje.php" class="btn">Enviar Mensaje</a></p>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>