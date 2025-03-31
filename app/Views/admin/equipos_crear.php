<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h2 class="text-center text-light mb-4">Registrar Nuevo Equipo</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="card p-4 shadow rounded-4 border-0">
                <form action="<?= base_url('admin/equipos/guardar') ?>" method="post" novalidate>
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Equipo</label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="form-control form-control-lg"
                            placeholder="Ingrese el nombre del equipo"
                            value="<?= old('nombre') ?>"
                            required
                            minlength="3"
                        >
                        <div class="form-text">Mínimo 3 caracteres. El nombre debe ser único.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3">Guardar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
