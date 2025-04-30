<?php 
session_start();
include '../includes/db.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Detalle del Pedido - Tutela la DANA</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body class="landing">

<!-- Header -->
<header id="header" class="alt">
  <h1><strong><a href="index.html">Tutela La DANA</a></strong></h1>
  <nav id="nav">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="servicios.php">Servicios</a></li>
      <li><a href="quienes_somos.html">Quiénes Somos</a></li>
      <li><a href="contacto/contacto.php">Contacto</a></li>
      <li><a href="login.html">Login</a></li>
    </ul>
  </nav>
</header>
<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>

<!-- Banner -->
<section id="banner">
    <h2>Detalle del Pedido</h2>
    <p>Consulta el estado de tu pedido</p>
</section>

<!-- Contenido principal -->
<section id="one" class="wrapper style1">
    <div class="container">

        <?php if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])): ?>
            <p style="text-align:center; font-size: 1.2em; color: #c00;">
                Debes <a href="../login.html">iniciar sesión</a> para ver tus pedidos.
            </p>
        <?php elseif (!isset($_GET['id']) || !is_numeric($_GET['id'])): ?>
            <p style="text-align:center; font-size: 1.2em; color: #c00;">
                Pedido no especificado o no válido.
            </p>
        <?php else: ?>
            <?php
            $pedido_id = intval($_GET['id']);
            $usuario_id = $_SESSION['usuario']['id'];

            $query = $conexion->prepare("SELECT * FROM pedidos WHERE id = ? AND usuario_id = ?");
            $query->bind_param("ii", $pedido_id, $usuario_id);
            $query->execute();
            $result = $query->get_result();

            if ($result && $result->num_rows === 1):
                $pedido = $result->fetch_assoc();
            ?>

                <div class="box">
                    <h3>Pedido #<?php echo $pedido['id']; ?></h3>
                    <p><strong>Fecha:</strong> <?php echo $pedido['fecha']; ?></p>
                    <p><strong>Total (tonkens):</strong> <?php echo $pedido['total_tonkens']; ?></p>
                    <p><strong>Estado:</strong> <?php echo $pedido['estado']; ?></p>
                    <!-- Aquí puedes añadir más detalles del pedido si tienes otra tabla relacionada, como productos -->
                </div>

            <?php else: ?>
                <p style="text-align:center; font-size: 1.2em; color: #c00;">
                    No se encontró el pedido o no tienes permiso para verlo.
                </p>
            <?php endif; ?>
        <?php endif; ?>

        <ul class="actions" style="text-align:center; margin-top: 30px;">
            <li><a href="historial.php" class="button">Volver al Historial</a></li>
        </ul>

    </div>
</section>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <ul class="icons">
            <li><a href="#" class="icon fa-facebook"></a></li>
            <li><a href="#" class="icon fa-twitter"></a></li>
            <li><a href="#" class="icon fa-instagram"></a></li>
        </ul>
    </div>
</footer>

<div class="copyright">
    © 2025 Tutela la DANA. Todos los derechos reservados. |
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

