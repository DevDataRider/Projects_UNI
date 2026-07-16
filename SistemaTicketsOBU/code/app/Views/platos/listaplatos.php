<div class="content-wrapper">
  <section class="content-header">
    <h1>Data Tables <small>Platos del Día</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Tablas</a></li>
      <li class="active">Platos</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border text-center">
        <button class="btn btn-primary" 
          style="background-color: #1e3fa4; border-color: #1e3fa4; border-radius: 10px; padding: 7px; transition: all 0.2s ease;"
          onmouseover="this.style.backgroundColor='#2e50c7'; this.style.transform='translateY(-2px)'"
          onmouseout="this.style.backgroundColor='#1e3fa4'; this.style.transform='translateY(0)'"
          data-toggle="modal" data-target="#modalAgregarPlato">
          Agregar Plato
        </button>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:10px;">#</th>
              <th>Fecha</th>
              <th>Tipo de Comida</th>
              <th>Descripción</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($platos as $key => $p): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= esc($p['fecha']) ?></td>
                <td>Almuerzo</td> <!-- Tipo fijo -->
                <td><?= esc($p['descripcion']) ?></td>
                <td>
                  <button class="btn btn-primary btnEditarPlato btn-sm" style="background-color:#1e3fa4;"
                    data-id="<?= $p['id'] ?>"
                    data-fecha="<?= $p['fecha'] ?>"
                    data-descripcion="<?= esc($p['descripcion']) ?>"
                    data-toggle="modal" data-target="#modalEditarPlato">
                    <i class="fa fa-pencil"></i>
                  </button>
                  <a href="<?= base_url('platos/eliminar/' . $p['id']) ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('¿Estás seguro de eliminar este plato?')">
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

<!-- Modal Agregar Plato -->
<div id="modalAgregarPlato" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formAgregarPlato" method="post" action="<?= base_url('platos/insertar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Plato</h4>
        </div>
        <div class="modal-body">
          <div class="form-group"><label>Fecha</label><input type="date" name="fecha" class="form-control" required></div>
          <input type="hidden" name="tipo_comida_id" value="2"> <!-- Tipo fijo: Almuerzo -->
          <div class="form-group"><label>Descripción</label><textarea name="descripcion" class="form-control" required></textarea></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar Plato -->
<div id="modalEditarPlato" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarPlato" method="post" action="<?= base_url('platos/editar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Plato</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editarPlatoId">
          <input type="hidden" name="tipo_comida_id" value="2"> <!-- Tipo fijo: Almuerzo -->
          <div class="form-group"><label>Fecha</label><input type="date" name="fecha" id="editarFecha" class="form-control" required></div>
          <div class="form-group"><label>Descripción</label><textarea name="descripcion" id="editarDescripcion" class="form-control" required></textarea></div>
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

<script>
$(document).ready(function () {

  $(document).on("click", ".btnEditarPlato", function () {
    $("#editarPlatoId").val($(this).data("id"));
    $("#editarFecha").val($(this).data("fecha"));
    $("#editarDescripcion").val($(this).data("descripcion"));
  });

  $("#formAgregarPlato").submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function (response) {
        $("#modalAgregarPlato").modal("hide");
        mostrarModal("Plato agregado exitosamente");
        setTimeout(() => location.reload(), 1200);
      },
      error: function () {
        mostrarModal("Error al agregar plato");
      }
    });
  });

  $("#formEditarPlato").submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function (response) {
        $("#modalEditarPlato").modal("hide");
        mostrarModal("Plato actualizado correctamente");
        setTimeout(() => location.reload(), 1200);
      },
      error: function () {
        mostrarModal("Error al actualizar plato");
      }
    });
  });

  function mostrarModal(mensaje) {
    $("#modalMensaje .modal-body").text(mensaje);
    $("#modalMensaje").modal("show");
  }
});
</script>
