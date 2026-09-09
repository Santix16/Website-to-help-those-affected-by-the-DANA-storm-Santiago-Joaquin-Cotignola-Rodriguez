<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit();
}
require_once __DIR__ . '/../includes/db.php';
$stmt = $conexion->prepare('SELECT nombre, email FROM usuarios WHERE id_usuario = :id');
$stmt->execute([':id' => (int) $_SESSION['usuario']['id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC) ?: $_SESSION['usuario'];
$error = $_GET['error'] ?? null;
?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Editar perfil - Tutela La DANA</title><link rel="stylesheet" href="../assets/css/main.css"></head>
<body class="landing">
<?php include_once '../includes/header.php'; ?>
<section id="main" class="wrapper style1"><div class="container" style="max-width: 700px"><header class="major"><h2>Editar perfil</h2><p>Actualiza tus datos de forma segura. La contraseña se cambia solo si escribes una nueva.</p></header>
<?php if (isset($_GET['actualizado'])): ?><p style="color:green">Perfil actualizado correctamente.</p><?php endif; ?>
<?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
<form action="actualizar_perfil.php" method="post"><label for="nombre">Nombre</label><input id="nombre" name="nombre" type="text" value="<?= htmlspecialchars($usuario['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required><label for="email">Correo electronico</label><input id="email" name="email" type="email" value="<?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required><label for="password">Nueva contraseña</label><input id="password" name="password" type="password" minlength="8"><ul class="actions"><li><button type="submit" class="button special">Guardar cambios</button></li><li><a href="perfil.php" class="button">Cancelar</a></li></ul></form></div></section>
</body></html>

