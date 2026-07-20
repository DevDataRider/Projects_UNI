<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.5
    </div>
    <strong>Copyright &copy; 2026 <a href="">Comedor OBU</a>.</strong> Desarrollo de Software.
  </footer>

<!-- Modal de Confirmación - Cerrar Sesión -->
<div class="modal fade" id="modalCerrarSesion" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header" style="background-color:#1e3fa4; color:#fff;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.9;">&times;</button>
        <h4 class="modal-title"><i class="fa fa-sign-out"></i> Cerrar Sesión</h4>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que quieres cerrar sesión?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a href="#" id="linkConfirmarLogout" class="btn btn-danger">Sí, cerrar sesión</a>
      </div>
    </div>
  </div>
</div>

<style>
  #modalCerrarSesion .modal-dialog {
    max-width: 490px;
    width: 90%;
    margin: 80px auto 0;
  }

  #modalCerrarSesion .modal-content {
    border-radius: 18px;
    overflow: hidden;
    border: none;
  }

  #modalCerrarSesion .modal-header {
    border-radius: 0;
    padding: 22px 24px;
  }

  #modalCerrarSesion .modal-title {
    font-size: 1.82rem;
  }

  #modalCerrarSesion .close {
    font-size: 29px;
  }

  #modalCerrarSesion .modal-body {
    padding: 40px 30px;
  }

  #modalCerrarSesion .modal-body p {
    font-size: 1.68rem;
    text-align: center;
    margin: 0;
  }

  #modalCerrarSesion .modal-footer {
    padding: 18px 24px 26px;
    text-align: center;
  }

  #modalCerrarSesion .btn {
    border-radius: 8px;
    padding: 11px 26px;
    font-size: 1.12rem;
  }

  #modalCerrarSesion .btn-danger {
    background-color: #ff6b6b;
    border-color: #ff6b6b;
  }

  #modalCerrarSesion .btn-danger:hover {
    background-color: #ff5252;
    border-color: #ff5252;
  }
</style>

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo base_url();?>js/sweetalert2/sweetalert2.all.js"></script>


<!-- DataTables -->
<script src="<?php echo base_url();?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>



<!-- Morris.js charts -->
<script src="<?php echo base_url();?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url();?>bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url();?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url();?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url();?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url();?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url();?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url();?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url();?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->


<script src="<?php echo base_url();?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url();?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>dist/js/demo.js"></script>


<script> base_url = '<?= base_url() ?>' </script>


<script src="<?php echo base_url();?>js/plantilla.js"></script>


<script src="<?php echo base_url();?>js/usuarios.js"></script>


<script src="<?php echo base_url();?>js/productos.js"></script>

<script src="<?php echo base_url();?>js/categorias.js"></script>

<script src="<?php echo base_url();?>js/clientes.js"></script>

<script src="<?php echo base_url();?>js/cotizaciones.js"></script>

<script>
  $(document).on('click', '.btn-logout-confirm', function (e) {
    e.preventDefault();
    $('#linkConfirmarLogout').attr('href', $(this).attr('href'));
    $('#modalCerrarSesion').modal('show');
  });
</script>




</body>
</html>