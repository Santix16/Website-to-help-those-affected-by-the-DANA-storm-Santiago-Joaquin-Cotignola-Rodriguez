<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  include_once 'includes/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if (($row = $stmt->fetch(PDO::FETCH_ASSOC)) && password_verify($password, $row['password'])) {
            $_SESSION['usuario'] = [
                'id' => $row['id_usuario'],
                'email' => $row['email'],
                'nombre' => $row['nombre'],
                'role' => $row['role'] ?? 'USER'
            ];
            header("Location: index.php");
            exit();
    }

    // Falló
    header("Location: login.php?error=1");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Tutela La DANA</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="landing">

<?php include_once 'includes/header.php'; ?>

<!-- Main -->
<section id="main" class="wrapper style1" style="padding: 6em 0; display: flex; justify-content: center; align-items: center; min-height: 80vh;">
  <div class="container" style="max-width: 600px;">
    <header class="major special">
      <h2>Iniciar Sesión</h2>
      <?php if (isset($_GET['error'])): ?>
        <p style="color: red; text-align: center;">Correo o contraseña incorrectos.</p>
      <?php endif; ?>
      <p>Accede a tu cuenta de Tutela La DANA</p>
    </header>

    <section>
      <form method="POST" action="login.php" class="alt">
        <div class="row uniform 50%">
          <div class="12u$">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" placeholder="Correo Electrónico" required />
          </div>
          <div class="12u$">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" placeholder="Contraseña" required />
          </div>
          <div class="12u$">
            <ul class="actions">
              <li><input type="submit" value="Ingresar" class="special" /></li>
            </ul>
          </div>
        </div>
      </form>
      <p style="text-align: center;">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
    </section>
  </div>
</section>

<!-- Footer -->
<footer id="footer" style="padding: 0.8em 0; background: #f5f5f5; font-size: 0.8em; text-align: center;">
  <div class="container">
    <p style="margin: 0;">© 2025 Tutela La DANA. Todos los derechos reservados.</p>
    <a href="legal/legal.html">Términos de Uso</a> |
    <a href="legal/privacidad.html">Protección de Datos</a>
  </div>
</footer>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/skel.min.js"></script>
<script src="js/skel-layers.min.js"></script>
<script src="js/init.js"></script>

</body>
</html>
