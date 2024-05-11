<?php
session_start(); // Asegurarse de que la sesión está iniciada
session_unset(); // Liberar todas las variables de sesión
session_destroy(); // Destruir la sesión
header("Location: ../../index.html"); // Redirigir al usuario al login
exit();
?>


