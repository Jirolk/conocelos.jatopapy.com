<!DOCTYPE html>
<html lang="es" dir="ltr">
     <head>
          <meta charset="utf-8">
          <title>Acceso denegado</title>
          <link rel="icon" type="image/png" href="img/icono.png"/>
          <link rel="stylesheet" href="bt/bootstrap.min.css">
          <script src="js/jquery-3.3.1.min.js"></script>
          <!-- Boostrap -->
          <script src="bt/bootstrap.min.js"></script>
     </head>
     <body class="S">
          <?php echo "
              <script type='text/javascript'>
                  document.getElementById('carusel').hidden= true;
              </script>"; ?>
          <div id="seguridad" class="panel panel-danger container text-center mt-4 border border-danger rounded" align="center" style="border: 1px solid; border-color: #FF0000!important; box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)!important;">
              <div class="panel-heading bg-danger">
                  <h1 id="titulo" class="panel-title text-center-danger">¡¡¡ Atención !!!</h1>
              </div>
              <div class="panel-body">
                  <div class="jumbotron jumbotron-fluid">
                      <h1 class="text-center">Acceso Denegado...</h1>
                      <h3 class="text-center">No está autorizado!, para acceder al Sistema...</h3>
                      <h3 class="text-center"><div id="segundos"></div></h3>
                  </div>
              </div>
          </div>
          <script>
               timer(11000,
                   function(seg) {
                     $("#segundos").html("En " + seg + " segundos será redirigido...");
                   },
                   function() {
                       location.href="index.php";
                   }
               );

               function timer(time, update, complete) {
                    start = new Date().getTime();
                    interval = setInterval(function() {
                       now = time-(new Date().getTime()-start);
                       if( now <= 0) {
                           clearInterval(interval);
                           complete();
                       }else update(Math.floor(now/1000));
                   },100);
               }
          </script>
     </body>
</html>
