<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h2 class="text-center text-light mb-4">Editar Reserva</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="card p-4 shadow rounded-4 border-0">
                <form action="<?= base_url('admin/reservas/actualizar/' . $reserva['id']) ?>" method="post" novalidate>

                    <!-- Cliente -->
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label fw-semibold">Cliente</label>
                        <select name="cliente_id" id="cliente_id" class="form-select form-select-lg" required>
                            <option value="" disabled>Seleccione un cliente</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $reserva['cliente_id'] ? 'selected' : '' ?>>
                                    <?= esc($cliente['nombre_completo']) ?> - <?= esc($cliente['correo']) ?>
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
                        <input type="date" name="fecha" id="fecha" class="form-control form-control-lg"
                            value="<?= esc($reserva['fecha']) ?>" required>
                    </div>

                    <!-- Jugadores -->
                    <div class="mb-3">
                        <label for="cantidad_jugadores" class="form-label fw-semibold">Cantidad de Jugadores</label>
                        <input type="number" name="cantidad_jugadores" id="cantidad_jugadores"
                            class="form-control form-control-lg" value="<?= esc($reserva['cantidad_jugadores']) ?>" required min="1">
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label fw-semibold">Estado</label>
                        <select name="estado" id="estado" class="form-select form-select-lg" required>
                            <option value="pendiente" <?= $reserva['estado'] == 'pendiente'   ? 'selected' : '' ?>>Pendiente</option>
                            <option value="confirmada" <?= $reserva['estado'] == 'confirmada'  ? 'selected' : '' ?>>Confirmada</option>
                            <option value="cancelada" <?= $reserva['estado'] == 'cancelada'   ? 'selected' : '' ?>>Cancelada</option>
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