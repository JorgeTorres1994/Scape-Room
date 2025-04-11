<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h2 class="text-center my-4">Listado de Equipos</h2>

<a href="<?= base_url('admin/equipos/crear') ?>" class="btn btn-primary">Nuevo Equipo</a>

<div class="table-responsive">
    <table id="equiposTable" class="table table-light table-hover text-center align-middle shadow-sm rounded">
        <thead class="table-primary">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipos as $equipo): ?>
                <tr>
                    <td><?= esc($equipo['codigo']) ?></td>
                    <td><?= esc($equipo['nombre']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($equipo['creado_en'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Botón para abrir el modal -->
<button class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#modalGeneradorCodigo">
    Generar y Desencriptar Código
</button>

<!-- Modal -->
<div class="modal fade" id="modalGeneradorCodigo" tabindex="-1" aria-labelledby="modalGeneradorCodigoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGeneradorCodigoLabel">Generar Código Encriptado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">

                <form id="formGenerarManual">
                    <div class="mb-3">
                        <label for="tiempo" class="form-label">Tiempo (en minutos)</label>
                        <input type="number" id="tiempo" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label for="participantes" class="form-label">Número de participantes</label>
                        <input type="number" id="participantes" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label for="puntaje" class="form-label">Puntaje</label>
                        <input type="number" id="puntaje" class="form-control" required min="0">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Generar Código</button>
                    </div>
                </form>

                <div id="resultadoGenerado" class="mt-4 d-none">
                    <label class="form-label">Código generado:</label>
                    <div class="alert alert-success text-break" id="codigoResultadoGenerado"></div>
                </div>

                <div id="resultadoDesencriptado" class="mt-4 d-none">
                    <label class="form-label">Valores desencriptados:</label>
                    <ul class="list-group bg-dark text-light border border-secondary">
                        <li class="list-group-item bg-dark text-light">Tiempo: <span id="tiempoReal"></span></li>
                        <li class="list-group-item bg-dark text-light">Integrantes: <span id="integrantesReal"></span></li>
                        <li class="list-group-item bg-dark text-light">Puntaje: <span id="puntajeReal"></span></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
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

<!-- DataTables + Estilos -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#equiposTable').DataTable({
            order: [
                [1, 'asc']
            ], // 👈 Columna 1 (Fecha de Registro) en orden ascendente por defecto
            paging: true,
            searching: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron equipos",
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

<script>
    function generarCodigoAleatorio() {
        const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&*-+=';
        let resultado = '';
        const longitud = Math.floor(Math.random() * 8) + 8;
        for (let i = 0; i < longitud; i++) {
            resultado += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        }
        return resultado;
    }

    function codificarNumero(numero) {
        const base64 = btoa(numero.toString());
        const simbolo = generarCodigoAleatorio().substring(0, 2);
        return simbolo + base64;
    }

    function desencriptarNumero(encriptado) {
        const sinPrefijo = encriptado.slice(2);
        try {
            return atob(sinPrefijo);
        } catch (e) {
            return '[inválido]';
        }
    }

    function extraerDatosDesdeCodigo(codigoCompleto) {
        const matches = codigoCompleto.match(/"([^"]+)"/g);

        if (!matches || matches.length !== 3) {
            return {
                error: 'Formato inválido. No se encontraron 3 campos entre comillas dobles.'
            };
        }

        const tiempoCod = matches[0].replace(/"/g, '');
        const integrantesCod = matches[1].replace(/"/g, '');
        const puntajeCod = matches[2].replace(/"/g, '');

        return {
            tiempo: desencriptarNumero(tiempoCod),
            cantidad_integrantes: desencriptarNumero(integrantesCod),
            puntaje: desencriptarNumero(puntajeCod)
        };
    }

    document.getElementById('formGenerarManual').addEventListener('submit', function(e) {
        e.preventDefault();

        const participantes = document.getElementById('participantes').value;
        const tiempo = document.getElementById('tiempo').value;
        const puntaje = document.getElementById('puntaje').value;

        if (!participantes || !tiempo || !puntaje) return;

        const tiempoCod = codificarNumero(tiempo);
        const integrantesCod = codificarNumero(participantes);
        const puntajeCod = codificarNumero(puntaje);

        const pre = generarCodigoAleatorio();
        const mid1 = generarCodigoAleatorio().substring(0, 2);
        const mid2 = generarCodigoAleatorio().substring(0, 2);
        const post = generarCodigoAleatorio();

        const codigo = `${pre}"${tiempoCod}"${mid1}"${integrantesCod}"${mid2}"${puntajeCod}"${post}`;

        // Mostrar encriptado
        document.getElementById('codigoResultadoGenerado').textContent = codigo;
        document.getElementById('resultadoGenerado').classList.remove('d-none');

        // Mostrar desencriptado
        const datos = extraerDatosDesdeCodigo(codigo);
        if (!datos.error) {
            document.getElementById('tiempoReal').textContent = datos.tiempo;
            document.getElementById('integrantesReal').textContent = datos.cantidad_integrantes;
            document.getElementById('puntajeReal').textContent = datos.puntaje;
            document.getElementById('resultadoDesencriptado').classList.remove('d-none');
        }
    });
</script>


<?= $this->endSection() ?>