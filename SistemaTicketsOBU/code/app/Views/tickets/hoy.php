<?= $this->include('Layout/header') ?>
<?= $this->include('Layout/aside') ?>

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
              <h4 class="card-title mb-3">👤 <?= esc(session('full_name')) ?></h4>
              <p><i class="fa fa-id-badge"></i> <strong>Código:</strong> <?= esc(session('university_code')) ?></p>
              <p><i class="fa fa-graduation-cap"></i> <strong>Becado:</strong> <?= session('is_scholarship') ? 'Sí' : 'No' ?></p>

              <?php if (!empty($ticket)): ?>
                <div class="alert alert-success text-start mt-4">
                  <h5><i class="fa fa-check-circle"></i> Ticket Registrado</h5>
                  <p><strong>Tipo de comida:</strong> <?= esc($ticket['tipo_comida_id']) ?></p>
                  <p><strong>Fecha:</strong> <?= esc($ticket['fecha']) ?></p>
                  <p><strong>Estado:</strong> <?= esc($ticket['estado']) ?></p>
                  <a href="<?= base_url('ticket/pdf/' . $ticket['id']) ?>" class="btn btn-outline-primary mt-2" target="_blank">
                    Ver Ticket PDF
                  </a>
                </div>
              <?php else: ?>
                <div class="alert alert-warning mt-4">
                  No tienes ticket generado para hoy.
                </div>

                <button class="btn btn-success btn-lg mt-3 shadow-sm rounded-pill px-4" id="btnRegistrarTicket">
                  <i class="fa fa-check-circle"></i> Registrar Ticket
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
<div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content text-center">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">✅ Registrado con Éxito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button class="btn btn-default" data-dismiss="modal">Cerrar</button>
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

<?= $this->include('Layout/footer') ?>

<!-- Scripts Bootstrap 3 -->
<script src="<?= base_url(); ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url(); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function () {
    $("#btnRegistrarTicket").click(function () {
      $.ajax({
        url: "<?= base_url('TicketEstudiante/registrar') ?>",
        type: "POST",
        dataType: "json",
        success: function (response) {
          if (response.status === 'ok') {
            $("#modalNombre").text(response.nombre);
            $("#modalCodigo").text(response.codigo);
            $("#modalFecha").text(response.fecha);
            $("#modalTipo").text(response.tipo == 1 ? "Desayuno" : response.tipo);
            $("#nroOrden").text(response.nro_orden);
            $("#qrImagen").attr('src', response.codigo_qr);
            $("#modalConfirmacion").modal('show');
          } else {
            $("#mensajeError").text(response.mensaje);
            $("#modalError").modal('show');
          }
        },
        error: function (xhr, status, error) {
          console.log("🔴 Error:", error);
          $("#mensajeError").text("Error inesperado. Intenta nuevamente.");
          $("#modalError").modal('show');
        }
      });
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

