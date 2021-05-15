</div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="row">
          <div class="container my-auto">

              <div class="copyright text-center text-dark my-auto">
                <span>Copyright &copy; AIRES 2021</span>
              </div>
              
            <!-- </div>
            <div class="container my-auto col-md-4 col-xl-3 mb-4"> -->
              <div class="copyright text-center text-dark my-auto" >
              <a class="copyright text-center  text-dark" href="index.php">
                <span >Politica de Privacidad</span>
                </a>
              <!-- <div>
              <div class="copyright text-center text-dark my-auto"> -->
                <span> - </span>
                <a class="copyright text-center  text-dark" href="../index.php"><span>Politica de Cookies</span></a>
              </div>
            </div>
          </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery-3.4.1.min.js"></script>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <!-- <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script> -->
  
  <!-- Data Table -->
  <script src="../js/datatables.min.js"></script>
  <!-- botones -->
  <script src="../js/botones/buttons.html5.min.js"></script>
  <script src="../js/botones/jszip.min.js"></script>
  <script src="../js/botones/buttons.print.min.js"></script>
  <script src="../js/botones/pdfmake.min.js"></script>
  <script src="../js/botones/vfs_fonts.js"></script>
  <script src="../contenido/jsComparador/select2.min.js"></script>
  <script src="../js/alertify.min.js"></script>
  <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
        $.ajax({
        type: "POST",
        dataType: 'json',
        url: "../contenido/buscarAgus.php",
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
    </script>
</body>

</html>
