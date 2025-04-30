<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <title>Contacto - Tutela La DANA</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="landing">

<header id="header" class="alt">
  <h1><strong><a href="../index.php">Tutela La DANA</a></strong></h1>
  <nav id="nav">
    <ul>
      <li><a href="../index.php">Inicio</a></li>
      <li><a href="../servicios.php">Servicios</a></li>
      <li><a href="../quienes_somos.php">Quiénes Somos</a></li>
      <li><a href="contacto.php">Contacto</a></li> <!-- Ya estás dentro -->
      <li><a href="../carrito/index.php">Carrito</a></li>
      <li><a href="../users/perfil.php">Usuario</a></li>
      <li><a href="../mensajes/inbox.php">Mensaje</a></li>
      <li><a href="../pedidos/historial.php">Pedidos</a></li>
      <?php if (isset($_SESSION['usuario'])): ?>
        <li><a href="../logout.php">Cerrar sesión</a></li>
      <?php else: ?>
        <li><a href="../login.html">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>


<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>

<!-- Banner -->
<section id="banner">
    <h2>Contacto</h2>
    <p>¿Tienes alguna duda o comentario? ¡Escríbenos!</p>
</section>

<!-- Formulario -->
<section id="one" class="wrapper style1">
    <div class="container 75%">
        <div class="row 200%">
            <div class="12u">
                <form method="post" action="">
                    <div class="row uniform 50%">
                        <div class="6u 12u$(xsmall)">
                            <input type="text" name="name" id="name" placeholder="Nombre" required />
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                            <input type="email" name="email" id="email" placeholder="Email" required />
                        </div>
                        <div class="12u$">
                            <textarea name="message" id="message" placeholder="Escribe tu mensaje aquí..." rows="6" required></textarea>
                        </div>
                        <div class="12u$">
                            <ul class="actions">
                                <li><input type="submit" value="Enviar mensaje" class="special" /></li>
                            </ul>
                        </div>
                    </div>
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = htmlspecialchars($_POST["name"]);
                    $email = htmlspecialchars($_POST["email"]);
                    $message = htmlspecialchars($_POST["message"]);

                    // Aquí puedes enviar un correo si quieres con mail()
                    echo "<p>Gracias, <strong>$name</strong>. Hemos recibido tu mensaje.</p>";
                }
                ?>
            </div>
        </div>
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
    © <?php echo date('Y'); ?> Tutela La Dana | Sitio creado con solidaridad
</div>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/skel.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>
