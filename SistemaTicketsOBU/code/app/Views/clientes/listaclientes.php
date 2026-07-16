 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>Clientes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
             <button class="btn btn-primary" data-toggle="modal" data-target="#modalClientes">Agregar Clientes</button>

              <a class="btn btn-info" target="_blank" href="<?php echo base_url();?>Reportes/PDFClientes">Imprimir Clientes PDF</a>
               <a class="btn btn-success" download="" href="<?php echo base_url();?>Reportes/ExcelClientes">Exportar Clientes Excel</a>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped tablas">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Documento</th>
                  <th>Email</th>
                  <th>Telefono</th>
                  <th>Direccion</th>
                  <th>Acciones</th>

                </tr>
                </thead>

                <tbody>

                  <?php


                  foreach($clientes as $key => $valores){

                    echo '<tr>

                    <td>'.($key+1).'</td>
                    <td>'.$valores->nombre.'</td>
                    <td>'.$valores->documento.'</td>
                    <td> '.$valores->email.'</td>
                    <td>'.$valores->telefono.'</td>
                    <td>'.$valores->direccion.'</td>
                     <td>

                     <button class="btn btn-primary btnEditarClientes" idClientes="'.$valores->id.'" data-toggle="modal" data-target="#editarClientes" aria-haspupup="true" aria-expanded="false"><i class="fa fa-pencil"></i></button>
                       <button class="btn btn-danger btnEliminarClientes" idClientes="'.$valores->id.'"><i class="fa fa-times"></i></button>

                     </td>
                    </tr>';
                  }

                  ?>
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <div id="modalClientes" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <div class="modal-content">

        <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>Clientes/InsertarClientes">
          <?= csrf_field() ?>


          <?php if (isset($ClientesError)) { ?>

            <div class="aler alert-warning">

              <p><?php echo $ClientesError; ?> </p>
              

            </div>
            

         <?php  } ?>



          <div class="modal-header" style="background-color: #3c8dbc; color:white;">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Agregar Clientes </h4>

            
          </div>


          <div class="modal-body">


            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" name="nombre" placeholder="Nombre">
                
              </div>
  

            </div>


             <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg" name="documento" placeholder="Documento">
                
              </div>
  

            </div>


             <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="email" placeholder="Correo">
                
              </div>

            </div>
              <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="telefono" placeholder="Telefono">
            
              </div>
            </div>
              <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="direccion" placeholder="Direccion">
                
              </div>
  

            </div>


          
            <div class="modal-footer">

              <button class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
              <button type="submit" class="btn btn-primary">Guardar Clientes</button>
              
            </div>

          </div>
          
        </form>
        
      </div>
      
    </div> 
    
  </div>


  <div id="editarClientes" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <div class="modal-content">

        <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>Clientes/EditarClientes">
          <?= csrf_field() ?>


          <?php if (isset($editarClientesError)) { ?>

            <div class="aler alert-warning">

              <p><?php echo $editarClientesError; ?> </p>
              

            </div>
            

         <?php  }?>



          <div class="modal-header" style="background-color: #3c8dbc; color:white;">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Editar Clientes </h4>

            
          </div>


          <div class="modal-body">


            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-lg" name="editarnombre" id="editarnombre">

                <input type="hidden" name="idClientes" id="idClientes">
                
              </div>
  

            </div>


            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg" name="editardocumento" id="editardocumento">
                
              </div>
  

            </div>


             <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="editaremail" id="editaremail">
                
              </div>

            </div>

              <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="editartelefono" id="editartelefono">
                
              </div>

            </div>


              <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                <input type="text" class="form-control input-lg" name="editardireccion" id="editardireccion">
                
              </div>
  

            </div>


            

            <div class="modal-footer">

              <button class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
              <button type="submit" class="btn btn-primary">Editar Cliente</button>
              
            </div>



            

          </div>
          
        </form>
        
      </div>
      
    </div> 
    
  </div>











