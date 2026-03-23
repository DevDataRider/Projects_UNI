<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RiVerOBU</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>/plugins/iCheck/square/blue.css">

 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


  <style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f0f2f5;
  }

  .contenedor-todo {
    display: flex;
    height: 100vh;
    width: 100vw;
  }

  /* Lado izquierdo con imagen */
  .contenedor-derecho {
    width: 50%;
    background-color: #1e3fa4;
    display: flex;
    justify-content: center;
    align-items: center;
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
    overflow: hidden;
  }

  .contenedor-derecho img {
    max-width: 80%;
    width: 65%;
    height: auto;
  }

  /* Lado derecho con login */
  .contenedor-izquierdo {
    width: 50%;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
    background-color:rgb(238, 231, 231);
  }

 .login-box {
  width: 100%;
  max-width: 400px;
  background-color: #ffffff; /* blanco sólido */
  padding: 40px 30px;
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12); /* sombra más visible */
  text-align: left;
}


  .login-logo {
    text-align: center;
    margin-bottom: 20px;
  }

  .login-logo a {
    font-size: 24px;
    font-weight: bold;
    color: #1e3fa4;
    text-decoration: none;
  }

  .login-box-msg {
    font-size: 18px;
    font-weight: 600;
    text-align: center;
    color: #333;
    margin-bottom: 30px;
  }

  .form-control {
    border-radius: 10px;
    padding: 12px;
    border: 1px solid #ccc;
    font-size: 14px;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .btn-primary {
    background: linear-gradient(90deg, #3056d3, #1e3fa4);
    border: none;
    font-weight: 600;
    font-size: 16px;
    padding: 10px;
    border-radius: 10px;
    transition: 0.3s ease;
    object-fit: contain;

  }

  .btn-primary:hover {
    opacity: 0.9;
    transform: scale(1.05);
  }


.login-box {
  width: 100%;
  max-width: 400px;
  background-color: white;
  padding: 40px 30px;
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(90, 84, 84, 0.05);
  text-align: left;
}

.login-box-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 30px;
}

.login-box-logo img {
  height: 32px;
  margin-right: 10px;
}

.login-box-logo span {
  font-size: 20px;
  font-weight: 600;
  color: #1e3fa4;
}

.login-box-msg {
  font-size: 22px;
  font-weight: 600;
  color: #333;
  margin-bottom: 30px;
  text-align: center;
}

.form-group {
  margin-bottom: 20px;
}

label {
  font-weight: 600;
  font-size: 14px;
  margin-bottom: 6px;
  display: inline-block;
  color: #333;
}

label::after {
  content: ' *';
  color: red;
}

.form-control {
  border-radius: 10px;
  padding: 12px;
  border: 1px solid #dcdcdc;
  font-size: 14px;
  width: 100%;
  box-sizing: border-box;
}

.btn-login {
  width: 100%;
  padding: 12px;
  border-radius: 10px;
  background: linear-gradient(90deg, #3056d3, #1e3fa4);
  color: white;
  font-weight: 600;
  border: none;
  font-size: 15px;
  margin-top: 10px;
  transition: 0.3s ease;
}

.btn-login:hover {
  opacity: 0.9;
  cursor: pointer;

}

.contenedor-derecho img {
  max-width: 85%;
  height: auto;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(30, 63, 164, 0.25); /* sombra azul */
  object-fit: contain;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contenedor-derecho img:hover {
  transform: scale(1.08);
  box-shadow: 0 15px 35px rgba(30, 63, 164, 0.35); /* sombra azul más intensa al hacer hover */
}



  /* Responsive */
  @media (max-width: 768px) {
    .contenedor-todo {
      flex-direction: column;
    }

    .contenedor-derecho,
    .contenedor-izquierdo {
      width: 100%;
      border-radius: 0;
    }

    .contenedor-derecho {
      padding: 20px;
    }

    .contenedor-izquierdo {
      padding: 20px;
    }
  }
</style>



</head>
<body class="hold-transition login-page" 
style="background-image: linear-gradient(rgb(238, 231, 231),rgb(238, 231, 231));
background-size: cover; background-repeat: no-repeat; background-position: center;">

<div class="contenedor-todo">

  <!-- Panel derecho (imagen o decoración) -->
    <div class="contenedor-derecho">
       <img src="https://www.shutterstock.com/image-vector/school-canteen-scene-set-flat-600nw-1929088697.jpg" alt="Ilustración" style="max-width: 80%; height: auto;">
    </div>


  <!-- Panel izquierdo (formulario de login) -->
  <div class="contenedor-izquierdo">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>RiVerOBU</b></a>
      </div>

      <!-- /.login-logo -->
      <div class="login-box-body" style="border-radius: 10px;">
        <p class="login-box-msg">Inicia Sesión</p>

        <?php if (isset($error)) { ?>
          <div class="alert alert-warning">
            <p><?php echo $error; ?></p>
          </div>
        <?php } ?>
        
        <?php if (session()->getFlashdata('mensaje')): ?>
         <div class="alert alert-warning">
        <?= session()->getFlashdata('mensaje'); ?>
         </div>
        <?php endif; ?>


        <?php if (isset($vacio)) { ?>
          <div class="alert alert-warning">
            <p><?php echo $vacio; ?></p>
          </div>
        <?php } ?>

        <form action="<?php echo base_url(); ?>Auth/SesionLogin" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Código Universitario" name="usuario">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Contraseña" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" style="border-radius: 6px;">Entrar</button>
            </div>
          </div>
        </form>

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
  </div>
  <!-- /.contenedor-izquierdo -->

</div>
<!-- /.contenedor-todo -->

<script>
  setTimeout(() => {
    const alerta = document.querySelector('.alert');
    if (alerta) alerta.style.display = 'none';
  }, 4000); // 4 segundos
</script>

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url();?>/plugins/iCheck/icheck.min.js"></script>


</body>
</html>
