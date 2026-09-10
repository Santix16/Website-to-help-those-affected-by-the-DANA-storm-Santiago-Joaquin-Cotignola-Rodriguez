<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$id_usuario = (int) ($_SESSION['usuario']['id_usuario'] ?? $_SESSION['usuario']['id'] ?? 0);

// Consulta corregida usando id_usuario
$stmt = $conexion->prepare('SELECT nombre, email, telefono FROM usuarios WHERE id_usuario = :id');
$stmt->execute([':id' => $id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC) ?: $_SESSION['usuario'];

$error = $_GET['error'] ?? null;
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Perfil - Tutela La DANA</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<section id="main" class="wrapper style1">
    <div class="container" style="max-width: 700px">
        <header class="major">
            <h2>Editar perfil</h2>
            <p>Actualiza tus datos de forma segura. La contraseña se cambia solo si escribes una nueva.</p>
        </header>

        <?php if (isset($_GET['actualizado'])): ?>
            <p style="color:green">Perfil actualizado correctamente.</p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p style="color:red"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="actualizar_perfil.php" method="post">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" type="text" value="<?= htmlspecialchars($usuario['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" value="<?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="telefono">Teléfono</label>
            <input id="telefono" name="telefono" type="text" value="<?= htmlspecialchars($usuario['telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <label for="password">Nueva contraseña</label>
            <input id="password" name="password" type="password" minlength="8" placeholder="Dejar en blanco para mantener la actual">

            <ul class="actions" style="margin-top: 1.5em;">
                <li><button type="submit" class="button special">Guardar cambios</button></li>
                <li><a href="perfil.php" class="button">Cancelar</a></li>
            </ul>
        </form>
    </div>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>