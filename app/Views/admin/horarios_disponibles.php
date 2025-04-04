<?php

// Vista: horarios_disponibles.php
// Muestra los horarios disponibles por sala y fecha
echo $this->extend('layouts/admin');
echo $this->section('content');
?>

<div class="container mt-5">
    <h2 class="text-light text-center mb-4">Consultar Horarios Disponibles</h2>

    <div class="card p-4 shadow rounded-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="sala_id" class="form-label fw-semibold">Sala</label>
                <select id="sala_id" class="form-select">
                    <option value="">Seleccione una sala</option>
                    <?php foreach ($salas as $sala): ?>
                        <option value="<?= $sala['id'] ?>"><?= esc($sala['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="fecha" class="form-label fw-semibold">Fecha</label>
                <input type="date" id="fecha" class="form-control">
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary w-100" onclick="consultarHorarios()">Consultar Horarios</button>
        </div>
    </div>

    <div class="mt-5" id="resultadoHorarios" style="display:none">
        <h5 class="text-light mb-3">Horarios Disponibles:</h5>
        <ul class="list-group" id="listaHorarios"></ul>
    </div>
</div>

<script>
function consultarHorarios() {
    const salaId = document.getElementById('sala_id').value;
    const fecha = document.getElementById('fecha').value;

    if (!salaId || !fecha) {
        alert('Seleccione una sala y una fecha.');
        return;
    }

    fetch(`/admin/horarios/disponibles?sala_id=${salaId}&fecha=${fecha}`)
        .then(res => res.json())
        .then(data => {
            const lista = document.getElementById('listaHorarios');
            lista.innerHTML = '';
            document.getElementById('resultadoHorarios').style.display = 'block';

            if (!data.horarios || data.horarios.length === 0) {
                lista.innerHTML = '<li class="list-group-item">No hay horarios activos para esta sala.</li>';
                return;
            }

            data.horarios.forEach(horario => {
                const ocupado = data.ocupados.includes(horario.id);
                const li = document.createElement('li');
                li.className = `list-group-item d-flex justify-content-between align-items-center ${ocupado ? 'list-group-item-danger' : 'list-group-item-success'}`;
                li.innerHTML = `${horario.hora} <span>${ocupado ? 'Ocupado' : 'Disponible'}</span>`;
                lista.appendChild(li);
            });
        })
        .catch(err => {
            console.error('Error al consultar:', err);
        });
}
</script>

<?php echo $this->endSection(); ?>
