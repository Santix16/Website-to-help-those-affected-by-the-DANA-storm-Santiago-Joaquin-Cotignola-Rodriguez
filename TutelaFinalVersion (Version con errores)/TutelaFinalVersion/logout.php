<?php
session_start();
session_destroy(); // Elimina toda la sesión
header("Location: login.php"); // Redirige al login
exit();
