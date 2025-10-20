<?php
session_start();          // Inicia la sesión actual
session_destroy();        // Elimina todos los datos de sesión
header("Location: index.html"); // Redirige al login
exit();
