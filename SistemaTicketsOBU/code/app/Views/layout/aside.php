<aside class="main-sidebar">
  <section class="sidebar">

    <!-- Menú -->
    <ul class="sidebar-menu" data-widget="tree" style="font-size: 16px;">
      
      <h4 class="sidebar-title">Menú Estudiante</h4>

      <li class="inicio">
        <a href="<?= base_url("cajas") ?>">
          <i class="fa fa-dashboard text-aqua"></i> <span>Inicio</span>
        </a>
      </li>

      <li class="ticket-dia">
        <a href="<?= base_url("TicketEstudiante/hoy") ?>">
          <i class="fa fa-cutlery text-green"></i> <span>Mi Ticket de Hoy</span>
        </a>
      </li>

      <li class="historial">
        <a href="<?= base_url("ticketestudiante/historial") ?>">
          <i class="fa fa-history text-yellow"></i> <span>Historial de Consumo</span>
        </a>
      </li>

      <li class="perfil">
        <a href="<?= base_url("perfil") ?>">
          <i class="fa fa-user-circle text-purple"></i> <span>Mi Perfil</span>
        </a>
      </li>      

      <li class="logout">
        <a href="<?= base_url("auth/logout") ?>" class="btn-logout-confirm">
          <i class="fa fa-sign-out text-danger"></i> <span>Cerrar Sesión</span>
        </a>
      </li>

    </ul>
  </section>
</aside>
