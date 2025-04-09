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

                    <!-- Tiempo -->
                    <?php
                    [$hh, $mm, $ss] = explode(':', $ranking['tiempo']);
                    ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tiempo (hh:mm:ss)</label>
                        <div class="d-flex gap-2">
                            <select name="hora" class="form-select" required>
                                <?php for ($h = 0; $h < 24; $h++): ?>
                                    <option value="<?= sprintf('%02d', $h) ?>" <?= $hh == sprintf('%02d', $h) ? 'selected' : '' ?>>
                                        <?= sprintf('%02d', $h) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="minuto" class="form-select" required>
                                <?php for ($m = 0; $m < 60; $m++): ?>
                                    <option value="<?= sprintf('%02d', $m) ?>" <?= $mm == sprintf('%02d', $m) ? 'selected' : '' ?>>
                                        <?= sprintf('%02d', $m) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="segundo" class="form-select" required>
                                <?php for ($s = 0; $s < 60; $s++): ?>
                                    <option value="<?= sprintf('%02d', $s) ?>" <?= $ss == sprintf('%02d', $s) ? 'selected' : '' ?>>
                                        <?= sprintf('%02d', $s) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
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