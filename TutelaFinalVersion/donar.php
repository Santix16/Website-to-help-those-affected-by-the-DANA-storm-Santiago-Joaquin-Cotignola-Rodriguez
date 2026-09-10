<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// Verificar que el usuario este registrado e haya iniciado sesion
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?redirect=donar.php");
    exit();
}

$mensajeEstado = '';

// Procesar el formulario de donacion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $producto_id = filter_input(INPUT_POST, 'producto_id', FILTER_VALIDATE_INT);
    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT) ?: 1;
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $notas = trim($_POST['notas'] ?? '');

    if ($producto_id && !empty($direccion) && !empty($telefono)) {
        try {
            $stmt = $conexion->prepare("
                INSERT INTO donaciones (id_usuario, producto_id, cantidad, direccion_recogida, telefono_contacto, notas_adicionales)
                VALUES (:user_id, :producto_id, :cantidad, :direccion, :telefono, :notas)
            ");
            $stmt->execute([
                ':user_id' => $_SESSION['usuario']['id'],
                ':producto_id' => $producto_id,
                ':cantidad' => $cantidad,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':notas' => $notas
            ]);
            $mensajeEstado = "<div style='color: #27ae60; font-weight: bold; padding: 1em; background: #e8f8f5; border: 1px solid #2ecc71; margin-bottom: 2em; border-radius: 4px;'>"
                . "¡Muchas gracias por tu solidaridad! Hemos registrado tu donacion y coordinaremos la recogida en la direccion indicada.</div>";
        } catch (PDOException $e) {
            $errorDetalle = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            $mensajeEstado = "<div style='color: #c0392b; padding: 1em; background: #fde8e8; border: 1px solid #e74c3c; margin-bottom: 2em; border-radius: 4px;'>"
                . "Ocurrio un error al guardar la donacion. Detalle del error: <strong>" . $errorDetalle . "</strong></div>";
        }
    } else {
        $mensajeEstado = "<div style='color: #c0392b; padding: 1em; background: #fde8e8; border: 1px solid #e74c3c; margin-bottom: 2em; border-radius: 4px;'>Por favor completa el elemento, la direccion de recogida y tu telefono de contacto.</div>";
    }
}

// Cargar la lista de productos disponibles en el catalogo para el desplegable
$stmtProductos = $conexion->query("SELECT id, nombre FROM productos ORDER BY nombre ASC");
$productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <title>Donar Elemento - Tutela La DANA</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>
<body class="landing">

<?php include_once 'includes/header.php'; ?>

<!-- Banner -->
<section id="banner">
    <h2>Unete a la Causa - Haz tu Donacion</h2>
    <p>Indica que producto deseas aportar y la direccion exacta donde nuestro equipo debe ir a buscarlo.</p>
</section>

<!-- Formulario de Donacion -->
<section id="one" class="wrapper style1">
    <div class="container 75%">
        <?= $mensajeEstado ?>

        <form method="post" action="donar.php">
            <div class="row uniform 50%">

                <div class="8u 12u$(xsmall)">
                    <label for="producto_id">Elemento a Donar</label>
                    <div class="select-wrapper">
                        <select name="producto_id" id="producto_id" required>
                            <option value="">-- Selecciona el elemento que aportaras --</option>
                            <?php foreach ($productos as $item): ?>
                                <option value="<?= $item['id'] ?>"><?= htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="4u$ 12u$(xsmall)">
                    <label for="cantidad">Cantidad de Unidades</label>
                    <input type="number" name="cantidad" id="cantidad" value="1" min="1" required />
                </div>

                <div class="12u$">
                    <label for="direccion">¿A donde tenemos que ir a buscarlo? (Direccion completa)</label>
                    <input type="text" name="direccion" id="direccion" placeholder="Calle, numero, piso, puerta, localidad, codigo postal" required />
                </div>

                <div class="12u$">
                    <label for="telefono">Telefono de Contacto para la Recogida</label>
                    <input type="tel" name="telefono" id="telefono" placeholder="Ej: 600123456" required />
                </div>

                <div class="12u$">
                    <label for="notas">Instrucciones o notas sobre la recogida (Opcional)</label>
                    <textarea name="notas" id="notas" placeholder="Ej: Horario disponible, timbre roto, llamar antes de ir..." rows="4"></textarea>
                </div>

                <div class="12u$">
                    <ul class="actions">
                        <li><input type="submit" value="Confirmar Donacion y Solicitud de Recogida" class="special" /></li>
                        <li><a href="servicios.php" class="button alt">Cancelar</a></li>
                    </ul>
                </div>

            </div>
        </form>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>