<div class="content-wrapper">
  <section class="content-header">
    <h1>Configuración del Sistema</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Configuración</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Parámetros Generales</h3>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped tablas">
          <thead>
            <tr>
              <th>#</th>
              <th>Parámetro</th>
              <th>Valor</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($configuraciones as $key => $c): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= ucfirst(str_replace('_', ' ', $c['clave'])) ?></td>
                <td><?= esc($c['valor']) ?></td>
                <td>
                  <button class="btn btn-primary btnEditarConfiguracion"
                    data-id="<?= $c['id'] ?>"
                    data-valor="<?= $c['valor'] ?>"
                    data-toggle="modal" data-target="#modalEditarConfiguracion">
                    <i class="fa fa-pencil"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<div id="modalEditarConfiguracion" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?= base_url('configuracion/editar') ?>">
        <?= csrf_field() ?>
        <div class="modal-header" style="background-color: #3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Configuración</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="configId">
          <div class="form-group">
            <label>Nuevo Valor</label>
            <input type="text" name="valor" id="configValor" class="form-control" required>
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

<script>
$(document).ready(function() {
  $(".btnEditarConfiguracion").click(function() {
    $("#configId").val($(this).data("id"));
    $("#configValor").val($(this).data("valor"));
  });
});
</script>
