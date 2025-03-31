<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h2 class="text-center text-light mb-4">Editar Reserva</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success text-center">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="card p-4 shadow rounded-4 border-0">
                <form action="<?= base_url('admin/reservas/actualizar/' . $reserva['id']) ?>" method="post" novalidate>

                    <!-- Cliente (solo lectura) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cliente</label>
                        <input type="text" class="form-control form-control-lg" value="<?= esc($reserva['nombre_completo']) ?>" readonly>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="text" class="form-control form-control-lg" value="<?= esc($reserva['telefono']) ?>" readonly>
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo</label>
                        <input type="email" class="form-control form-control-lg" value="<?= esc($reserva['correo']) ?>" readonly>
                    </div>

                    <!-- Equipo -->
                    <div class="mb-3">
                        <label for="equipo_id" class="form-label fw-semibold">Equipo</label>
                        <select name="equipo_id" id="equipo_id" class="form-select form-select-lg" required>
                            <option value="" disabled>Seleccione un equipo</option>
                            <?php foreach ($equipos as $equipo): ?>
                                <option value="<?= $equipo['id'] ?>" <?= $equipo['id'] == $reserva['equipo_id'] ? 'selected' : '' ?>>
                                    <?= esc($equipo['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Horario -->
                    <div class="mb-3">
                        <label for="horario_id" class="form-label fw-semibold">Horario</label>
                        <select name="horario_id" id="horario_id" class="form-select form-select-lg" required>
                            <option value="" disabled>Seleccione un horario</option>
                            <?php foreach ($horarios as $horario): ?>
                                <option value="<?= $horario['id'] ?>" <?= $horario['id'] == $reserva['horario_id'] ? 'selected' : '' ?>>
                                    <?= esc($horario['sala_nombre']) ?> - <?= date('H:i', strtotime($horario['hora'])) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Fecha -->
                    <div class="mb-3">
                        <label for="fecha" class="form-label fw-semibold">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control form-control-lg" value="<?= esc($reserva['fecha']) ?>" required>
                    </div>

                    <!-- Jugadores -->
                    <div class="mb-3">
                        <label for="cantidad_jugadores" class="form-label fw-semibold">Cantidad de Jugadores</label>
                        <input type="number" name="cantidad_jugadores" id="cantidad_jugadores" class="form-control form-control-lg" value="<?= esc($reserva['cantidad_jugadores']) ?>" min="1" required>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label for="estado" class="form-label fw-semibold">Estado</label>
                        <select name="estado" id="estado" class="form-select form-select-lg">
                            <option value="pendiente" <?= $reserva['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="confirmado" <?= $reserva['estado'] == 'confirmado' ? 'selected' : '' ?>>Confirmado</option>
                            <option value="cancelado" <?= $reserva['estado'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg rounded-3">Guardar Cambios</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>