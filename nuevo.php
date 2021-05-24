<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/logoFinal.png" />

    <title>CONOCELOS</title>

    <?php include_once "lib/librerias_Superior.php"; ?>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light roque ">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarTogglerDemo01">

            <a class="navbar-brand text-white" href="#"> <img src="img/LogoFinal.png" class="img-fluid d-inline-block align-top" width="30" height="30" alt="logo"> CONÓCELOS</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>


    <div class="container-fluid ">
        <div id="datPersDet" class="row">
            <div class="col">
                <div class="align-items-center ">
                    <h1 class="text-dark text-center font-weight-bold ">CONÓCELOS</h1>
                </div>
                <div class=" mb-2  ">
                    <div class="  align-items-center">
                        <ul>
                            <li>
                                <p class="text-uppercase text-dark p-0 text-justify font-weight">"CONÓCELOS" es un proyecto de transparencia electoral, que tiene como objetivo brindar información a la ciudadanía sobre los candidatos a las elecciones internas 2021 de la ciudad de Concepción.</p>
                                <p class="text-uppercase text-dark p-0 text-justify font-weight">A través de esta iniciativa buscamos mantener informado a los ciudadanos sobre los diferentes candidatos a los cargos de Intendencia y Concejalía, para así incrementar el acceso a la información pública por parte de la ciudadanía, promover la participación ciudadana y fortalecer el proceso democrático en la ciudad de Concepción.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once("./servicios/conexion.php");
        $conex = conexion();

        $sql = "SELECT * FROM `candidatos`
            ORDER BY RAND()
            LIMIT 6";
        $res = mysqli_query($conex, $sql);

        echo '
    <div class="container-1">
		
		<ul id="autoWidth" class="cs-hidden">
    
    ';

        foreach ($res as $fila) {
            echo '
      <li class="item-a">
      <div class="box">
          <div class="img-content">
          <div  class="img" style="
                    width: 100%;
                    height: 100%;
                    top: 0;
                    left: 0;
                    background-size: cover;
                    transition: .2s;">
                    <img src="imgcandidatos/';
            echo $fila['img'];
            echo '" alt="" style="
                            width: 100%;
                            height: 100%;
                            top: 0;
                            left: 0;
                            
                            background-size: cover;
                            transition: .2s;">
                            <div class="info">
                            <h6>' . $fila['nomApe'] . '</h6>
                            <p style="color: #929292;">';
            if ($fila['codCand'] == 1) {
                echo 'INTENDENTE MUNICIPAL';
            } else {
                echo 'CONCEJAL MUNICIPAL';
            }
            echo '</p>
                  </div>
                  <div class="social">
                  <ul>';
            //$cons = "SELECT * FROM redessociales WHERE codDetalle =".$fila['codDetalle'];
            $cons = "SELECT * FROM redessociales rs
                                INNER JOIN candidatodetalle dt ON rs.codDetalle=dt.codDetalle
                                INNER JOIN candidatos c ON dt.ci=c.ci
                            WHERE c.ci=" . $fila['ci'];

            $resp = mysqli_query($conex, $cons);
            if (empty($resp)) {
            } else {
                foreach ($resp as $fi) {
                    echo '<li>';
                    if (strcasecmp($fi['redSocial'], "FACEBOOK") == 0) {
                        echo '
                          <a href="' . $fi['url'] . '" target="_blank">
                          <i class="h3 fab fa-facebook-f " style="color: black;"></i>
                            </a>';
                    }
                    if (strcasecmp($fi['redSocial'], "INSTAGRAM") == 0) {
                        echo '
                          
                          <a  href="' . $fi['url'] . '" target="_blank">
                              
                          <i class="h3 fab fa-instagram " style="color: black;"></i>
                          </a>
                          ';
                    }
                    if (strcasecmp($fi['redSocial'], "TWITTER") == 0) {
                        echo '
                          
                          <a  href="' . $fi['url'] . '" target="_blank">
                            <i class="h3 fab fa-twitter" style="color: black;"></i>
                            </a>
                            ';
                    }
                    if (strcasecmp($fi['redSocial'], "YOUTUBE") == 0) {
                        echo '
                          
                          <a  href="' . $fi['url'] . '" target="_blank">
                          <i class="h3 fab fa-youtube " style="color: black;"></i>
                          </a>
                          ';
                    }
                    echo '</li>';
                }
            }
            cerrarBD($cons);
            echo ' </ul>
                    </div>
                    </div>
                    </div>';
        }
        cerrarBD($conex);


        ?>

    </div>


    <div id="cajacookies">
        <p>
            Éste sitio web usa cookies, si permanece aquí acepta su uso.
            Puede leer más sobre el uso de cookies en nuestra <a href="privacidad.php">política de privacidad</a><br>
            <button onclick="aceptarCookies()"><i class="fa fa-times"></i> Aceptar</button>
        </p>
    </div>
    <?php require_once "vistas/parte_inferior.php"; ?>



    <?php include_once "lib/librerias_inferior.php" ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
            $('#autoWidth').lightSlider({
                autoWidth: true,
                loop: true,
                onSliderLoad: function() {
                    $('#autoWidth').removeClass('cS-hidden');
                }
            });
        });

        function compruebaAceptaCookies() {
            if (localStorage.aceptaCookies == 'true') {
                cajacookies.style.display = 'none';
            }
        }

        /* aquí guardamos la variable de que se ha
        aceptado el uso de cookies así no mostraremos
        el mensaje de nuevo */
        function aceptarCookies() {
            localStorage.aceptaCookies = 'true';
            cajacookies.style.display = 'none';
        }

        /* ésto se ejecuta cuando la web está cargada */
        $(document).ready(function() {
            compruebaAceptaCookies();
        });
    </script>
</body>

</html>