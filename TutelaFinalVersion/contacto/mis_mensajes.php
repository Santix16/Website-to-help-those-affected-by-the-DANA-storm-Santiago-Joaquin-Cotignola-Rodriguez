<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$usuarioId = (int)($_SESSION['usuario']['id'] ?? $_SESSION['usuario']['id_usuario'] ?? 0);
$emailUsuario = $_SESSION['usuario']['email'] ?? '';

// Guardar respuesta del usuario dentro de un hilo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['padre_id'])) {
    $mensajeResp = trim($_POST['mensaje_respuesta'] ?? '');

    if (!empty($mensajeResp) && !empty($emailUsuario)) {
        $stmtInsert = $conexion->prepare(
            "INSERT INTO contacto (nombre, email, mensaje) 
             VALUES (:nombre, :email, :mensaje)"
        );
        $stmtInsert->execute([
            ':nombre'  => $_SESSION['usuario']['nombre'] ?? 'Usuario',
            ':email'   => $emailUsuario,
            ':mensaje' => $mensajeResp
        ]);
        header("Location: mis_mensajes.php?exito=1");
        exit();
    }
}

// Obtener todos los mensajes asociados al correo del usuario
$stmt = $conexion->prepare(
    "SELECT * FROM contacto 
     WHERE email = :email 
     ORDER BY fecha_envio ASC"
);
$stmt->execute([':email' => $emailUsuario]);
$todosLosMensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Mensajes - Tutela La DANA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/main.css">
  <style>
    .chat-card { background: #fff; border: 1px solid #ddd; padding: 20px; border-radius: 5px; margin-bottom: 25px; }
    .msg-box { padding: 10px 15px; border-radius: 5px; margin: 8px 0; }
    .msg-user { background: #e3f2fd; text-align: right; margin-left: 20%; }
    .msg-admin { background: #d1e7dd; text-align: left; margin-right: 20%; }
  </style>
</head>
<body class="landing">
<?php include_once __DIR__ . '/../includes/header.php'; ?>

<section id="main" class="wrapper style1">
  <div class="container" style="max-width: 800px;">
    <header class="major">
      <h2>Mis Conversaciones</h2>
      <p>Consulta tus mensajes enviados y las respuestas del equipo de atención.</p>
    </header>

    <?php if (isset($_GET['exito'])): ?>
      <p style="color: green;"><strong>Mensaje enviado correctamente.</strong></p>
    <?php endif; ?>

    <?php if (empty($todosLosMensajes)): ?>
      <p>No tienes conversaciones registradas.</p>
      <a href="contacto.php" class="button special">Enviar una consulta</a>
    <?php else: ?>
      <div class="chat-card">
        <h3>Historial de Chat</h3>
        <hr>

        <?php foreach ($todosLosMensajes as $msg): ?>
          <?php $esAdmin = ($msg['nombre'] === 'Soporte Admin'); ?>
          <div class="msg-box <?= $esAdmin ? 'msg-admin' : 'msg-user' ?>">
            <strong><?= $esAdmin ? 'Tutela La DANA (Soporte)' : 'Tú' ?>:</strong>
            <p style="margin: 0;"><?= nl2br(htmlspecialchars($msg['mensaje'], ENT_QUOTES, 'UTF-8')) ?></p>
            <small style="color: #666; font-size: 0.8em;"><?= $msg['fecha_envio'] ?? '' ?></small>
          </div>
        <?php endforeach; ?>

        <!-- Formulario para responder al hilo -->
        <form method="post" action="mis_mensajes.php" style="margin-top: 15px;">
          <input type="hidden" name="padre_id" value="1">
          <textarea name="mensaje_respuesta" placeholder="Escribe tu respuesta..." rows="2" required></textarea>
          <button type="submit" class="button small special" style="margin-top: 10px;">Enviar mensaje</button>
        </form>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>