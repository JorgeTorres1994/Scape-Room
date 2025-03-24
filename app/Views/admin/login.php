<?php helper('url'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Ecodrive+</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css'); ?>">
    <script defer src="<?= base_url('assets/js/login.js'); ?>"></script>
</head>

<body>

    <div class="title-container">
        <img src="<?= base_url('assets/img/logo_ecodrive.png'); ?>" alt="Ecodrive+ Logo" class="logo">
    </div>

    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <p>Bienvenido, ingresa tus credenciales para continuar.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="error-message"><?= session()->getFlashdata('error'); ?></p>
        <?php endif; ?>

        <form id="loginForm" action="<?= base_url('/login'); ?>" method="post">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" autocomplete="off" required>
            <div class="invalid-feedback" id="emailError">Ingresa un correo válido (ejemplo@dominio.com).</div>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" minlength="8" autocomplete="off" required>
            <div class="invalid-feedback" id="passwordError">
                La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo.
            </div>

            <button type="submit" id="submitButton" disabled>Ingresar</button>
        </form>
    </div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("loginForm");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const submitButton = document.getElementById("submitButton");

        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");

        function validateEmail() {
            const email = emailInput.value.trim();
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!emailPattern.test(email)) {
                emailError.style.display = "block";
                emailInput.classList.add("is-invalid");
                return false;
            } else {
                emailError.style.display = "none";
                emailInput.classList.remove("is-invalid");
                return true;
            }
        }

        function validatePassword() {
            const password = passwordInput.value.trim();
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!passwordPattern.test(password)) {
                passwordError.style.display = "block";
                passwordInput.classList.add("is-invalid");
                return false;
            } else {
                passwordError.style.display = "none";
                passwordInput.classList.remove("is-invalid");
                return true;
            }
        }

        function toggleSubmitButton() {
            if (validateEmail() && validatePassword()) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        emailInput.addEventListener("input", toggleSubmitButton);
        passwordInput.addEventListener("input", toggleSubmitButton);
    });
</script>

</html>