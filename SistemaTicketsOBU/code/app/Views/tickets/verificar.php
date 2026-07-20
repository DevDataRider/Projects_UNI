<div class="content-wrapper">
  <section class="content-header text-center">
    <h1>Verificación de Ticket</h1>
  </section>

  <section class="content">
    <div class="row justify-content-center">
      <div class="col-md-6 col-md-offset-3">
        <div class="box box-solid <?= $ticket['estado'] === 'anulado' ? 'box-danger' : 'box-primary' ?>">
          <div class="box-body text-center" style="padding: 30px;">

            <?php if ($ticket['estado'] === 'anulado'): ?>
              <div class="alert alert-danger">
                <strong><i class="fa fa-times-circle"></i> Ticket anulado.</strong> No es válido para entrega.
              </div>
            <?php elseif ($ticket['estado'] === 'usado'): ?>
              <div class="alert alert-warning">
                <strong><i class="fa fa-info-circle"></i> Este ticket ya fue entregado.</strong>
              </div>
            <?php endif; ?>

            <h2 style="font-size: 3rem; font-weight: bold; margin: 0;">N° <?= esc($nroOrden) ?></h2>
            <p class="text-muted">Número de orden</p>

            <hr>

            <p style="font-size: 1.3rem;"><i class="fa fa-user"></i> <strong><?= esc($ticket['full_name']) ?></strong></p>
            <p style="font-size: 1.1rem;"><i class="fa fa-graduation-cap"></i> <?= esc($ticket['facultad']) ?: 'Facultad no especificada' ?></p>
            <p class="text-muted"><i class="fa fa-cutlery"></i> <?= esc($turnoNombre) ?> &mdash; <i class="fa fa-calendar"></i> <?= esc($ticket['fecha']) ?></p>

            <?php if ($ticket['estado'] === 'pendiente'): ?>
              <form method="post" action="<?= base_url('asistencias/insertar') ?>" class="mt-3">
                <?= csrf_field() ?>
                <input type="hidden" name="ticket_id" value="<?= esc($ticket['id']) ?>">
                <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('¿Confirmar entrega de este ticket?')">
                  <i class="fa fa-check"></i> Confirmar entrega
                </button>
              </form>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
