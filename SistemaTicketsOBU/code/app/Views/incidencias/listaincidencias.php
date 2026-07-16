<div class="content-wrapper">
  <section class="content-header">
    <h1>Data Tables <small>Incidencias</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Tablas</a></li>
      <li class="active">Incidencias</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border display">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarIncidencia">
          Registrar Incidencia
        </button>

        <a class="btn btn-info" target="_blank" href="<?= base_url('Reportes/PDFIncidencias') ?>">Imprimir PDF</a>
        <a class="btn btn-success" download="" href="<?= base_url('Reportes/ExcelIncidencias') ?>">Exportar Excel</a>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Estudiante</th>
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($incidencias as $key => $i): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= esc($i['full_name']) ?></td>
                <td><?= esc($i['descripcion']) ?></td>
                <td><?= esc($i['fecha']) ?></td>
                <td>
                  <button class="btn btn-primary btnEditarIncidencia"
                          data-id="<?= $i['id'] ?>"
                          data-student="<?= $i['student_id'] ?>"
                          data-descripcion="<?= esc($i['descripcion']) ?>"
                          data-fecha="<?= $i['fecha'] ?>"
                          data-toggle="modal"
                          data-target="#modalEditarIncidencia">
                    <i class="fa fa-pencil"></i>
                  </button>

                  <a href="<?= base_url('incidencias/eliminar/' . $i['id']) ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta incidencia?')">
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

<!-- Modal Agregar Incidencia -->
<div id="modalAgregarIncidencia" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formAgregarIncidencia" method="post" action="<?= base_url('incidencias/insertar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registrar Incidencia</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>ID Estudiante</label>
            <input type="number" name="student_id" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
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

<!-- Modal Editar Incidencia -->
<div id="modalEditarIncidencia" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarIncidencia" method="post" action="<?= base_url('incidencias/editar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Incidencia</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editarIdIncidencia">
          <div class="form-group">
            <label>ID Estudiante</label>
            <input type="number" name="student_id" id="editarStudentId" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" id="editarDescripcion" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" id="editarFecha" class="form-control" required>
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

<!-- Modal de Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center"></div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

  // Cargar datos en modal editar
  $(document).on("click", ".btnEditarIncidencia", function () {
    $("#editarIdIncidencia").val($(this).data("id"));
    $("#editarStudentId").val($(this).data("student"));
    $("#editarDescripcion").val($(this).data("descripcion"));
    $("#editarFecha").val($(this).data("fecha"));
  });

  // Agregar incidencia
  $("#formAgregarIncidencia").submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function(response) {
        $("#modalAgregarIncidencia").modal("hide");
        mostrarModal("Incidencia registrada correctamente");
        setTimeout(() => location.reload(), 1200);
      },
      error: function() {
        mostrarModal("Error al registrar incidencia");
      }
    });
  });

  // Editar incidencia
  $("#formEditarIncidencia").submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function(response) {
        $("#modalEditarIncidencia").modal("hide");
        mostrarModal("Incidencia actualizada correctamente");
        setTimeout(() => location.reload(), 1200);
      },
      error: function() {
        mostrarModal("Error al actualizar incidencia");
      }
    });
  });

  function mostrarModal(mensaje) {
    $("#modalMensaje .modal-body").text(mensaje);
    $("#modalMensaje").modal("show");
  }

});
</script>
