<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Tables
      <small>Asistencias</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Tablas</a></li>
      <li class="active">Asistencias</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarAsistencia">Registrar Asistencia</button>

        <a class="btn btn-info" target="_blank" href="<?= base_url(); ?>Reportes/PDFAsistencias">Imprimir PDF</a>
        <a class="btn btn-success" download href="<?= base_url(); ?>Reportes/ExcelAsistencias">Exportar Excel</a>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped tablas">
          <thead>
            <tr>
              <th>#</th>
              <th>Estudiante</th>
              <th>Fecha Ticket</th>
              <th>Tipo Comida</th>
              <th>Estado Ticket</th>
              <th>Fecha Ingreso</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($asistencias as $key => $a): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= esc($a['full_name']) ?></td>
                <td><?= esc($a['fecha']) ?></td>
                <td>
                  <?php
                    switch ($a['tipo_comida_id']) {
                      case 1: echo 'Desayuno'; break;
                      case 2: echo 'Almuerzo'; break;
                      case 3: echo 'Cena'; break;
                      default: echo 'Desconocido';
                    }
                  ?>
                </td>
                <td><?= esc($a['estado_ticket']) ?></td>
                <td><?= esc($a['fecha_ingreso']) ?></td>
                <td>
                  <button class="btn btn-primary btnEditarAsistencia"
                    data-id="<?= $a['id'] ?>"
                    data-fecha="<?= $a['fecha_ingreso'] ?>"
                    data-toggle="modal" data-target="#modalEditarAsistencia">
                    <i class="fa fa-pencil"></i>
                  </button>

                  <a href="<?= base_url('asistencias/eliminar/' . $a['id']) ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta asistencia?')">
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

<!-- Modal Agregar Asistencia -->
<div id="modalAgregarAsistencia" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formAgregarAsistencia" method="post" action="<?= base_url('asistencias/insertar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registrar Asistencia</h4>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Ticket</label>
            <select name="ticket_id" class="form-control" required>
              <option value="">-- Seleccionar Ticket --</option>
              <?php foreach ($tickets as $t): ?>
                <option value="<?= $t['id'] ?>">
                  <?= esc($t['full_name'] . ' - ' . $t['fecha'] . ' - ' . 
                    (($t['tipo_comida_id'] == 1) ? 'Desayuno' : (($t['tipo_comida_id'] == 2) ? 'Almuerzo' : 'Cena'))
                  ) ?>
                </option>
              <?php endforeach; ?>
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

<!-- Modal Editar Asistencia -->
<div id="modalEditarAsistencia" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarAsistencia" method="post" action="<?= base_url('asistencias/editar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Asistencia</h4>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="editarAsistenciaId">
          <div class="form-group">
            <label>Fecha Ingreso</label>
            <input type="datetime-local" name="fecha_ingreso" id="editarFechaIngreso" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $(document).on("click", ".btnEditarAsistencia", function() {
    $("#editarAsistenciaId").val($(this).data("id"));
    $("#editarFechaIngreso").val($(this).data("fecha"));
  });

  $("#formAgregarAsistencia").submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function(response) {
        $("#modalAgregarAsistencia").modal("hide");
        mostrarModal("Asistencia registrada exitosamente");
        setTimeout(() => location.reload(), 1000);
      },
      error: function() {
        mostrarModal("Error al registrar asistencia");
      }
    });
  });

  $("#formEditarAsistencia").submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function(response) {
        $("#modalEditarAsistencia").modal("hide");
        mostrarModal("Asistencia actualizada");
        setTimeout(() => location.reload(), 1000);
      },
      error: function() {
        mostrarModal("Error al actualizar asistencia");
      }
    });
  });

  function mostrarModal(mensaje) {
    $("#modalMensaje .modal-body").text(mensaje);
    $("#modalMensaje").modal("show");
  }
});
</script>

<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center"></div>
    </div>
  </div>
</div>
