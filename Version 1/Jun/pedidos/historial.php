<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/functions.php';
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pedidos - TELE-DANA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body class="landing">

<!-- Header -->
<header id="header" class="alt">
    <h1><strong><a href="../index.html">TELE-DANA</a></strong></h1>
    <nav id="nav">
        <ul>
            <li><a href="../index.html">Inicio</a></li>
            <li><a href="../quienes_somos.html">Quiénes Somos</a></li>
            <li><a href="../contacto/contacto.php">Contacto</a></li>
            <li><a href="../login.html">Login</a></li>
        </ul>
    </nav>
</header>
<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>

<?php if (!isset($_SESSION['usuario'])): ?>
    <!-- Si NO ha iniciado sesión -->
    <section id="banner">
        <h2>Acceso Restringido</h2>
        <p>Debes <a href="../login.html">iniciar sesión</a> para ver tu historial de pedidos.</p>
    </section>
<?php else: ?>
    <?php
    // Ya está logueado, seguimos
    $user_id = $_SESSION['usuario']['id'];
    $query = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha DESC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <section id="banner">
        <h2>Historial de Pedidos</h2>
        <p>Consulta tus pedidos realizados en TELE-DANA.</p>
    </section>

    <section id="one" class="wrapper style1">
        <div class="container 75%">
            <div class="box">
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID Pedido</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Total (tonkens)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($pedido = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $pedido['id']; ?></td>
                                        <td><?php echo $pedido['fecha']; ?></td>
                                        <td><?php echo $pedido['estado']; ?></td>
                                        <td><?php echo $pedido['total_tonkens']; ?></td>
                                        <td>
                                            <a href="pedido.php?id=<?php echo $pedido['id']; ?>" class="button small">Ver Detalles</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No has realizado ningún pedido.</p>
                <?php endif; ?>

                <ul class="actions" style="margin-top: 20px;">
                    <li><a href="pedido.php" class="button special">Ver el estado de mi pedido actual</a></li>
                    <li><a href="/TELEDANA/productos/index.php" class="button">Realizar un Nuevo Pedido</a></li>
                </ul>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <ul class="icons">
            <li><a href="#" class="icon fa-facebook" aria-label="Facebook"></a></li>
            <li><a href="#" class="icon fa-twitter" aria-label="Twitter"></a></li>
            <li><a href="#" class="icon fa-instagram" aria-label="Instagram"></a></li>
        </ul>
    </div>
</footer>

<div class="copyright">
    © 2025 TELE-DANA. Todos los derechos reservados. |
    <a href="../legal/legal.html">Términos de Uso</a> |
    <a href="../legal/privacidad.html">Protección de Datos</a>
</div>

<!-- Scripts -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/skel.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>



