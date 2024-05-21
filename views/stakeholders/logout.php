<?php
session_start();
session_unset();
session_destroy();

// Eliminar las cookies estableciendo una fecha de caducidad en el pasado
setcookie('userid', '', time() - 3600, '/', 'localhost');
setcookie('username', '', time() - 3600, '/', 'localhost');
setcookie('usertype', '', time() - 3600, '/', 'localhost');
header("Location: ../../index.html"); // Redirigir al usuario al login
exit();
?>


