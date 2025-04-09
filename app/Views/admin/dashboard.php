<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h2 class="text-center my-4">Dashboard - Panel de Control</h2>

<div class="container">
    <div class="row justify-content-center text-white">
        <div class="col-md-2">
            <div class="card bg-primary text-center card-dashboard">
                <div class="card-body">
                    <h3><?= $totalSalas ?></h3>
                    <p>Salas Activas</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card bg-success text-center card-dashboard">
                <div class="card-body">
                    <h3><?= $totalReservas ?></h3>
                    <p>Reservas Realizadas</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card bg-info text-center card-dashboard">
                <div class="card-body">
                    <h3><?= $totalClientes ?></h3>
                    <p>Clientes</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card bg-warning text-dark text-center card-dashboard">
                <div class="card-body">
                    <h3><?= $totalEquipos ?></h3>
                    <p>Equipos</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card bg-danger text-center card-dashboard">
                <div class="card-body">
                    <h3><?= $totalRankings ?></h3>
                    <p>Rankings</p>
                </div>
            </div>
        </div>
    </div>
</div>

<h3 class="mt-5 text-center">📊 Reservas por Mes</h3>
<canvas id="chartReservas" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartReservas').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Reservas Realizadas',
                data: <?= json_encode($valores) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
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