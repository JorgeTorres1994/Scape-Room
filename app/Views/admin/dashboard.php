<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h2 class="text-center my-4">Dashboard - Panel de Control</h2>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card bg-primary text-white text-center card-dashboard">
                <div class="card-body">
                    <h3><?= $totalSalas ?></h3>
                    <p>Salas Activas</p>
                </div>
            </div>
        </div>

        <!-- <div class="col-md-2">
            <div class="card bg-success text-white text-center card-dashboard">
                <div class="card-body">
                    <h3><= $totalReservas ?></h3>
                    <p>Reservas Totales</p>
                </div>
            </div>
        </div> -->

        <!-- <div class="col-md-2">
            <div class="card bg-info text-white text-center card-dashboard">
                <div class="card-body">
                    <h3><= $totalUsuarios ?></h3>
                    <p>Usuarios Registrados</p>
                </div>
            </div>
        </div> -->

        <!-- <div class="col-md-2">
            <div class="card bg-warning text-dark text-center card-dashboard">
                <div class="card-body">
                    <h3><= $totalCalificaciones ?></h3>
                    <p>Calificaciones Totales</p>
                </div>
            </div>
        </div> -->

       <!-- <div class="col-md-2">
            <div class="card bg-danger text-white text-center card-dashboard">
                <div class="card-body">
                    <h3><= $promedioCalificaciones ?></h3>
                    <p>Prom. Calificación</p>
                </div>
            </div>
        </div> -->
    </div>
</div>

<h3 class="mt-5 text-center">Reservas por Mes</h3>
<canvas id="chartReservas"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('chartReservas').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Reservas Realizadas',
                data: [12, 19, 8, 15, 20], // Puedes reemplazar por datos reales
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });
</script>

<style>
    .card-dashboard {
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        border-radius: 10px;
        color: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        margin-bottom: 15px;
    }

    .card-dashboard h3 {
        font-size: 22px;
        margin-bottom: 5px;
    }

    .card-dashboard p {
        font-size: 14px;
        margin: 0;
    }

    @media (max-width: 992px) {
        .card-dashboard {
            height: 110px;
        }
    }

    @media (max-width: 768px) {
        .card-dashboard {
            height: 120px;
        }
    }
</style>

<?= $this->endSection() ?>
