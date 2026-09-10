<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['role'] ?? 'USER') !== 'ADMIN') {
    http_response_code(403);
    exit('Acceso restringido. Necesitas cuenta de administrador.');
}

require_once __DIR__ . '/../includes/db.php';

// El Administrador responde a un mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['padre_id'])) {
    $padreId = (int)$_POST['padre_id'];
    $respuesta = trim($_POST['respuesta'] ?? '');

    if ($padreId > 0 && !empty($respuesta)) {
        $stmtPadre = $conexion->prepare("SELECT nombre, email FROM contacto WHERE id = :id");
        $stmtPadre->execute([':id' => $padreId]);
        $padre = $stmtPadre->fetch(PDO::FETCH_ASSOC);

        if ($padre) {
            $stmt = $conexion->prepare(
                "INSERT INTO contacto (nombre, email, mensaje) 
                 VALUES (:nombre, :email, :mensaje)"
            );
            $stmt->execute([
                ':nombre'  => 'Soporte Admin',
                ':email'   => $padre['email'],
                ':mensaje' => $respuesta
            ]);
            header("Location: mensajes.php?exito=1");
            exit();
        }
    }
}

// Obtener correos únicos de usuarios para agrupar los hilos
$stmtCorreos = $conexion->query("SELECT DISTINCT email FROM contacto WHERE email != '' ORDER BY id DESC");
$correos = $stmtCorreos->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gestión de Mensajes - Admin</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <style>
    .admin-thread { background: #fff; border: 1px solid #ccc; margin-bottom: 15px; border-radius: 6px; overflow: hidden; }
    
    /* Cabecera desplegable tipo WhatsApp */
    .chat-header {
      background: #f8f9fa;
      padding: 15px 20px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      user-select: none;
      transition: background 0.2s ease;
    }
    .chat-header:hover { background: #e9ecef; }
    .chat-header h3 { margin: 0; font-size: 1.1em; color: #333; }
    .chat-header .toggle-icon { font-weight: bold; font-size: 1.2em; color: #666; transition: transform 0.2s ease; }

    /* Cuerpo del chat (oculto por defecto) */
    .chat-body {
      display: none;
      padding: 20px;
      border-top: 1px solid #eee;
      background: #fafafa;
    }

    .msg-box { padding: 10px 15px; border-radius: 6px; margin: 8px 0; max-width: 80%; }
    .msg-user { background: #e3f2fd; text-align: left; margin-right: auto; }
    .msg-admin { background: #d1e7dd; text-align: right; margin-left: auto; }
  </style>
</head>
<body class="landing">

<?php include_once __DIR__ . '/nav.php'; ?>

<section id="main" class="wrapper style1">
  <div class="container" style="max-width: 900px;">
    <header class="major">
      <h2>Gestión de Mensajes de Usuarios</h2>
    </header>

    <p><a href="index.php" class="button alt small">← Volver al Panel</a></p>

    <?php if (isset($_GET['exito'])): ?>
      <p style="color: green;"><strong>Respuesta enviada correctamente.</strong></p>
    <?php endif; ?>

    <?php if (empty($correos)): ?>
      <p>No hay mensajes recibidos.</p>
    <?php else: ?>
      <?php foreach ($correos as $email): ?>
        <?php
          // Obtener todo el historial de conversación con este email
          $stmtChat = $conexion->prepare("SELECT * FROM contacto WHERE email = :email ORDER BY fecha_envio ASC");
          $stmtChat->execute([':email' => $email]);
          $historial = $stmtChat->fetchAll(PDO::FETCH_ASSOC);

          // Obtener datos del usuario
          $ultimoMsgUser = null;
          foreach (array_reverse($historial) as $h) {
              if ($h['nombre'] !== 'Soporte Admin') {
                  $ultimoMsgUser = $h;
                  break;
              }
          }
          if (!$ultimoMsgUser) continue;
        ?>

        <div class="admin-thread">
          <!-- Cabecera interactiva -->
          <div class="chat-header" onclick="toggleChat(this)">
            <h3>👤 <?= htmlspecialchars($ultimoMsgUser['nombre'], ENT_QUOTES, 'UTF-8') ?> <span style="font-weight: normal; font-size: 0.9em; color: #666;">(<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>)</span></h3>
            <span class="toggle-icon">▼</span>
          </div>

          <!-- Contenido de la conversación -->
          <div class="chat-body">
            <?php foreach ($historial as $msg): ?>
              <?php $esAdmin = ($msg['nombre'] === 'Soporte Admin'); ?>
              <div class="msg-box <?= $esAdmin ? 'msg-admin' : 'msg-user' ?>">
                <strong><?= $esAdmin ? 'Tutela La DANA (Soporte)' : htmlspecialchars($msg['nombre'], ENT_QUOTES, 'UTF-8') ?>:</strong>
                <p style="margin: 0;"><?= nl2br(htmlspecialchars($msg['mensaje'], ENT_QUOTES, 'UTF-8')) ?></p>
                <small style="color: #666; font-size: 0.8em;"><?= $msg['fecha_envio'] ?? '' ?></small>
              </div>
            <?php endforeach; ?>

            <form method="post" action="mensajes.php" style="margin-top: 15px;">
              <input type="hidden" name="padre_id" value="<?= $ultimoMsgUser['id'] ?>">
              <textarea name="respuesta" placeholder="Escribir respuesta oficial..." rows="2" required></textarea>
              <button type="submit" class="button special small" style="margin-top: 10px;">Enviar Respuesta</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<script>
function toggleChat(header) {
  const body = header.nextElementSibling;
  const icon = header.querySelector('.toggle-icon');

  if (body.style.display === "block") {
    body.style.display = "none";
    icon.textContent = "▼";
  } else {
    body.style.display = "block";
    icon.textContent = "▲";
  }
}
</script>

</body>
</html>