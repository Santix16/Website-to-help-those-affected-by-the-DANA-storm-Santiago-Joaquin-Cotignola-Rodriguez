<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include_once '../includes/db.php';
include_once '../includes/functions.php';
include_once '../includes/header.php'; // Incluye el encabezado

// Verificar que el carrito no esté vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<div class='container'><p>Tu carrito está vacío.</p></div>";
    include_once '../includes/footer.php';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['usuario']['id'];
    $total = 0;
    $lineas = [];

    $conexion->begin_transaction();
    foreach ($_SESSION['carrito'] as $producto_id => $cantidad) {
        $stmt = $conexion->prepare("SELECT nombre, precio_tonkens, stock FROM productos WHERE id = ? FOR UPDATE");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if ($cantidad < 1 || $cantidad > (int) $row['stock']) {
                $conexion->rollback();
                setFlashMessage("No hay stock suficiente para: " . $row['nombre'], "error");
                redirigir("index.php");
            }
            $total += $cantidad * $row['precio_tonkens'];
            $lineas[] = [$producto_id, $cantidad];
        }
    }

    $stmt = $conexion->prepare("INSERT INTO pedidos (usuario_id, estado, total_tonkens) VALUES (?, 'pendiente', ?)");
    $stmt->bind_param("ii", $user_id, $total);
    
    if ($stmt->execute()) {
        $pedido_id = $conexion->insert_id;
        foreach ($lineas as [$producto_id, $cantidad]) {
            $stmt2 = $conexion->prepare("INSERT INTO pedidos_productos (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");
            $stmt2->bind_param("iii", $pedido_id, $producto_id, $cantidad);
            $stmt2->execute();
            $stmt3 = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
            $stmt3->bind_param("ii", $cantidad, $producto_id);
            $stmt3->execute();
        }
        $conexion->commit();
        // Limpiar el carrito
        unset($_SESSION['carrito']);
        setFlashMessage("Pedido realizado con éxito. Total: $total tonkens.");
        redirigir("historial.php");
    } else {
        setFlashMessage("Error al procesar el pedido.", "error");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout - DANA</title>
    <!-- Vinculamos el archivo CSS correctamente -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Asegúrate de que la ruta sea correcta -->
    <link rel="stylesheet" href="../assets/css/main.css"> <!-- Asegúrate de incluir el CSS de index.html -->
</head>
<body class="landing"> <!-- Clase de body de index.html -->

    <!-- Header -->
    <header id="header" class="alt">
        <h1><strong><a href="../index.php">DANA</a></strong> Carrito de Compras</h1>
        <nav id="nav">
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../productos/index.php">Productos</a></li>
                <li><a href="historial.php">Historial de Pedidos</a></li>
                <li><a href="../contacto/contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>

    <section id="banner">
        <h2>Checkout</h2>
        <p>Revisa tu pedido antes de confirmar la compra.</p>
    </section>

    <!-- Main content -->
    <section id="main" class="wrapper style1">
        <div class="container 75%">
            <h2>Resumen del Pedido</h2>
            <table class="checkout-summary">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario (tonkens)</th>
                        <th>Subtotal (tonkens)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['carrito'] as $producto_id => $cantidad):
                        $stmt = $conexion->prepare("SELECT nombre, precio_tonkens FROM productos WHERE id = ?");
                        $stmt->bind_param("i", $producto_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($row = $result->fetch_assoc()):
                            $subtotal = $cantidad * $row['precio_tonkens'];
                            $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo $cantidad; ?></td>
                        <td><?php echo $row['precio_tonkens']; ?></td>
                        <td><?php echo $subtotal; ?></td>
                    </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </tbody>
            </table>
            <p><strong>Total a pagar:</strong> <?php echo $total; ?> tonkens</p>

            <!-- Formulario para confirmar el pedido -->
            <form action="checkout.php" method="POST">
                <button type="submit" class="button special big">Confirmar Pedido</button>
            </form>

            <p><a href="../productos/index.php" class="button big">Continuar Comprando</a></p>
        </div>
    </section>

    <?php include_once '../includes/footer.php'; // Incluye el pie de página ?>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/skel.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>

</body>
</html>







