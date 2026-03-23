<div class="content-wrapper">
  <section class="content-header">
    <h1>Mi Perfil</h1>
    <small>Gestiona tu información personal</small>
  </section>

  <section class="content">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Datos del Estudiante</h3>
      </div>

      <form action="<?= base_url('perfil/actualizar') ?>" method="post">
        <div class="box-body">
          <div class="form-group">
            <label for="full_name">Nombre Completo</label>
            <input type="text" name="full_name" class="form-control" value="<?= esc($perfil['full_name']) ?>" required>
          </div>

          <div class="form-group">
            <label for="university_code">Código Universitario</label>
            <input type="text" class="form-control" value="<?= esc($perfil['university_code']) ?>" disabled>
          </div>

          <div class="form-group">
            <label for="email_institutional">Correo Institucional</label>
            <input type="email" name="email_institutional" class="form-control" value="<?= esc($perfil['email_institutional']) ?>" required>
          </div>
        </div>

        <div class="box-footer text-right">
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
    </div>
  </section>
</div>

<!-- ✅ Modal de Éxito -->
<div class="modal fade" id="modalExito" tabindex="-1" role="dialog" aria-labelledby="modalExitoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center" style="border-radius: 12px;">
      <div class="modal-header bg-success text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
        <h5 class="modal-title" id="modalExitoLabel" style="font-size: 20px;">✅ Perfil Actualizado</h5>
      </div>
      <div class="modal-body" style="font-size: 16px;">
        ¡Tu perfil se actualizó correctamente!
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<!-- ⚠️ Modal de Advertencia -->
<div class="modal fade" id="modalAdvertencia" tabindex="-1" role="dialog" aria-labelledby="modalAdvertenciaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center" style="border-radius: 12px;">
      <div class="modal-header bg-warning text-dark" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
        <h5 class="modal-title" id="modalAdvertenciaLabel" style="font-size: 19px;">⚠️ Sin Cambios Detectados</h5>
      </div>
      <div class="modal-body" style="font-size: 16px;">
        No realizaste ningún cambio en tu perfil.
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Entendido</button>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Mostrar modal de éxito si hubo cambio -->
<?php if (session()->getFlashdata('success')): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      $('#modalExito').modal('show');
    });
  </script>
<?php endif; ?>

<!-- ✅ Script para verificar cambios -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const nombreInput = form.querySelector('input[name="full_name"]');
    const emailInput = form.querySelector('input[name="email_institutional"]');

    const nombreOriginal = nombreInput.value.trim();
    const emailOriginal = emailInput.value.trim();

    form.addEventListener('submit', function (e) {
      const nombreActual = nombreInput.value.trim();
      const emailActual = emailInput.value.trim();

      if (nombreActual === nombreOriginal && emailActual === emailOriginal) {
        e.preventDefault();
        $('#modalAdvertencia').modal('show');
      }
    });
  });
</script>
