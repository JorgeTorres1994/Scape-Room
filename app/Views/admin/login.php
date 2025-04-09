<?php helper('url'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Escape</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css'); ?>">
</head>

<body>
    <div class="login-wrapper">
        <div class="logo-wrapper">
            <img src="<?= base_url('assets/img/logoencryp.png'); ?>" alt="Escape Logo">
        </div>

        <div class="login-card">
            <h2 class="neon-title">Scape Room</h2>
            <p class="subtitle">Ingreso de sesión</p>

            <?php if (session()->getFlashdata('error')): ?>
                <p class="error-message"><?= session()->getFlashdata('error'); ?></p>
            <?php endif; ?>

            <form class="login-form" action="<?= base_url('/login'); ?>" method="post">
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>

</body>

</html>