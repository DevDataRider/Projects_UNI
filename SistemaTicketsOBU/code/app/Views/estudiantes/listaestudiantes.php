<div class="content-wrapper">
  <section class="content-header">
    <h1>Data Tables <small>Estudiantes</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Tablas</a></li>
      <li class="active">Estudiantes</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      
    <div class="box-header with-border text-center">
  <div class="btn-group">
    <button class="btn btn-primary" 
      style="margin-right: 10px; background-color: #1e3fa4; border-color: #1e3fa4; border-radius: 6px;"
      data-toggle="modal" data-target="#modalAgregarEstudiante">
      Agregar Estudiante
    </button>

    <a class="btn btn-info" 
      style="margin-right: 10px; border-radius: 6px;" 
      href="<?= base_url('Reportes/PDFEstudiantes') ?>" target="_blank">
      Imprimir PDF
    </a>

    <a class="btn btn-success" 
      style="border-radius: 6px;"
      href="<?= base_url('Reportes/ExcelEstudiantes') ?>">
      Exportar Excel
    </a>
  </div>
</div>



      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px;">#</th>
              <th>Nombre Completo</th>
              <th>Código Univ.</th>
              <th>DNI</th>
              <th>Correo</th>
              <th>Facultad</th>
              <th>Celular</th>
              <th>Género</th>
              <th>Becado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($estudiantes as $key => $e): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= esc($e['full_name']) ?></td>
                <td><?= esc($e['university_code']) ?></td>
                <td><?= esc($e['dni']) ?></td>
                <td><?= esc($e['email_institutional']) ?></td>
                <td><?= esc($e['facultad']) ?></td>
                <td><?= esc($e['mobile']) ?></td>
                <td><?= esc($e['gender']) ?></td>
                <td><?= $e['is_scholarship'] ? 'Sí' : 'No' ?></td>
                <td>
                  <button class="btn btn-primary btn-sm btnEditarEstudiante" style="background-color: #1e3fa4; border-color: #1e3fa4;"
                    data-id="<?= $e['id'] ?>"
                    data-full_name="<?= esc($e['full_name']) ?>"
                    data-dni="<?= esc($e['dni']) ?>"
                    data-university_code="<?= esc($e['university_code']) ?>"
                    data-email_institutional="<?= esc($e['email_institutional']) ?>"
                    data-facultad="<?= esc($e['facultad']) ?>"
                    data-mobile="<?= esc($e['mobile']) ?>"
                    data-gender="<?= esc($e['gender']) ?>"
                    data-is_scholarship="<?= $e['is_scholarship'] ?>"
                    data-toggle="modal" data-target="#modalEditarEstudiante">
                    <i class="fa fa-pencil"></i>
                  </button>
                  <a href="<?= base_url('estudiantes/eliminar/' . $e['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este estudiante?')">
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

