<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Tables
      <small>Actividades de Estudiantes</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Tablas</a></li>
      <li class="active">Actividades</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarActividad">
          Registrar Actividad
        </button>

        <a class="btn btn-info" target="_blank" href="<?= base_url(); ?>Reportes/PDFActividades">Imprimir PDF</a>
        <a class="btn btn-success" download href="<?= base_url(); ?>Reportes/ExcelActividades">Exportar Excel</a>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped tablas">
          <thead>
            <tr>
              <th>#</th>
              <th>Estudiante</th>
              <th>Acción</th>
              <th>Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>
          

          <tbody>
            <?php foreach ($actividades as $key => $a): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= esc($a['full_name']) ?></td>
                <td><?= esc($a['accion']) ?></td>
                <td><?= esc($a['fecha']) ?></td>
                <td>
                  <button class="btn btn-primary btnEditarActividad"
                    data-id="<?= $a['id'] ?>"
                    data-accion="<?= esc($a['accion']) ?>"
                    data-fecha="<?= $a['fecha'] ?>"
                    data-toggle="modal" data-target="#modalEditarActividad">
                    <i class="fa fa-pencil"></i>
                  </button>

                  <a href="<?= base_url('actividades/eliminar/' . $a['id']) ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta actividad?')">
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

<!-- Modal Agregar Actividad -->
<div id="modalAgregarActividad" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formAgregarActividad" method="post" action="<?= base_url('actividades/insertar') ?>">
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registrar Actividad</h4>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Estudiante</label>
            <select name="student_id" class="form-control" required>
              <option value="">-- Seleccionar Estudiante --</option>
              <?php foreach ($estudiantes as $e): ?>
                <option value="<?= $e['id'] ?>">
                  <?= esc($e['full_name'] . ' - ' . $e['university_code']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Acción Realizada</label>
            <textarea name="accion" class="form-control" placeholder="Describa la acción" required></textarea>
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

<!-- Modal Editar Actividad -->
<div id="modalEditarActividad" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarActividad" method="post" action="<?= base_url('actividades/editar') ?>">
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Actividad</h4>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="editarActividadId">
          <div class="form-group">
            <label>Acción</label>
            <textarea name="accion" id="editarAccion" class="form-control" required></textarea>
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

<!-- Modal Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center"></div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $(document).on("click", ".btnEditarActividad", function() {
    $("#editarActividadId").val($(this).data("id"));
    $("#editarAccion").val($(this).data("accion"));
  });

  $("#formAgregarActividad").submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function() {
        $("#modalAgregarActividad").modal("hide");
        mostrarModal("Actividad registrada exitosamente");
        setTimeout(() => location.reload(), 1000);
      },
      error: function() {
        mostrarModal("Error al registrar actividad");
      }
    });
  });

  $("#formEditarActividad").submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function() {
        $("#modalEditarActividad").modal("hide");
        mostrarModal("Actividad actualizada correctamente");
        setTimeout(() => location.reload(), 1000);
      },
      error: function() {
        mostrarModal("Error al actualizar actividad");
      }
    });
  });

  function mostrarModal(mensaje) {
    $("#modalMensaje .modal-body").text(mensaje);
    $("#modalMensaje").modal("show");
  }
});
</script>
