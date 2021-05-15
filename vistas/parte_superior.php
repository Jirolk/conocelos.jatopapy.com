
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="img/LogoFinal.png" />
  <title>CONÓCELOS</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.css" rel="stylesheet">
  <!-- color roque -->
  <!-- <link href="css/roque.css" rel="stylesheet"> -->
  <!-- Font-Adswesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  
  <!-- Data table -->
  <link rel="stylesheet" href="css/datatables.min.css">
</head>
<body id="page-top ">
  <div id="wrapper" class="wrapper">
      <nav id="sidebar" class="sidebar roque" >

                <ul class="list-unstyled components">
                  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                    <div class="sidebar-brand-icon ">

                      <img class="img-fluid"  src="img/LogoFinal.png" alt="logo">
                    </div>
                    <div class="sidebar-brand-text text-white h6 mx-3"> CONÓCELOS </div>
                  </a>
                  <br>
                    <!-- <p>Dummy Heading</p> -->
                    <hr class="sidebar-divider my-0">

                <li class="nav-item  ">
                  <a class="nav-link " href="index.php">
                    <i  class="fas fa-home" style="color: white;"></i>
                    <span class="text-white">Home</span></a>
                </li>

                <hr class="sidebar-divider">
                <li class="nav-item  ">
                
                  
                </li>

                <li class="nav-item  ">
                  <a class="nav-link " href="contenido/movimientos.php" >
                  <i class="fas fa-users" style="color: white;"></i>
                    <span class="text-white">Perfiles de Candidatos</span>
                  </a>
                  
                </li>
               
                <li class="nav-item  ">
                  <a class="nav-link collapsed" href="./contenido/comparador.php" data-toggle="" data-target="#Geneinfo" aria-expanded="true" aria-controls="Geneinfo">
                    <i class="fas fa-list fa-sm" style="color: white;"></i>
                    <span class="text-white">Comparador de Perfiles</span>
                  </a>
                
                </li>
                <li class="nav-item  ">
                  <a class="nav-link "  >
                  <i class="fas fa-scroll" style="color: white;"></i>
                  <span class="text-black" style="color: white;">Consentimiento</span>
                  </a>
                  <li class="nav-item  ">
                  <a class="nav-link " >
                    <i class="fas fa-info-circle" style="color: white;"></i>
                    <span class="text-white">Conocenos</span>
                  </a>
                </li>
                <hr class="sidebar-divider ">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center  justify-items-center">
                  <button style="color: white;" class="rounded-circle border-0 d-none d-sm-block " id="sidebarToggle"></button>
                </div>

      </nav>

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column fondocont ">
    
      <!-- Main Content -->
      <div id="content" class=" bgrimg ">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <div class="input-group input-group-sm mb-3" id="buscador">
                <select style="opacity:0.5;" class="form-control text-uppercase text-center col col-md-12" name="bus" id="bus" autofocus onchange="selCan(value)">
                
                </select>
                </div>
    
          <button id="sidebarCollapse" type="button" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars" style="color: black;"></i>
          </button>

           <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">


  
          </ul>

        </nav>
        <!-- End of Topbar -->
        
        <script type="text/javascript">
  $.ajax({
        type: "POST",
        dataType: 'json',
        url: "contenido/buscarAgus.php",
        data: "candi=all",
    }).done(function(resp) { 
        if (resp == 1) {

            alertify.error("Lo sentimos no hay resultado en su busqueda :(");
        } else {
            $("#bus").append(`
            <option value="0"> Buscar Candidato </option>`);
            for (var i in resp) {
                $("#bus").append(`
                <option value="` + resp[i].cod + `">` + resp[i].nom + `-Lista `+resp[i].lis+`</option>`);
            };


        };
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error("Problemas con la base de datos");
    });

$("#bus").select2();
$("#bus").css({"opacity":"0.5"});
function selCan(value){
  location.href="contenido/perfilcandidato.php?id="+value;
}
</script>