<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$id_usuario = (int) ($_SESSION['usuario']['id_usuario'] ?? $_SESSION['usuario']['id'] ?? 0);

// Consulta utilizando correctamente la columna id_usuario
$stmt = $conexion->prepare('SELECT nombre, email, telefono FROM usuarios WHERE id_usuario = :id');
$stmt->execute([':id' => $id_usuario]);
$datos_db = $stmt->fetch(PDO::FETCH_ASSOC);

$usuario = $datos_db ?: $_SESSION['usuario'];
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil - Tutela La DANA</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<section id="banner">
    <h2>Bienvenido, <?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?></h2>
    <p>Estos son tus datos de perfil. Puedes editarlos en cualquier momento.</p>
</section>

<section id="main-content" class="wrapper style1">
    <div class="container">
        <h3>Tu Información:</h3>
        <div class="row 200%">
            <div class="6u 12u$(medium)">
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="6u$ 12u$(medium)">
                <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>
        <div class="row 200%">
            <div class="12u">
                <p><strong>Teléfono:</strong> <?php echo !empty($usuario['telefono']) ? htmlspecialchars($usuario['telefono'], ENT_QUOTES, 'UTF-8') : 'No disponible'; ?></p>
            </div>
        </div>

        <ul class="actions" style="margin-top: 2em;">
            <li><a href="perfil_privado.php" class="button special big">Actualizar Perfil</a></li>
        </ul>
    </div>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>