<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h2 class="text-center my-4">Reservas</h2>

<div class="table-responsive">
    <!-- <table id="reservasTable" class="table table-light table-hover text-center align-middle shadow-sm rounded">
        <thead class="table-dark">
            <tr>
                <th>Cliente</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Sala</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Jugadores</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table> -->
    <table id="reservasTable" class="table table-light table-hover text-center align-middle shadow-sm rounded">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Sala</th>
                <th>Hora</th>
                <th>Jugadores</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
    </table>
</div>

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

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#reservasTable').DataTable({
            ajax: {
                url: '<?= base_url("admin/reservas/obtener") ?>',
                dataSrc: 'data'
            },
            columns: [{
                    data: 'nombre_completo'
                },
                {
                    data: 'correo'
                },
                {
                    data: 'telefono'
                },
                {
                    data: 'sala_nombre'
                },

                {
                    data: 'hora'
                },
                {
                    data: 'cantidad_jugadores'
                },
                {
                    data: 'fecha'
                },
                {
                    data: 'estado'
                }
            ]
        });

    });
</script>

<?= $this->endSection() ?>