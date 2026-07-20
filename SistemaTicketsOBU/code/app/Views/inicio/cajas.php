<?php
$nombreCompleto = session('full_name');
$codigoUniversitario = session('university_code');
$becado = session('is_scholarship') ? 'Sí' : 'No';

$platoDia = isset($plato) ? $plato['descripcion'] : null;
$turno = $turnoNombre ?? null;
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

  /* Fecha/hora destacada: dos tamaños más grande y en negrita */
  .content-header .fecha-hora {
    font-size: 1.6rem;
    font-weight: 700;
    color: #444 !important;
  }

  .custom-card p,
  .custom-card small {
    font-size: 1.2rem;
  }

  .custom-card strong {
    font-weight: 700;
  }

  .custom-card .card-header small {
    font-size: 1.1rem;
  }

  .custom-card .card-body p {
    font-size: 1.35rem;
    font-weight: 700;
  }

  .custom-card .label {
    font-size: 1.05rem;
  }

  .custom-card {
    border-radius: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    padding: 28px 24px;
    box-sizing: border-box;
  }

  .custom-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.12);
  }

  /* La tarjeta "Plato del Día" trae su propio header a todo el ancho:
     se compensa el padding del padre para que siga llegando al borde. */
  .custom-card .card-header {
    margin: -28px -24px 20px -24px;
    padding: 16px 20px !important;
  }

  .custom-card .card-body {
    padding: 4px 0 0 !important;
  }

  .custom-card h5 {
    margin-top: 0;
    margin-bottom: 16px;
  }

  .custom-card p {
    margin-bottom: 12px;
  }

  .custom-card .btn,
  .custom-card button {
    margin-top: 8px;
    margin-bottom: 8px;
  }

  .avatar-circle {
    width: 80px;
    height: 80px;
    background-color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
  }

  .avatar-circle--letter {
    font-size: 36px;
    font-weight: bold;
  }

  /* Espacio entre tarjetas cuando el grid de Bootstrap 3 las apila en pantallas chicas */
  .content .row > [class*="col-"] {
    margin-bottom: 24px;
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

  @media (max-width: 767px) {
    .welcome-banner {
      padding: 20px 16px;
      margin-bottom: 24px;
    }

    .welcome-banner h2 {
      font-size: 1.4rem;
    }

    .custom-card {
      padding: 20px 16px;
    }

    .custom-card .card-header {
      margin: -20px -16px 16px -16px;
    }

    .avatar-circle {
      width: 64px;
      height: 64px;
    }

    .avatar-circle--letter {
      font-size: 28px;
    }

    .btn-rounded {
      padding: 10px 18px;
      font-size: 14px;
    }
  }
</style>

<div class="content-wrapper">
  <section class="content-header text-center mb-4">
    <h2 class="mb-2">👋 ¡Bienvenido(a), <strong><?= esc($nombreCompleto) ?></strong>!</h2>
    <p class="text-muted fecha-hora">Hoy es <?= esc($fecha) ?> — <?= esc($hora) ?></p>
  </section>

  <section class="content">
    <div class="container">
      <div class="row g-4 justify-content-center">
  <!-- Fila superior: Estudiante + Plato del Día -->
  <div class="col-md-6">
    <div class="card custom-card shadow h-100 text-center p-4" style="background: linear-gradient(135deg, #89f7fe, #66a6ff); color: #1b1b1b; border: none; border-radius: 20px;">
      <div class="mb-3">
        <div class="avatar-circle avatar-circle--letter">
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
        <small><strong>Turno:</strong> <?= esc($turno ?? 'Sin servicio en este momento') ?></small>
      </div>
      <div class="card-body px-4 py-3">
        <?php if ($turno === null): ?>
          <p class="text-dark mb-0">Fuera de horario de atención. Turnos: Desayuno 7:00–9:30, Almuerzo 12:00–14:00, Cena 17:00–19:00 (lunes a viernes).</p>
        <?php elseif ($platoDia === null): ?>
          <p class="text-dark mb-0">Aún no se cargó el menú de <?= esc($turno) ?> para hoy.</p>
        <?php else: ?>
          <p class="lead mb-1"><strong>Menú:</strong></p>
          <p class="text-dark"><?= esc($platoDia) ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Fila inferior: Descargar ticket centrado -->
  <div class="col-md-10">
    <div class="card custom-card shadow h-100 text-center p-4 d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, #f6d365, #fda085); color: #2d2d2d; border: none; border-radius: 20px;">
      <div class="mb-3">
        <div class="avatar-circle">
          <i class="fa fa-ticket fa-2x text-danger"></i>
        </div>
      </div>
      <h5 class="fw-bold mb-3">Tu Ticket</h5>
      <?php if (!empty($ticket)): ?>
        <span class="label label-success">Disponible</span><br><br>
        <a href="<?= base_url('ticket/pdf/' . $ticket['id']) ?>" class="btn btn-danger btn-rounded shadow-sm px-4 py-2" target="_blank">
          <i class="fa fa-download"></i> Descargar PDF
        </a>
      <?php else: ?>
        <button class="btn btn-secondary btn-rounded shadow-sm px-4 py-2 mt-3" disabled>
          <i class="fa fa-ban"></i> No disponible
        </button>
        <p class="text-dark mt-3 mb-0">
          <small>
            <?= $turno === null
              ? 'Fuera de horario de atención.'
              : 'Ve a "Mi Ticket de Hoy" para reservar tu ticket de ' . esc($turno) . '.' ?>
          </small>
        </p>
      <?php endif; ?>
    </div>
  </div>
</div>

    </div>
  </section>
</div>
