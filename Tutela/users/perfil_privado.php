<?php
session_start();

// Si el usuario NO ha iniciado sesión, mostramos un mensaje o redirigimos
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Acceso restringido</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Asegúrate de que la ruta del CSS sea correcta -->
        <link rel="stylesheet" href="../assets/css/main.css">
    </head>
    <body class="landing">
        <main style="text-align: center; margin-top: 50px;">
            <h2>Acceso restringido</h2>
            <p style="font-size: 1.2em; color: #666;">
                Debes <a href="../login.html">iniciar sesión</a> para acceder a tu perfil privado.
            </p>
        </main>
    </body>
    </html>';
    exit;
}

// Si el usuario está logueado, podemos acceder a su información
$usuario = $_SESSION['usuario']; // Puedes usar estos datos para autocompletar el formulario si lo deseas
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Privado</title>
    <!-- Asegúrate de que la ruta del CSS sea correcta -->
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">
    <!-- Header -->
    <header id="header" class="alt">
        <h1><strong><a href="../index.php">TELE-DANA</a></strong> - Perfil Privado</h1>
        <nav id="nav">
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../tienda.php">Tienda</a></li>
                <li><a href="perfil_privado.php">Perfil</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <section id="banner">
        <h2>Perfil del Usuario</h2>
        <p>En esta sección puedes actualizar tus datos personales.</p>
    </section>

    <section id="main-content" class="wrapper style1">
        <div class="container">
            <form action="actualizar_perfil.php" method="POST">
                <div class="row 200%">
                    <div class="6u 12u$(medium)">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>
                    <div class="6u$ 12u$(medium)">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                </div>
                <div class="row 200%">
                    <div class="6u 12u$(medium)">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                    </div>
                    <div class="6u$ 12u$(medium)">
                        <label for="password">Nueva Contraseña:</label>
                        <input type="password" id="password" name="password">
                    </div>
                </div>
                <div class="row 200%">
                    <div class="12u$">
                        <button type="submit" class="button special big">Actualizar Perfil</button>
                    </div>
                </div>
            </form>
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
        &copy; 2025 Tutela La DANA. Todos los derechos reservados.
    </div>
</body>
</html>

