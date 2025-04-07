<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h2 class="text-center my-4">Reservas</h2>

<div class="table-responsive">
    <table id="reservasTable" class="table table-light table-hover text-center align-middle shadow-sm rounded">
        <thead class="table-primary">
            <tr>
                <th>Cliente</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Sala</th>
                <th>Hora</th>
                <th>Jugadores</th>
                <th>Método Pago</th>
                <th>Precio Total</th>
                <th>Estado</th>
                <th>Fecha Servicio</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
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
                    data: 'cliente'
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
                    data: 'metodo_pago',
                    render: function(data) {
                        if (data === 'yape') return '<span class="badge bg-secondary">Yape</span>';
                        if (data === 'plin') return '<span class="badge bg-primary">Plin</span>';
                        return '<span class="badge bg-danger">Transferencia</span>';
                    }
                },
                {
                    data: 'precio_total',
                    render: $.fn.dataTable.render.number(',', '.', 2, 'S/ ')
                },
                {
                    data: 'estado',
                    render: function(data) {
                        if (data === 'pendiente') return '<span class="badge bg-warning text-dark">Pendiente</span>';
                        if (data === 'confirmada') return '<span class="badge bg-success">Confirmada</span>';
                        if (data === 'cancelada') return '<span class="badge bg-danger">Cancelada</span>';
                        return data;
                    }
                },
                {
                    data: 'fecha'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'id',
                    render: function(data) {
                        return `<a href="<?= base_url('admin/reservas/editar/') ?>${data}" class="btn btn-sm btn-warning">Editar</a>`;
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron reservas",
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

        $('#filtro_sala, #filtro_fecha, #filtro_estado, #filtro_pago').on('change', function() {
            table.column(1).search($('#filtro_sala').val());
            table.column(4).search($('#filtro_estado').val());
            table.column(5).search($('#filtro_pago').val());
            table.column(7).search($('#filtro_fecha').val());
            table.draw();
        });
    });
</script>

<?= $this->endSection() ?>