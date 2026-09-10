<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';

$mensaje_exito = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $mensaje = trim($_POST["message"] ?? '');

    if (!empty($nombre) && !empty($email) && !empty($mensaje)) {
        try {
            $stmt = $conexion->prepare(
                "INSERT INTO contacto (nombre, email, mensaje) 
                 VALUES (:nombre, :email, :mensaje)"
            );
            $stmt->execute([
                ':nombre'  => $nombre,
                ':email'   => $email,
                ':mensaje' => $mensaje
            ]);
            $mensaje_exito = "Gracias, <strong>" . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') . "</strong>. Hemos recibido tu mensaje.";
        } catch (Throwable $e) {
            $error = "No se pudo enviar el mensaje. Inténtalo de nuevo más tarde.";
        }
    } else {
        $error = "Por favor, rellena todos los campos.";
    }
}
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <title>Contacto - Tutela La DANA</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Ruta adaptada al CSS global desde la subcarpeta -->
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body class="landing">

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<section id="banner">
    <h2>Contacto</h2>
    <p>¿Tienes alguna duda o comentario? ¡Escríbenos!</p>
</section>

<section id="one" class="wrapper style1">
    <div class="container 75%">
        <?php if (isset($_SESSION['usuario'])): ?>
            <p><a href="../contacto/mis_mensajes.php" class="button special small">Ver mis conversaciones</a></p>
        <?php endif; ?>

        <form method="post" action="">
            <div class="row uniform 50%">
                <div class="6u 12u$(xsmall)">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required />
                </div>
                <div class="6u$ 12u$(xsmall)">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_SESSION['usuario']['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required />
                </div>
                <div class="12u$">
                    <label for="message">Mensaje</label>
                    <textarea name="message" id="message" placeholder="Escribe tu consulta..." rows="6" required></textarea>
                </div>
                <div class="12u$">
                    <ul class="actions">
                        <li><input type="submit" value="Enviar mensaje" class="special" /></li>
                    </ul>
                </div>
            </div>
        </form>

        <?php if ($mensaje_exito): ?>
            <p style="color: green; margin-top: 1em;"><?= $mensaje_exito ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p style="color: red; margin-top: 1em;"><?= $error ?></p>
        <?php endif; ?>
    </div>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>