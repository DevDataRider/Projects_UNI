<?php
$totalEstudiantes  = count($estudiantes);
$totalPlatos       = count($platos);
$totalAsistencias  = isset($asistencias) ? count($asistencias) : 0;
$totalIncidencias  = isset($incidencias) ? count($incidencias) : 0;
$totalActividad    = isset($actividad) ? count($actividad) : 0;
$totalTickets      = isset($tickets) ? count($tickets) : 0;
?>

<style>
  .contenedor-panel {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
  }

  .card-panel {
    flex: 1 1 calc(33.333% - 20px);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center;
    color: white;
  }

  .estudiantes  { background-color: #3F51B5; }
  .platos       { background-color: #4CAF50; }
  .tickets      { background-color: #2196F3; }
  .asistencias  { background-color: #FF9800; }
  .incidencias  { background-color: #F44336; }
  .actividad    { background-color: #9C27B0; }

  .card-panel a.btn-link {
    color: #fff;
    font-weight: bold;
    text-decoration: underline;
    margin-top: 10px;
    display: inline-block;
  }

  .card-panel h2 {
    font-size: 3.5rem;
    font-style: italic;
  
    margin-bottom: 10px;
    color: white;
  }

  .card-panel p {
    font-size: 2.1rem;
    margin-bottom: 5px;
    color: white;
  }

  .charts-container {
    display: flex;
    gap: 20px;
    margin: 0 37px;
    margin-top: -20px;
    margin-bottom: 40px;
    flex-wrap: wrap;
  }

  .chart-box {
    flex: 1;
    min-width: 280px;
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    text-align: center;
  }

  @media (max-width: 768px) {
    .card-panel {
      flex: 1 1 100%;
    }
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Panel Administrativo <small>Resumen del sistema del comedor</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Panel</li>
    </ol>
  </section>

  <section class="content">
    <div class="contenedor-panel">
      <div class="card-panel estudiantes">
        <h2><?= $totalEstudiantes ?></h2>
        <p>Estudiantes Registrados</p>
        <a href="<?= base_url('estudiantes') ?>" class="btn btn-link">Ver más</a>
      </div>
      <div class="card-panel platos">
        <h2><?= $totalPlatos ?></h2>
        <p>Platos del Día</p>
        <a href="<?= base_url('platos') ?>" class="btn btn-link">Ver más</a>
      </div>
      <div class="card-panel tickets">
        <h2><?= $totalTickets ?></h2>
        <p>Tickets Generados</p>
        <a href="<?= base_url('tickets') ?>" class="btn btn-link">Ver más</a>
      </div>
      <div class="card-panel asistencias">
        <h2><?= $totalAsistencias ?></h2>
        <p>Asistencias</p>
        <a href="<?= base_url('asistencias') ?>" class="btn btn-link">Ver más</a>
      </div>
      <div class="card-panel incidencias">
        <h2><?= $totalIncidencias ?></h2>
        <p>Incidencias Reportadas</p>
        <a href="<?= base_url('incidencias') ?>" class="btn btn-link">Ver más</a>
      </div>
      <div class="card-panel actividad">
        <h2><?= $totalActividad ?></h2>
        <p>Actividad Estudiantil</p>
        <a href="<?= base_url('actividades') ?>" class="btn btn-link">Ver más</a>
      </div>
    </div>

    <div class="charts-container">
      <div class="chart-box">
        <h3 style="margin-bottom: 20px;">Gráfico de Estadísticas</h3>
        <canvas id="graficoTickets" height="200"></canvas>
      </div>
      <div class="chart-box">
        <h3 style="margin-bottom: 20px;">Distribución de Becados</h3>
        <canvas id="becadosChart" height="200"></canvas>
      </div>
      <div class="chart-box">
        <h3 style="margin-bottom: 20px;">Tendencia de Tickets</h3>
        <canvas id="lineChart" height="200"></canvas>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const dataTickets = {
    labels: ['Estudiantes', 'Platos', 'Tickets', 'Asistencias', 'Incidencias', 'Actividad'],
    datasets: [{
      label: 'Estadísticas generales',
      data: [
        <?= $totalEstudiantes ?>,
        <?= $totalPlatos ?>,
        <?= $totalTickets ?>,
        <?= $totalAsistencias ?>,
        <?= $totalIncidencias ?>,
        <?= $totalActividad ?>
      ],
      backgroundColor: [
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 99, 132, 0.7)',
        'rgba(100, 200, 100, 0.7)'
      ],
      borderWidth: 1
    }]
  };

  new Chart(document.getElementById('graficoTickets'), {
    type: 'bar',
    data: dataTickets,
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 }
        }
      }
    }
  });

  new Chart(document.getElementById('becadosChart').getContext('2d'), {
    type: 'doughnut',
    data: {
      labels: ['Becados', 'No Becados'],
      datasets: [{
        data: [<?= $total_becados ?>, <?= $total_no_becados ?>],
        backgroundColor: ['#4CAF50', '#F44336'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#333',
            font: { size: 14 }
          }
        }
      }
    }
  });

  new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
      labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'],
      datasets: [{
        label: 'Tickets por día',
        data: [2200, 2140, 1800, 1230, 2204],
        borderColor: 'rgba(54, 162, 235, 0.8)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        tension: 0.3,
        fill: true,
        pointRadius: 5,
        pointHoverRadius: 8,
        pointBackgroundColor: 'rgba(54, 162, 235, 1)',
        pointHoverBackgroundColor: 'rgba(255, 99, 132, 1)',
        pointBorderColor: '#fff',
        pointHoverBorderColor: '#000'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        tooltip: {
          enabled: true,
          mode: 'index',
          intersect: false
        }
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 }
        }
      }
    }
  });
</script>
