
$(document).ready(function () {
    $('#tablaCajas').DataTable({
        scrollX: true,
        //"scrollY":"200px",para que aparezca la barra
        scrollCollapse: true,
        fixedColumns: true,
        language: {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "info": "Del _START_ al _END_ de _TOTAL_ ",
            "infoEmpty": "Mostrando 0 registros de un total de 0.",
            "infoFiltered": "(Filtrados de un total de _MAX_ registros)",
            "infoPostFix": "(actualizados)",
            "lengthMenu": "Mostrar _MENU_ registro&nbsp&nbsp&nbsp",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "searchPlaceholder": "Dato para buscar",
            "zeroRecords": "No se han encontrado coincidencias.",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": "Ordenación ascendente",
                "sortDescending": "Ordenación descendente"
            }
        },

        lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Todos"]],
        iDisplayLength: 5,
        //dom: 'lBf',
        dom: 'lfrtip',

    });
});
function mod() {
    var tabla = document.getElementById("tablaCajas");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function () {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            nro = tabla.rows[fi].cells[1].innerHTML;
            caj = tabla.rows[fi].cells[0].innerHTML;
            estado = tabla.rows[fi].cells[2].innerHTML;
            if (estado == "Activo") {
                $("#modalcaja").modal();
                document.getElementById("cajaID").value = nro;
                document.getElementById("fila").value = fi;
                $("#monto").val("");
                $("#monto").focus();
            } else {
                var rol = document.getElementById("niv").value;
                var usuario = document.getElementById("usu").value;
                if(rol == "Administrador"){
                    var f = new Date();
                    var fhoy = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
                    $.ajax({
                            type: "POST",
                            dataType: 'html',
                            url: "../servicios/busqueda.php",
                            data: "criterio=idcaja&valor="+caj+"&tabla=caja_detalle&busqueda=MAX(fecha_apertura) fec,idusuario",
                    }).done( function(resp){
                        
                            var porciones = resp.split(',');//separo
                            fe = new Date(porciones[0]);
                            usu = porciones[1];
                            afe =  fe.getFullYear() + "-" + (fe.getMonth() +1) + "-" + fe.getDate();
                             //alert(fe+""+f);
                            if(f > fe){
                            //   alert("fecha superior");
                                    var confirm = alertify.confirm("Atención","Caja no fue cerrada en fecha: "+afe+"!! Desea realizar el Arqueo y Cierre de Caja?", function(){ //callbak al pulsar botón positivo
                                        $.ajax({
                                            type: "POST",
                                            dataType: 'html',
                                            url: "../servicios/cajaOcupada.php",
                                            data: "caja=" + caj+"&estado=Ocupado&nro="+nro+"&monto=0",
                                        }).done( function(resp){
                                            window.location="arqueoAcciones_lista.php";
                                        }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
                                            alertify.error(resp);
                                        });
                                    },function(){ //callbak al pulsar botón negativo
                                        alertify.error('Operación Cancelada!');
                                    });
                            }else if(fhoy == afe){//si es la misma fecha y el mismo usuario para continuar la operacion
                                if(usuario == usu){
                                    var confirm = alertify.confirm("Atención", "Desea continuar con las operaciones de la caja en fecha: "+afe+"?",  function(){ //callbak al pulsar botón positivo
                                        $.ajax({
                                            type: "POST",
                                            dataType: 'html',
                                            url: "../servicios/cajaOcupada.php",
                                            data: "caja=" + caj+"&estado=Ocupado&nro="+nro+"&monto=0",
                                        }).done( function(resp){
                                            var men = document.getElementById("dir").value;
                                            window.location=men+"s.php";
                                        }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
                                            alertify.error(resp);
                                        });
                                    },function(){
                                        alertify.error("Operación cancelada");
                                    });
                                }else{
                                    alertify.error("Caja abierta por otro usuario! No puede continuar las operaciones!");
                                }
                            }else{
                                alert("fecha caduca");
                            }

                    }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
                            alertify.error(resp);
                    });
                } else {
                    alertify.error("No tiene el permiso para realizar el Arqueo y Cierre de Caja!!");
                }

            }

        }
    }
}
function validar() {
    if ($("#monto").val() >= 200000) {
        $('#modalcaja').modal('hide');
        fila = document.getElementById("fila").value;
        monto = document.getElementById("monto").value;
        obtenerId(fila, monto);
    } else {
        alertify.error("Debe ingresar monto de apertura superior  o igual a 200.000 GS.");
    }
}
function obtenerId(fila, monto) {
    var tabla = document.getElementById("tablaCajas");
    nro = tabla.rows[fila].cells[1].innerHTML;
    caja = tabla.rows[fila].cells[0].innerHTML;
    estado = tabla.rows[fila].cells[2].innerHTML;
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/cajaOcupada.php",
        data: "caja=" + caja + "&estado=Activo&nro=" + nro + "&monto=" + monto,
    }).done(function (resp) {
        // alert(resp);
        var men = document.getElementById("dir").value;
        // window.location = men + "_cab_lista.php";
        window.location = men + "s.php";
    }).fail(function (resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}
