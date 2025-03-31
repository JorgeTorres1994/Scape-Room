<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h2 class="text-center my-4">Ranking de Equipos</h2>

<div class="table-responsive">
    <table id="rankingTable" class="table table-light table-hover text-center align-middle shadow-sm rounded">
        <thead class="table-primary">
            <tr>
                <th>Equipo</th>
                <th>Sala</th>
                <th>Tiempo</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Estilos DataTables personalizados -->
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

<!-- DataTables scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#rankingTable').DataTable({
            ajax: {
                url: "<?= base_url('admin/ranking/obtener') ?>",
                dataSrc: 'data'
            },
            columns: [
                { data: 'equipo_nombre' },
                { data: 'sala_nombre' },
                { data: 'tiempo' },
                {
                    data: 'registrado_en',
                    render: data => {
                        const date = new Date(data);
                        return date.toLocaleDateString('es-PE');
                    }
                },
                {
                    data: 'id',
                    render: function (data) {
                        return `<a href="<?= base_url('admin/ranking/editar/') ?>${data}" class="btn btn-sm btn-warning">Editar</a>`;
                    }
                }
            ],
            order: [[3, 'desc']], // orden por fecha descendente
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron rankings",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrado de _MAX_ registros en total)",
                search: "Buscar:",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>
