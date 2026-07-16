<div class="content-wrapper">
  <section class="content-header">
    <h1>Data Tables <small>Tickets</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Tablas</a></li>
      <li class="active">Tickets</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border display">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarTicket">
          Generar Ticket
        </button>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px;">#</th>
              <th>Estudiante</th>
              <th>Fecha</th>
              <th>Tipo de Comida</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tickets as $key => $t): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= esc($t['full_name']) ?></td>
                <td><?= esc($t['fecha']) ?></td>
                <td>
                <?php
                    switch ($t['tipo_comida_id']) {
                    case 1: echo 'Desayuno'; break;
                    case 2: echo 'Almuerzo'; break;
                    case 3: echo 'Cena'; break;
                    default: echo 'Desconocido';
                    }
                ?>
                </td>
                <td><?= esc($t['estado']) ?></td>
                <td>
                  <a href="<?= base_url('tickets/eliminar/' . $t['id']) ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este ticket?')">
                    <i class="fa fa-times"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- Modal Agregar Ticket -->
<div id="modalAgregarTicket" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formAgregarTicket" method="post" action="<?= base_url('tickets/insertar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Generar Ticket</h4>
        </div>
        <div class="modal-body">
          <div class="form-group"><label>Estudiante ID</label><input type="number" name="student_id" class="form-control" required></div>
          <div class="form-group"><label>Fecha</label><input type="date" name="fecha" class="form-control" required></div>
          <div class="form-group">
            <label>Tipo de Comida</label>
            <select name="tipo_comida_id" class="form-control" required>
              <option value="">-- Seleccionar --</option>
              <option value="1">Desayuno</option>
              <option value="2">Almuerzo</option>
              <option value="3">Cena</option>
            </select>
          </div>
          <div class="form-group">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
              <option value="pendiente">Pendiente</option>
              <option value="generado">Generado</option>
              <option value="generado">Usado</option>

            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal de Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <!-- Aquí se mostrará el mensaje dinámicamente -->
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $("#formAgregarTicket").submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function(response) {
        $("#modalAgregarTicket").modal("hide");
        mostrarModal("Ticket generado exitosamente");
        setTimeout(() => location.reload(), 1200);
      },
      error: function() {
        mostrarModal("Error al generar ticket");
      }
    });
  });

  function mostrarModal(mensaje) {
    $("#modalMensaje .modal-body").text(mensaje);
    $("#modalMensaje").modal("show");
  }
});
</script>
