<?= $this->include('layout/header') ?>
<?= $this->include('layout/aside') ?>

<div class="content-wrapper">
  <section class="content-header text-center mb-4">
    <?php date_default_timezone_set('America/Lima'); ?>
    <h2 class="mb-2">🎟️ Mi Ticket de Hoy</h2>
    <p class="text-muted">Fecha: <?= date('d/m/Y') ?> — <?= date('h:i A') ?></p>
  </section>

  <section class="content">
    <div class="container">
      <div class="row justify-content-center">

        <div class="col-md-6">
          <div class="card custom-card shadow text-center">
            <div class="card-body">
              <h4 class="card-title mb-3">🎟️ Ticket de Hoy</h4>

              <?php if (empty($turnoNombre)): ?>
                <div class="alert alert-secondary mt-4">
                  <i class="fa fa-clock-o"></i> Fuera de horario de atención. Turnos: Desayuno 7:00–9:30, Almuerzo 12:00–14:00, Cena 17:00–19:00 (lunes a viernes).
                </div>
              <?php elseif (!empty($ticket)): ?>
                <div class="alert alert-success text-start mt-4">
                  <h5><i class="fa fa-check-circle"></i> Ticket Registrado — <?= esc($turnoNombre) ?></h5>
                  <p><i class="fa fa-user"></i> <strong>Estudiante:</strong> <?= esc(session('full_name')) ?></p>
                  <p><i class="fa fa-id-badge"></i> <strong>Código:</strong> <?= esc(session('university_code')) ?></p>
                  <p><strong>Fecha:</strong> <?= esc($ticket['fecha']) ?></p>
                  <p><strong>Estado:</strong> <?= esc($ticket['estado']) ?></p>
                  <a href="<?= base_url('ticket/pdf/' . $ticket['id']) ?>" class="btn btn-outline-primary mt-2" target="_blank">
                    Ver Ticket PDF
                  </a>
                </div>
              <?php else: ?>
                <div class="alert alert-warning mt-4">
                  Turno actual: <strong><?= esc($turnoNombre) ?></strong>. No tienes ticket generado todavía.
                </div>

                <button class="btn btn-success btn-lg mt-3 shadow-sm rounded-pill px-4" id="btnRegistrarTicket">
                  <i class="fa fa-check-circle"></i> Registrar Ticket de <?= esc($turnoNombre) ?>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<!-- Modal de Confirmación (Éxito) -->
<div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content text-center">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">✅ Registrado con Éxito</h5>
      </div>
      <div class="modal-body">
        <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
        <p><strong>Código:</strong> <span id="modalCodigo"></span></p>
        <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
        <p><strong>Tipo de comida:</strong> <span id="modalTipo"></span></p>
        <hr>
        <p><strong>Número de Orden:</strong></p>
        <h2 id="nroOrden" class="text-success">--</h2>
        <img id="qrImagen" src="" class="img img-responsive center-block mt-3" style="max-width: 200px;" alt="Código QR">
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="btnCerrarConfirmacion">Listo</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Error -->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content text-center">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">❌ Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="mensajeError" class="text-danger"><strong>Ocurrió un error.</strong></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<?= $this->include('layout/footer') ?>

<!-- Scripts Bootstrap 3 -->
<script src="<?= base_url(); ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url(); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function () {
    $("#btnRegistrarTicket").click(function () {
      var $btn = $(this);
      $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Registrando...');

      $.ajax({
        url: "<?= base_url('TicketEstudiante/registrar') ?>",
        type: "POST",
        dataType: "json",
        data: { "<?= csrf_token() ?>": "<?= csrf_hash() ?>" },
        success: function (response) {
          if (response.status === 'ok') {
            $("#modalNombre").text(response.nombre);
            $("#modalCodigo").text(response.codigo);
            $("#modalFecha").text(response.fecha);
            $("#modalTipo").text(response.tipo_nombre);
            $("#nroOrden").text(response.nro_orden);
            $("#qrImagen").attr('src', response.codigo_qr);
            $("#modalConfirmacion").modal('show');
          } else {
            $btn.prop("disabled", false).html('<i class="fa fa-check-circle"></i> Registrar Ticket de <?= esc($turnoNombre) ?>');
            $("#mensajeError").text(response.mensaje);
            $("#modalError").modal('show');
          }
        },
        error: function (xhr, status, error) {
          console.log("🔴 Error:", error);
          $btn.prop("disabled", false).html('<i class="fa fa-check-circle"></i> Registrar Ticket de <?= esc($turnoNombre) ?>');
          $("#mensajeError").text("Error inesperado. Intenta nuevamente.");
          $("#modalError").modal('show');
        }
      });
    });

    $("#btnCerrarConfirmacion").click(function () {
      location.reload();
    });
  });
</script>

<style>
  .custom-card {
    border-radius: 20px;
    padding: 20px;
    transition: 0.3s;
  }

  .custom-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
  }

  #nroOrden {
    font-size: 2.2rem;
    font-weight: bold;
  }

  .modal-header {
    background-color: #3c8dbc;
    color: white;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .modal-content {
    border-radius: 10px;
  }

  .btn-close {
    background: none;
    border: none;
    font-size: 20px;
    line-height: 1;
    color: white;
    opacity: 0.9;
  }
</style>

