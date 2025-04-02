<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
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
                        <label for="cliente" class="form-label fw-semibold">Nombre del Cliente</label>
                        <input type="text" name="cliente" id="cliente" class="form-control form-control-lg"
                            value="<?= esc($reserva['cliente']) ?>" required>
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label for="correo" class="form-label fw-semibold">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" class="form-control form-control-lg"
                            value="<?= esc($reserva['correo']) ?>" required>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control form-control-lg"
                            value="<?= esc($reserva['telefono']) ?>" required>
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
                        <label for="fecha" class="form-label fw-semibold">Fecha de la Reserva</label>
                        <input type="date" name="fecha" id="fecha" class="form-control form-control-lg"
                            value="<?= esc($reserva['fecha']) ?>" required>
                    </div>

                    <!-- Cantidad de jugadores -->
                    <div class="mb-3">
                        <label for="cantidad_jugadores" class="form-label fw-semibold">Cantidad de Jugadores</label>
                        <input type="number" name="cantidad_jugadores" id="cantidad_jugadores" class="form-control form-control-lg"
                            value="<?= esc($reserva['cantidad_jugadores']) ?>" min="1" required>
                    </div>

                    <!-- Método de pago -->
                    <div class="mb-3">
                        <label for="metodo_pago" class="form-label fw-semibold">Método de Pago</label>
                        <select name="metodo_pago" id="metodo_pago" class="form-select form-select-lg" required>
                            <option value="" disabled>Seleccione un método</option>
                            <option value="yape" <?= $reserva['metodo_pago'] === 'yape' ? 'selected' : '' ?>>Yape</option>
                            <option value="plin" <?= $reserva['metodo_pago'] === 'plin' ? 'selected' : '' ?>>Plin</option>
                            <option value="transferencia" <?= $reserva['metodo_pago'] === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                        </select>
                    </div>

                    <!-- Precio total -->
                    <div class="mb-3">
                        <label for="precio_total" class="form-label fw-semibold">Precio Total (S/.)</label>
                        <input type="number" step="0.01" name="precio_total" id="precio_total" class="form-control form-control-lg"
                            value="<?= esc($reserva['precio_total']) ?>" required>
                    </div>

                    <!-- Estado -->
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