<!-- Modal Agregar Estudiante -->
<div id="modalAgregarEstudiante" class="modal fade" role="dialog" >
  <div class="modal-dialog" >
    <div class="modal-content" >
      <form id="formAgregarEstudiante" method="post" action="<?= base_url('estudiantes/insertar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #1e3fa4; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Estudiante</h4>
        </div>
        <div class="modal-body modal-body-scroll" style="border-radius: 10px;">
          <div class="form-group"><label>Nombre Completo</label><input type="text" name="full_name" class="form-control" required></div>
          <div class="form-group">
            <label>DNI</label>
            <input type="text" name="dni" class="form-control campo-dni" required
              inputmode="numeric" maxlength="8" minlength="8" pattern="\d{8}"
              title="El DNI debe tener exactamente 8 dígitos" placeholder="8 dígitos">
          </div>
          <div class="form-group">
            <label>Código Universitario</label>
            <input type="text" name="university_code" class="form-control campo-codigo" required
              inputmode="numeric" maxlength="10" minlength="10" pattern="\d{10}"
              title="El código universitario debe tener exactamente 10 dígitos" placeholder="10 dígitos">
          </div>
          <div class="form-group">
            <label>Correo Institucional</label>
            <input type="email" name="email_institutional" class="form-control" required
              pattern="^[a-zA-Z0-9._%+-]+@unac\.edu\.pe$"
              title="El correo debe terminar en @unac.edu.pe" placeholder="usuario@unac.edu.pe">
          </div>
          <div class="form-group">
            <label>Facultad</label>
            <select name="facultad" class="form-control" required>
              <option value="">-- Seleccionar --</option>
              <?php foreach ($facultades as $f): ?>
                <option value="<?= esc($f) ?>"><?= esc($f) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Celular</label>
            <input type="text" name="mobile" class="form-control campo-celular" required
              maxlength="12" minlength="12" pattern="\+51\d{9}"
              title="El celular debe tener el formato +51 seguido de 9 dígitos (12 caracteres en total)" placeholder="+51965422035">
          </div>
          <div class="form-group"><label>Género</label><select name="gender" class="form-control" required><option value="">-- Seleccionar --</option><option value="masculino">Masculino</option><option value="femenino">Femenino</option><option value="otro">Otro</option></select></div>
          <div class="form-group"><label>¿Becado?</label><select name="is_scholarship" class="form-control" required><option value="">-- Seleccionar --</option><option value="1">Sí</option><option value="0">No</option></select></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" style="background-color: #1e3fa4;">Guardar</button>
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar Estudiante -->
<div id="modalEditarEstudiante" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarEstudiante" method="post" action="<?= base_url('estudiantes/editar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Estudiante</h4>
        </div>
        <div class="modal-body modal-body-scroll">
          <input type="hidden" name="id" id="editarId">
          <div class="form-group"><label>Nombre Completo</label><input type="text" name="full_name" id="editarNombre" class="form-control" required></div>
          <div class="form-group">
            <label>DNI</label>
            <input type="text" name="dni" id="editarDni" class="form-control campo-dni" required
              inputmode="numeric" maxlength="8" minlength="8" pattern="\d{8}"
              title="El DNI debe tener exactamente 8 dígitos">
          </div>
          <div class="form-group">
            <label>Código Universitario</label>
            <input type="text" name="university_code" id="editarCodigo" class="form-control campo-codigo" required
              inputmode="numeric" maxlength="10" minlength="10" pattern="\d{10}"
              title="El código universitario debe tener exactamente 10 dígitos">
          </div>
          <div class="form-group">
            <label>Correo Institucional</label>
            <input type="email" name="email_institutional" id="editarCorreo" class="form-control" required
              pattern="^[a-zA-Z0-9._%+-]+@unac\.edu\.pe$"
              title="El correo debe terminar en @unac.edu.pe">
          </div>
          <div class="form-group">
            <label>Facultad</label>
            <select name="facultad" id="editarFacultad" class="form-control" required>
              <option value="">-- Seleccionar --</option>
              <?php foreach ($facultades as $f): ?>
                <option value="<?= esc($f) ?>"><?= esc($f) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Celular</label>
            <input type="text" name="mobile" id="editarCelular" class="form-control campo-celular" required
              maxlength="12" minlength="12" pattern="\+51\d{9}"
              title="El celular debe tener el formato +51 seguido de 9 dígitos (12 caracteres en total)">
          </div>
          <div class="form-group">
            <label>Género</label>
            <select name="gender" id="editarGenero" class="form-control" required>
              <option value="">-- Seleccionar --</option>
              <option value="masculino">Masculino</option>
              <option value="femenino">Femenino</option>
              <option value="otro">Otro</option>
            </select>
          </div>
          <div class="form-group">
            <label>¿Becado?</label>
            <select name="is_scholarship" id="editarBeca" class="form-control" required>
              <option value="">-- Seleccionar --</option>
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
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
      <div class="modal-body text-center">
        <!-- Aquí se mostrará el mensaje dinámicamente -->
      </div>
    </div>
  </div>
</div>

<style>
  #modalAgregarEstudiante .modal-dialog,
  #modalEditarEstudiante .modal-dialog {
    margin-top: 40px;
  }
  .modal-body-scroll {
    max-height: 65vh;
    overflow-y: auto;
    padding-right: 15px;
  }
