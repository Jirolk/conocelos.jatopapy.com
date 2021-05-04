
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
  <link href="css/roque.css" rel="stylesheet">
  <!-- Font-Adswesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  
  <!-- Data table -->
  <link rel="stylesheet" href="css/datatables.min.css">
 
</head>

<body id="page-top ">

  <!-- Page Wrapper -->
  <div id="wrapper" class="">

    <!-- Sidebar -->
    <ul class="navbar-nav roque sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon ">

          <img class="img-fluid"  src="img/LogoFinal.png" alt="logo">
          <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3"> CONÓCELOS </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-home"></i>
          <span>Home</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <!-- <div class="sidebar-heading">
        Interface
      </div> -->

      <!-- Nav Item - Pages Collapse Menu -->
     

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="" data-target="#Geneinfo" aria-expanded="true" aria-controls="Geneinfo">
        <i class="fas fa-search"></i>
          <span>Buscador</span>
        </a>
       
      </li> 
      <li class="nav-item">
      
      <input list="buscar" class="form-control" autocomplete="off"  id="ibuscar" onchange="buscarCan();">
      <datalist name="buscar" id="buscar" >
            <?php
                // require_once("../servicios/conexion.php");
                // $conex = conexion();
                // $sql = "SELECT Ruc,Razon_social FROM proveedores WHERE Cod_sucursal=".$_SESSION['Cod_sucursal'];
                // $res = mysqli_query($conex, $sql);
                // while ($row = mysqli_fetch_array($res)) {
                //   echo '  <option value="'.$row["Ruc"].'">'.$row["Razon_social"].'</option>';
                // }
            ?>
      </datalist>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="contenido/movimientos.php" data-toggle="" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-users"></i>
          <span>Perfiles de Candidatos</span>
        </a>
        
      </li>
      <!-- nav Item Informes -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="" data-target="#Geneinfo" aria-expanded="true" aria-controls="Geneinfo">
          <i class="fas fa-list fa-sm"></i>
          <span>Comparador de Perfiles</span>
        </a>
       
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="" data-target="#Geneinfo" aria-expanded="true" aria-controls="Geneinfo">
        <i class="fas fa-search"></i>
          <span>Buscador</span>
        </a>
       
      </li> 
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="" data-target="#Geneinfo" aria-expanded="true" aria-controls="Geneinfo">
        <i class="fas fa-scroll"></i>
        <span>Consentimiento</span>
        </a>
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-info-circle"></i>
        <span>Conocenos</span>
        </a>
       
      </li>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column fondocont ">

      <!-- Main Content -->
      <div id="content" class=" bgrimg ">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

           <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            
            <!-- Nav Item - Alerts -->
            

            <!-- Nav Item - User Information -->
  
          </ul>

        </nav>
        <!-- End of Topbar -->