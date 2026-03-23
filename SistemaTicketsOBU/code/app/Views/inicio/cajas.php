<?php
$nombreCompleto = session('full_name');
$codigoUniversitario = session('university_code');
$becado = session('is_scholarship') ? 'Sí' : 'No';

$platoDia = isset($plato) ? $plato['descripcion'] : 'Arroz chaufa de pollo con salsa de soja y té helado';
$turno = isset($plato) ? ucfirst($plato['turno']) : 'Almuerzo';
date_default_timezone_set('America/Lima');
$fecha = date('d/m/Y');
$hora = date('h:i A');
?>

<style>


  .welcome-banner {
    background: linear-gradient(90deg, #00b4db, #0083b0);
    color: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    margin-bottom: 40px;
    text-align: center;
  }

  .welcome-banner h2 {
    font-size: 2rem;
    margin-bottom: 10px;
  }

  .welcome-banner p {
    font-size: 1.1rem;
  }

  .custom-card {
    border-radius: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
  }

  .custom-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.12);
  }

  .custom-icon {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, #f7971e, #ffd200);
    color: white;
    font-size: 40px;
    line-height: 90px;
    border-radius: 50%;
    margin: 0 auto 20px;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  }

  .card-header-custom {
    background: #17a2b8;
    color: white;
    border-radius: 20px 20px 0 0;
    padding: 15px;
  }

  .btn-rounded {
    border-radius: 30px;
    padding: 12px 25px;
    font-weight: 600;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  .btn-danger:hover {
    background-color: #c82333;
  }

  .btn-secondary:disabled {
    background-color: #ccc;
    border-color: #ccc;
  }
  
</style>

<div class="content-wrapper">
  <section class="content-header text-center mb-4">
    <h2 class="mb-2">👋 ¡Bienvenido(a), <strong><?= esc($nombreCompleto) ?></strong>!</h2>
    <p class="text-muted">Hoy es <?= esc($fecha) ?> — <?= esc($hora) ?></p>
  </section>

  <section class="content">
    <div class="container">
      <div class="row g-4 justify-content-center">
  <!-- Fila superior: Estudiante + Plato del Día -->
  <div class="col-md-6">
    <div class="card custom-card shadow h-100 text-center p-4" style="background: linear-gradient(135deg, #89f7fe, #66a6ff); color: #1b1b1b; border: none; border-radius: 20px;">
      <div class="mb-3">
        <div style="width: 80px; height: 80px; background-color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: bold; margin: 0 auto; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
          <?= strtoupper(substr($nombreCompleto, 0, 1)) ?>
        </div>
      </div>
      <h5 class="fw-bold mb-3">Estudiante</h5>
      <p class="mb-2">
        <i class="fa fa-id-badge me-2"></i><strong>Código:</strong><br><?= esc($codigoUniversitario) ?>
      </p>
      <p>
        <i class="fa fa-graduation-cap me-2"></i><strong>Becado:</strong><br><?= esc($becado) ?>
      </p>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card custom-card shadow h-100 text-center" style="background: linear-gradient(135deg, #fddb92, #d1fdff); border: none; border-radius: 20px;">
      <div class="card-header text-white" style="background-color: #17a2b8; border-top-left-radius: 20px; border-top-right-radius: 20px; padding: 12px;">
        <h5 class="mb-1">🍽️ Plato del Día</h5>
        <small><strong>Turno:</strong> <?= esc($turno) ?></small>
      </div>
      <div class="card-body px-4 py-3">
        <p class="lead mb-1"><strong>Menú:</strong></p>
        <p class="text-dark"><?= esc($platoDia) ?></p>
      </div>
    </div>
  </div>

  <!-- Fila inferior: Descargar ticket centrado -->
  <div class="col-md-10">
    <div class="card custom-card shadow h-100 text-center p-4 d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, #f6d365, #fda085); color: #2d2d2d; border: none; border-radius: 20px;">
      <div class="mb-3">
        <div style="width: 80px; height: 80px; background-color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin: 0 auto;">
          <i class="fa fa-ticket fa-2x text-danger"></i>
        </div>
      </div>
      <h5 class="fw-bold mb-3">Tu Ticket</h5>
      <?php if (!empty($ticket)): ?>
        <a href="<?= base_url('ticket/pdf/' . $ticket['id']) ?>" class="btn btn-danger btn-rounded shadow-sm px-4 py-2">
          <i class="fa fa-download"></i> Descargar PDF
        </a>
      <?php else: ?>
        <button class="btn btn-secondary btn-rounded shadow-sm px-4 py-2" disabled>
          <i class="fa fa-ban"></i> No disponible
        </button>
        <p class="text-dark mt-3 mb-0"><small>Debes registrar tu ticket para poder descargarlo.</small></p>
      <?php endif; ?>
    </div>
  </div>
</div>

      
    </div>
  </section>
</div>
