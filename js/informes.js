function habilitar(value) {
    var sele = document.getElementById("SelectBus");
    // alert(sele.options[sele.selectedIndex].value);
    if (sele.options[sele.selectedIndex].value == 1) {
        // alert("tabla");
        document.getElementById("CampoBusqueda").innerHTML = "<input id='tlb'class='form-control' placeholder='Tabla a buscar?'> "
        $("#tlb").focus();

    } else if (sele.options[sele.selectedIndex].value == 2) {
        // alert("Operaciones");
        document.getElementById("CampoBusqueda").innerHTML = "<input  id='opera' class='form-control' placeholder='N, M, E?'> "
        $("#opera").focus();
    } else if (sele.options[sele.selectedIndex].value == 3) {
        document.getElementById("CampoBusqueda").innerHTML = "<label for='fec1'class=''>Desde:</label><input  id='fec1' type='date' class='form-control'><label for='fec2' class=''>Hasta:</label><input  id='fec2' type='date' class='form-control mb-4'>"
        $("#fec1").focus();
    } else if (sele.options[sele.selectedIndex].value == 4) {
        document.getElementById("CampoBusqueda").innerHTML = "<input  id='use' class='form-control' placeholder='Nombre'> "
        $("#use").focus();
    }
}

function buscar() {
    tabla = $('#tablaAuditoria').DataTable();
    tabla.clear();
    if (document.getElementById('tlb')) {
        if ($("#tlb").val() == '') {
            alertify.error("El campo no puede estar Vacio");
            $('#tlb').focus();
        } else {
            consulta($("#tlb").val(), 'T');
        }

    } else if (document.getElementById('use')) {
        if ($('#use').val() == '') {
            alertify.error("El campo no puede estar Vacio");
            $('#use').focus();
        } else {
            consulta($("#use").val(), 'U');
        }
    } else if (document.getElementById('opera')) {
        if ($('#opera').val() == '') {
            alertify.error("El campo no puede estar Vacio");
            $('#opera').focus();
        } else {
            consulta($("#opera").val(), 'O');
        }
    } else if (document.getElementById('fec1') && document.getElementById('fec2')) {
        if ($('#fec1').val() == '') {
            alertify.error("Elija una fecha");
            $('#fec1').focus();
        } else if ($('#fec2').val() == '') {
            alertify.error("Elija una fecha");
            $('#fec2').focus();
        } else {
            // alert("Ahora empieza lo divertido");
            fec1 = $('#fec1').val();
            fec2 = $('#fec2').val();
            // alert(fec1 + fec2);
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "../servicios/informeServicio.php",
                data: "fec1=" + fec1 + "&fec2=" + fec2 + "&accion=F",
            }).done(function (resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
                if (resp == 3) {
                    alertify.error("No hay registros en esa fecha, vuelva a intentarlo");
                    $("#fec1").val("");
                    $("#fec2").val("");
                    $("#fec1").focus();
                } else {

                    for (var i in resp) {
                        var viejo = "<textarea cols='20' rows='3'>" + resp[i].viejo + "</textarea>";
                        var nuevo = "<textarea cols='20' rows='3'>" + resp[i].nuevo + "</textarea>";
                        var fecha = "<textarea cols='15' rows='3'>" + resp[i].fecha + "</textarea>";

                        tabla.row.add([resp[i].tabla, resp[i].operacion, viejo, nuevo, fecha, resp[i].user, resp[i].ip]).draw();
                    }


                };


            }).fail(function (resp) { //se ejecuta en que caso de que haya ocurrido algún error
                alertify.error(resp);
            });

        }
    } else {
        alertify.error("Elija una Opción primeramente");
    }

}

function consulta(consulta, accion) {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "../servicios/informeServicio.php",
        data: "user=" + consulta + "&accion=" + accion,
    }).done(function (resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 1) {
            alertify.error("La tabla no existe. Escriba nuevamente");
            $("#tlb").val("");
            $("#tlb").focus();
        } else if (resp == 2) {
            alertify.error("La operación ingresado no existe. Escriba nuevamente");
            $("#opera").val("");
            $("#opera").focus();
        } else if (resp == 4) {
            alertify.error("El Usuario ingresado no existe. Escriba nuevamente");
            $("#use").val("");
            $("#use").focus();
        } else {

            for (var i in resp) {
                var viejo = "<textarea cols='20' rows='3'>" + resp[i].viejo + "</textarea>";
                var nuevo = "<textarea cols='20' rows='3'>" + resp[i].nuevo + "</textarea>";
                var fecha = "<textarea cols='15' rows='3'>" + resp[i].fecha + "</textarea>";

                tabla.row.add([resp[i].tabla, resp[i].operacion, viejo, nuevo, fecha, resp[i].user, resp[i].ip]).draw();
            }


        };


    }).fail(function (resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}