</style>

<!-- Asegúrate de esto está al inicio -->
<script>
  $(document).on("click", ".btnEditarEstudiante", function () {
      console.log("Clic en botón editar");

    $("#editarId").val($(this).data("id"));
    $("#editarNombre").val($(this).data("full_name"));
    $("#editarDni").val($(this).data("dni"));
    $("#editarCodigo").val($(this).data("university_code"));
    $("#editarCorreo").val($(this).data("email_institutional"));
    $("#editarFacultad").val($(this).data("facultad"));
    $("#editarCelular").val($(this).data("mobile"));
    $("#editarGenero").val($(this).data("gender"));
    $("#editarBeca").val($(this).data("is_scholarship"));
  });
</script><script>
$(document).ready(function() {

  // Agregar estudiante por AJAX
  $("#formAgregarEstudiante").submit(function(e) {
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function(response) {
        $("#modalAgregarEstudiante").modal("hide");
        mostrarModal("Estudiante agregado exitosamente");
        setTimeout(() => location.reload(), 1200);
      },
      error: function(xhr) {
        mostrarModal(obtenerMensajeError(xhr, "Error al agregar estudiante"));
      }
    });
  });

  // Editar estudiante por AJAX
  $("#formEditarEstudiante").submit(function(e) {
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function(response) {
        $("#modalEditarEstudiante").modal("hide");
        mostrarModal("Estudiante actualizado correctamente");
        setTimeout(() => location.reload(), 1200);
      },
      error: function(xhr) {
        mostrarModal(obtenerMensajeError(xhr, "Error al actualizar estudiante"));
      }
    });
  });

  // Mostrar modal de notificación
  function mostrarModal(mensaje) {
    $("#modalMensaje .modal-body").text(mensaje);
    $("#modalMensaje").modal("show");
  }

  // Actualiza el token CSRF en ambos formularios con el valor vigente que
  // devuelve el servidor, para que un reintento (sin recargar la página) no
  // sea rechazado por usar un token ya vencido/rotado.
  function actualizarTokenCsrf(xhr) {
    var csrf = xhr && xhr.responseJSON && xhr.responseJSON.csrf;
    if (csrf && csrf.name && csrf.hash) {
      $('input[name="' + csrf.name + '"]').val(csrf.hash);
    }
  }

  // Arma un mensaje legible a partir de los errores de validación que devuelve el servidor
  function obtenerMensajeError(xhr, mensajePorDefecto) {
    actualizarTokenCsrf(xhr);
    if (xhr && xhr.responseJSON && xhr.responseJSON.messages) {
      return Object.values(xhr.responseJSON.messages).join("\n");
    }
    return mensajePorDefecto;
  }

  // Solo dígitos en DNI y Código Universitario
  $(document).on("input", ".campo-dni, .campo-codigo", function () {
    this.value = this.value.replace(/\D/g, "");
  });

  // Celular: fuerza el prefijo +51 seguido solo de dígitos
  $(document).on("input", ".campo-celular", function () {
    let valor = this.value.replace(/[^\d+]/g, "");
    if (!valor.startsWith("+51")) {
      valor = "+51" + valor.replace(/\+/g, "").replace(/^51/, "");
    }
    const digitos = valor.slice(3).replace(/\D/g, "").slice(0, 9);
    this.value = "+51" + digitos;
  });
  $(document).on("focus", ".campo-celular", function () {
    if (!this.value) this.value = "+51";
  });

});
</script>


