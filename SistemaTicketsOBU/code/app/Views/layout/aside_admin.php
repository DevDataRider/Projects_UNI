<!-- Sidebar lateral limpio -->

<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <h4 class="sidebar-title">Menú Principal</h4>

      <li>
        <a href="<?= base_url('caja_admin') ?>">
          <i class="fa fa-dashboard"></i>
          <span>Inicio</span>
        </a>
      </li>

      <li>
        <a href="<?= base_url('estudiantes') ?>">
          <i class="fa fa-users"></i>
          <span>Estudiantes</span>
        </a>
      </li>

      <li>
        <a href="<?= base_url('platos') ?>">
          <i class="fa fa-cutlery"></i>
          <span>Platos del Día</span>
        </a>
      </li>

      <li>
        <a href="<?= base_url('tickets') ?>">
          <i class="fa fa-ticket"></i>
          <span>Gestión de Tickets</span>
        </a>
      </li>

      <li>
        <a href="<?= base_url('asistencias') ?>">
          <i class="fa fa-check-square-o"></i>
          <span>Asistencias</span>
        </a>
      </li>

      <li>
        <a href="<?= base_url('incidencias') ?>">
          <i class="fa fa-exclamation-triangle"></i>
          <span>Incidencias</span>
        </a>
      </li>

      <li>
        <a href="<?= base_url('actividades') ?>">
          <i class="fa fa-history"></i>
          <span>Actividad Estudiantil</span>
        </a>
      </li>

      <li>
        <a href="<?= base_url('configuracion') ?>">
          <i class="fa fa-cogs"></i>
          <span>Configuración</span>
        </a>
      </li>

      <li>
        <a href="<?= base_url('auth/logout') ?>">
          <i class="fa fa-sign-out"></i>
          <span>Cerrar Sesión</span>
        </a>
      </li>

    </ul>
  </section>
</aside>
<style>
  .main-sidebar {
    position: fixed;
    top: 50px; /* espacio para el header */
    left: 0;
    height: calc(100vh - 50px); /* alto total menos el header */
    overflow-y: auto;
    z-index: 1000;
  }


</style>