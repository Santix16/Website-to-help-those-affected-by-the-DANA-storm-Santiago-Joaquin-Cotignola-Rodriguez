<!DOCTYPE HTML>
<html>
<head>
    <title>Contacto - Spatial</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body class="landing">
    <?php include("includes/header.php"); ?>
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
                <div class="12u$ 12u$(medium)">
                    <form method="post" action="contacto.php">
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
                    // Manejo simple del envío
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $name = htmlspecialchars($_POST["name"]);
                        $email = htmlspecialchars($_POST["email"]);
                        $message = htmlspecialchars($_POST["message"]);

                        echo "<p>Gracias, <strong>$name</strong>. Hemos recibido tu mensaje.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

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
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
