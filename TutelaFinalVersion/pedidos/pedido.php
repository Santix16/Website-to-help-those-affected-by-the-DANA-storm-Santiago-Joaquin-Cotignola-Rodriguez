<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$id_pedido = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id_pedido) {
    header("Location: historial.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'] ?? $_SESSION['usuario']['id_usuario'];

try {
    // Consulta con PDO para obtener los datos del pedido
    $stmt = $conexion->prepare("SELECT * FROM pedidos WHERE id = :id_pedido AND usuario_id = :id_usuario");
    $stmt->execute([
        ':id_pedido' => $id_pedido,
        ':id_usuario' => $id_usuario
    ]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pedido) {
        header("Location: historial.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Pedido #<?= (int)$pedido['id'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<!-- Banner -->
<section id="banner">
    <h2>Detalle del Pedido</h2>
    <p>Consulta el estado de tu pedido</p>
</section>

<!-- Contenido -->
<section id="one" class="wrapper style1">
    <div class="container">
        <div class="box">
            <h3>Pedido #<?= (int)$pedido['id'] ?></h3>
            <p><strong>Fecha de solicitud:</strong> <?= htmlspecialchars($pedido['fecha_pedido'] ?? $pedido['fecha'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Estado del pedido:</strong> <?= htmlspecialchars($pedido['estado'], ENT_QUOTES, 'UTF-8') ?></p>

            <ul class="actions" style="margin-top: 2em;">
                <li><a href="historial.php" class="button alt">Volver al Historial</a></li>
            </ul>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/skel.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>