<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error en el registro</title>
    <link rel="stylesheet" href="/nitalink/public/css/formulario2.css">
</head>
<body>
    <header>
        <h1>Error en el registro</h1>
    </header>
    <main>
        <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="fondoHexagonal.mp4">
        </video>
        <div class="error-message">
            <p><?= nl2br(htmlspecialchars($errorMessage)) ?></p>

            <a href="javascript:history.back()">Volver a intentarlo</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
