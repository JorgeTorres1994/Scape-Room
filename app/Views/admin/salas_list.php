<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h2 class="text-center my-4">Lista de Salas</h2>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table id="salasTable" class="table table-light table-hover text-center align-middle shadow-sm rounded">
        <thead class="table-primary">
            <tr>
                <th>Nombre</th>
                <th>Dificultad</th>
                <th>Jugadores</th>
                <th>Duración</th>
                <th>Rating</th>
                <th>Tags</th>
                <th>Imagen</th>
                <th>Destacada</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salas as $sala): ?>
                <tr>
                    <td><?= esc($sala['nombre']) ?></td>
                    <td><?= esc($sala['dificultad']) ?></td>
                    <td><?= esc($sala['min_jugadores']) ?> - <?= esc($sala['max_jugadores']) ?></td>
                    <td><?= esc($sala['duracion']) ?> min</td>
                    <td><?= esc($sala['rating']) ?> ⭐</td>
                    <td>
                        <?php
                        $tags = explode(',', $sala['tags']);
                        foreach ($tags as $tag) {
                            echo '<span class="badge bg-dark me-1">' . esc(trim($tag)) . '</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <img src="<?= base_url('assets/img/scape_room.jpg') ?>" class="img-thumbnail" width="60" height="60">
                    </td>

                    <td>
                        <?= $sala['destacado'] ? '<span class="badge bg-warning text-dark">Sí</span>' : 'No' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- DataTables + Estilos -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style>
    .dataTables_wrapper {
        color: white;
    }

    .dataTables_length label,
    .dataTables_filter label {
        color: white;
    }

    .dataTables_length select,
    .dataTables_filter input {
        background-color: #23272E;
        color: white;
        border: 1px solid #555;
        border-radius: 5px;
        padding: 5px;
    }

    thead th,
    tbody td {
        text-align: center !important;
    }
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#salasTable').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron salas",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros en total)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>