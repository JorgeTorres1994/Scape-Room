<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h2 class="text-center my-4">Reservas</h2>

<div class="row mb-3">
    <div class="col-md-3">
        <label for="filtro_sala" class="form-label">Sala</label>
        <select id="filtro_sala" class="form-select">
            <option value="">Todas</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="filtro_fecha" class="form-label">Fecha de Servicio</label>
        <input type="date" id="filtro_fecha" class="form-control">
    </div>
    <div class="col-md-3">
        <label for="filtro_estado" class="form-label">Estado</label>
        <select id="filtro_estado" class="form-select">
            <option value="">Todos</option>
            <option value="pendiente">Pendiente</option>
            <option value="confirmada">Confirmada</option>
            <option value="cancelada">Cancelada</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="filtro_pago" class="form-label">Método de Pago</label>
        <select id="filtro_pago" class="form-select">
            <option value="">Todos</option>
            <option value="yape">Yape</option>
            <option value="plin">Plin</option>
            <option value="transferencia">Transferencia</option>
        </select>
    </div>
</div>

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

    /* Estilo base de fila deshabilitada */
    .row-disabled {
        background-color: #e0e0e0 !important;
        opacity: 0.7;
    }

    /* Bloquear hover en la fila completa */
    .row-disabled:hover {
        background-color: #e0e0e0 !important;
    }

    /* Anular estilos visuales en badges y botones dentro de fila deshabilitada */
    .row-disabled .btn,
    .row-disabled .badge {
        pointer-events: none !important;
        background-color: #bbb !important;
        color: #666 !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* Quitar efecto hover incluso si se fuerza con Bootstrap */
    .row-disabled .btn:hover,
    .row-disabled .badge:hover {
        background-color: #bbb !important;
        color: #666 !important;
        cursor: not-allowed !important;
        box-shadow: none !important;
        border: none !important;
        opacity: 0.8;
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Cargar dinámicamente las salas
        $.get('<?= base_url('admin/salas/obtener-json') ?>', function(data) {
            if (Array.isArray(data)) {
                data.forEach(function(sala) {
                    $('#filtro_sala').append(`<option value="${sala.nombre}">${sala.nombre}</option>`);
                });
            }
        });

        const table = $('#reservasTable').DataTable({
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
                    data: 'estado',
                    render: function(data) {
                        if (data === 'pendiente') return '<span class="badge bg-warning text-dark">Pendiente</span>';
                        if (data === 'confirmada') return '<span class="badge bg-success">Confirmada</span>';
                        if (data === 'cancelada') return '<span class="badge bg-danger">Cancelada</span>';
                        return data;
                    }
                },
                {
                    data: 'metodo_pago',
                    render: function(data) {
                        if (data === 'yape') return '<span class="badge bg-secondary">Yape</span>';
                        if (data === 'plin') return '<span class="badge bg-primary">Plin</span>';
                        return '<span class="badge bg-dark">Transferencia</span>';
                    }
                },
                {
                    data: 'precio_total',
                    render: $.fn.dataTable.render.number(',', '.', 2, 'S/ ')
                },
                {
                    data: 'fecha'
                },
                {
                    data: 'created_at'
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        const editBtn = row.activo ?
                            `<a href="<?= base_url('admin/reservas/editar/') ?>${row.id}" class="btn btn-sm btn-warning">Editar</a>` :
                            `<button class="btn btn-sm btn-secondary" disabled>Editar</button>`;

                        const toggleBtn = row.activo ?
                            `<button type="button" class="btn btn-sm btn-danger ms-1 toggle-estado" data-id="${row.id}">Deshabilitar</button>` :
                            `<button type="button" class="btn btn-sm btn-success ms-1 toggle-estado" data-id="${row.id}">Habilitar</button>`;


                        return `${editBtn} ${toggleBtn}`;
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            createdRow: function(row, data) {
                if (data.activo === 0 || data.activo === '0') {
                    $(row).addClass('table-secondary row-disabled');
                    $(row).find('a, button').prop('disabled', true).addClass('disabled').css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });
                }
            },

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
            table.column(3).search($('#filtro_sala').val());
            table.column(8).search($('#filtro_estado').val());
            table.column(6).search($('#filtro_pago').val());
            table.column(9).search($('#filtro_fecha').val());
            table.draw();
        });

        $(document).on('click', '.toggle-estado', function(e) {
            e.preventDefault();

            const id = $(this).data('id');
            const nuevoEstado = $(this).hasClass('btn-danger') ? 0 : 1;

            fetch(`<?= base_url('admin/reservas/toggle-activo/') ?>${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        reserva: {
                            activo: nuevoEstado
                        }
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        $('#reservasTable').DataTable().ajax.reload();
                    } else {
                        alert(data.message || 'Error al cambiar el estado.');
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    alert('Error al enviar solicitud.');
                });
        });

    });
</script>

<?= $this->endSection() ?>