<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h2 class="text-center text-light mb-4">Editar Ranking</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="card p-4 shadow rounded-4 border-0">
                <form action="<?= base_url('admin/ranking/actualizar/' . $ranking['id']) ?>" method="post" novalidate>

                    <!-- Equipo -->
                    <div class="mb-3">
                        <label for="equipo_id" class="form-label fw-semibold">Equipo</label>
                        <select name="equipo_id" id="equipo_id" class="form-select form-select-lg" required>
                            <option value="" disabled>Seleccione un equipo</option>
                            <?php foreach ($equipos as $equipo): ?>
                                <option value="<?= $equipo['id'] ?>" <?= $equipo['id'] == $ranking['equipo_id'] ? 'selected' : '' ?>>
                                    <?= esc($equipo['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Sala -->
                    <div class="mb-3">
                        <label for="sala_id" class="form-label fw-semibold">Sala</label>
                        <select name="sala_id" id="sala_id" class="form-select form-select-lg" required>
                            <option value="" disabled>Seleccione una sala</option>
                            <?php foreach ($salas as $sala): ?>
                                <option value="<?= $sala['id'] ?>" <?= $sala['id'] == $ranking['sala_id'] ? 'selected' : '' ?>>
                                    <?= esc($sala['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Puntaje -->
                    <div class="mb-3">
                        <label for="puntaje" class="form-label fw-semibold">Puntaje</label>
                        <input type="number" name="puntaje" id="puntaje" class="form-control form-control-lg" value="<?= esc($ranking['puntaje']) ?>" required>
                    </div>

                    <!-- Tiempo (minutos) -->
                    <div class="mb-3">
                        <label for="tiempo" class="form-label fw-semibold">Tiempo (minutos)</label>
                        <input type="number" name="tiempo" id="tiempo" class="form-control form-control-lg"
                            value="<?= esc($ranking['tiempo']) ?>" required min="1">
                    </div>

                    <!-- Cantidad de Integrantes -->
                    <div class="mb-3">
                        <label for="cantidad_integrantes" class="form-label fw-semibold">Cantidad de Integrantes</label>
                        <input type="number" name="cantidad_integrantes" id="cantidad_integrantes" class="form-control form-control-lg"
                            value="<?= esc($ranking['cantidad_integrantes'] ?? '') ?>" required min="1">
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