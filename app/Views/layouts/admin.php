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
        <div class="menu-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
        <h3 class="text-center mt-3">Admin</h3>
        <a href="<?= base_url('/admin/dashboard') ?>"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a>
        <a href="<?= base_url('/admin/equipos') ?>"><i class="fas fa-users"></i> <span>Equipos</span></a>
        <a href="<?= base_url('/admin/salas') ?>"><i class="fas fa-door-open"></i> <span>Salas</span></a>
        <a href="<?= base_url('/admin/clientes') ?>"><i class="fas fa-users"></i> <span>Clientes</span></a>
        <a href="<?= base_url('/admin/horarios') ?>"><i class="fas fa-clock"></i> <span>Horarios</span></a>
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
                <!-- Notificaciones -->
                <div class="dropdown">
                    <button class="btn btn-dark position-relative" id="notificacionesBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell fa-lg"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notif-count">
                            0
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 rounded-4" id="notificacionesLista" style="width: 320px; max-height: 400px; overflow-y: auto;">
                        <li class="dropdown-item text-center text-muted">Sin notificaciones</li>
                    </ul>
                </div>

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
        document.addEventListener('DOMContentLoaded', () => {
            const notifCount = document.getElementById('notif-count');
            const notifLista = document.getElementById('notificacionesLista');

            function cargarNotificaciones() {
                fetch("<?= base_url('admin/notificaciones') ?>")
                    .then(res => res.json())
                    .then(data => {
                        notifCount.textContent = data.noLeidas;

                        if (data.notificaciones.length === 0) {
                            notifLista.innerHTML = `<li class="dropdown-item text-center text-muted">Sin notificaciones</li>`;
                        } else {
                            notifLista.innerHTML = '';

                            data.notificaciones.forEach(n => {
                                const item = document.createElement('li');
                                item.classList.add('dropdown-item', 'd-flex', 'justify-content-between', 'align-items-start', 'flex-column');

                                item.innerHTML = `
                            <div>
                                <span class="fw-semibold">${n.mensaje}</span>
                            </div>
                            <div class="mt-2 d-flex justify-content-between w-100">
                                <a href="<?= base_url('admin/reservas/editar') ?>/${n.reserva_id}" class="btn btn-sm btn-primary">Ver reserva</a>
                                ${n.leida == 0 ? `<button onclick="marcarLeida(${n.id})" class="btn btn-sm btn-outline-secondary ms-2">Confirmar</button>` : ''}
                            </div>
                        `;

                                notifLista.appendChild(item);
                            });
                        }
                    });
            }

            window.marcarLeida = function(id) {
                fetch(`<?= base_url('admin/notificaciones/marcar-leida') ?>/${id}`, {
                    method: 'POST'
                }).then(() => cargarNotificaciones());
            }

            document.getElementById('notificacionesBtn').addEventListener('click', cargarNotificaciones);
        });
    </script>

</body>

</html>