<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Salas de Escape</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>

<body>
    <?php
    $session = session();
    $usuario_nombre = $session->get('nombre') ?? 'Administrador';
    $usuario_imagen = 'https://cdn-icons-png.flaticon.com/128/8853/8853786.png';
    ?>

    <div class="sidebar" id="sidebar">
        <div class="menu-toggle sidebar-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
        <!-- Logo y nombre -->
        <div class="sidebar-header d-flex align-items-center px-3 py-2">
            <i class="bi bi-house-door-fill me-2 fs-4"></i>
            <span class="sidebar-title">Admin</span>
        </div>

        <a href="<?= base_url('/admin/dashboard') ?>"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a>
        <a href="<?= base_url('/admin/equipos') ?>"><i class="fas fa-users"></i> <span>Equipos</span></a>
        <a href="<?= base_url('/admin/salas') ?>"><i class="fas fa-door-open"></i> <span>Salas</span></a>
        <a href="<?= base_url('/admin/clientes') ?>"><i class="fas fa-users"></i> <span>Clientes</span></a>
        <a href="<?= base_url('/admin/horarios') ?>"><i class="fas fa-clock"></i> <span>Horarios</span></a>
        <a href="<?= base_url('/admin/horarios/disponibles-vista') ?>"><i class="fas fa-clock"></i> <span>Horarios Disponibles</span></a>
        <a href="<?= base_url('/admin/reservas') ?>"><i class="fas fa-calendar-check"></i> <span>Reservas</span></a>
        <a href="<?= base_url('/admin/ranking') ?>"><i class="fas fa-star"></i> <span>Rankings</span></a>
        <a href="<?= base_url('/admin/usuarios') ?>"><i class="fas fa-user"></i> <span>Usuarios</span></a>
    </div>

    <div class="content">
        <nav class="navbar navbar-dark bg-dark px-4 justify-content-between">
            <span class="navbar-brand">
                <i class="fas fa-dungeon me-2"></i> Escape Room Admin
            </span>
            <div class="d-flex align-items-center gap-4">
                <!-- Perfil -->
                <div class="profile" onclick="toggleProfileMenu()">
                    <img src="<?= $usuario_imagen ?>" alt="Usuario" class="rounded-circle" width="40" height="40">
                    <span><?= esc($usuario_nombre) ?></span>
                    <div class="profile-menu" id="profileMenu">
                        <a href="<?= base_url('/logout') ?>">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMenu() {
            let sidebar = document.getElementById('sidebar');
            let content = document.querySelector('.content');
            sidebar.classList.toggle('collapsed');
            content.style.marginLeft = sidebar.classList.contains('collapsed') ? '80px' : '260px';
        }

        function toggleProfileMenu() {
            let menu = document.getElementById('profileMenu');
            menu.classList.toggle('show-menu');
        }
    </script>

    <script>
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });
    </script>

</body>

</html>