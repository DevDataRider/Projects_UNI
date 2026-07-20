<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Historial de Consumo
      <small>Visualiza los tickets que has generado</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('TicketEstudiante') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Historial de Consumo</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Mis Tickets Generados</h3>
      </div>

      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Tipo de Comida</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($tickets)): ?>
              <?php foreach ($tickets as $index => $ticket): ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= date('d-m-Y', strtotime($ticket['fecha'])) ?></td>
                  <td><?= date('h:i A', strtotime($ticket['created_at'])) ?></td>
                  <td><?= esc(\App\Libraries\HorarioComedor::nombre((int) $ticket['tipo_comida_id']) ?? 'Desconocido') ?></td>
                  <td>
                    <?php if ($ticket['estado'] == 'pendiente'): ?>
                      <span class="label label-warning">Pendiente</span>
                    <?php elseif ($ticket['estado'] == 'usado'): ?>
                      <span class="label label-success">Usado</span>
                    <?php elseif ($ticket['estado'] == 'anulado'): ?>
                      <span class="label label-danger">Anulado</span>
                    <?php else: ?>
                      <span class="label label-default"><?= esc($ticket['estado']) ?></span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <a href="<?= base_url('TicketEstudiante/pdf/'.$ticket['id']) ?>" class="btn btn-sm btn-danger" target="_blank">
                      <i class="fa fa-file-pdf-o"></i> Descargar
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">No tienes tickets generados aún.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
