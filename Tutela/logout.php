<?php
session_start();
session_destroy(); // Elimina toda la sesión
header("Location: login.html"); // Redirige al login
exit();
