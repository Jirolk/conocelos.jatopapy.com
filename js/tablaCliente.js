$(document).ready(function() {
    $('#tablaClientes').DataTable({
        // scrollX: true,
        // "scrollY": "100%", //para que aparezca la barra
        scrollCollapse: true,
        fixedColumns: false,
        //paging:false,
        //ordering:false,//para que la tabla no ordene automaticamente
        language: {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "info": "Del _START_ al _END_ dfe _TOTAL_ ",
            "infoEmpty": "Mostrando 0 registros de un total de 0.",
            "infoFiltered": "(Filtrados de un total de _MAX_ registros)",
            "infoPostFix": "(actualizados)",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "<b>Buscar:</b>",
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

        lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, "Todos"]
        ],
        iDisplayLength: 5,
        //dom: 'lBf',
        // dom: 'Blfrtip',
        dom: 'Bfrtip',
        buttons: [
            // 'copyHtml5',
            // {
            //      extend: "copyHtml5",
            //      name: "copyBtn",
            //      attr:{
            //           //id: "copyb"
            //           class:"btn btn-danger",
            //           style:"color:black;"
            //      },
            //      text: "<i class='fa fa-copy'> <b>Copiar</b></i>",
            //      titleAttr: 'Copiar',
            // },
            // // 'excelHtml5',
            // {
            //      extend: "excelHtml5",
            //      name: "excelBtn",
            //      attr:{
            //           class:"btn btn-danger",
            //           style:"color:black;"
            //      },
            //      text: "<i class='fa fa-table'><b> Exportar a Excel</b></i>",
            //      titleAttr: 'Excel',
            //      exportOptions: {
            //           columns: [0,1]
            //      }
            // },
            // // 'pdfHtml5',
            // {
            //      extend: "pdfHtml5",
            //      name: "pdfBtn",
            //      attr:{
            //           class:"btn btn-danger",
            //           style:"color:black;"
            //      },
            //      text: "<i class='fa fa-file-pdf-o'><b> Exportar a PDF</b></i>",
            //      titleAttr: 'pdf',
            //      tittle: 'PDF-CLIENTES',
            //      filename: 'Clientes-PDf',
            //     orientation: 'landscape',
            //      exportOptions: {
            //           columns: [0,1,2,3,4,5,6]
            //      },
            //      customize: function(doc){
            //           doc.content[1].table.widths=[
            //                '14%',
            //                '14%',
            //                '15%',
            //                '15%',
            //                '14%',
            //                '14%',
            //                '14%'
            //           ],
            //           doc['footer']= (function(page,pages){
            //                return {
            //                     columns:[
            //                          {
            //                               alignment:'center',
            //                               text: [
            //                                    {text: page.toString(), italics: true}, ' de ',
            //                                    {text: pages.toString(), italics: true}
            //                               ]
            //                          }
            //                     ],
            //                     margin: [10, 0]
            //                }
            //           });
            //      }
            // },

            {
                text: "<i class='fa fa-plus' aria-hidden='true'> <b>Nuevo Cliente</b> </i>",
                attr: {
                    class: "btn bt",
                    style: "color: white;"
                },
                action: function(e, dt, node, config) {
                    $('#Cli_modif').modal('hide');
                    $('#Cli_nuevo').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                    $("#accion").val("N");
                    $("#rucN").focus();
                }
            }
        ]
    });
});

function validarNum(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    tecla = String.fromCharCode(tecla);
    return /^[0-9\-]+$/.test(tecla);
}

function limpiarCampos() {
    document.getElementById("form_nuevo").reset();
    document.getElementById("form_mod").reset();
}

function cancelar() {
    alertify.confirm("Confirmación", "¿Desea cancelar la carga de datos y limpiar los campos?",
        function() {
            if ($("#accion").val() == "N") {
                alertify.error("Operación cancelada. Se limpiaron los campos");
                limpiarCampos();
            }
        },
        function() {
            alertify.error("Puede continuar con la carga de datos");
        }).set("labels", {
        ok: "SI",
        cancel: "NO"
    });
    $("#rucN").focus();
}

function validarCampos() {
    if ($("#accion").val() == "M") {
        if ($("#RucM").val().length < 6) {
            alertify.error("El Ruc debe tener como minimo 6 caracteres");
            $("#RucM").focus();
        } else if ($("#ClientesM").val().length < 5) {
            alertify.error("La Razon Social debe tener como minimo 5 caracteres");
            $("#ClientesM").focus();
        } else if ($("#DireccionM").val().length < 5) {
            alertify.error("La Dirección debe tener como minimo 5 caracteres");
            $("#DireccionM").focus();
        } else if ($("#TelefonoM").val().length < 8) {
            alertify.error("El telefono debe tener como minimo 8 digitos");
            $("#TelefonoM").focus();
        } else if ($("#CiuM").val() == "") {
            alertify.error("Seleccione una nacionalidad");
            $("#CiuM").focus();
        } else {
            actualizar();
        }
    } else {
        if ($("#RucN").val().length < 6) {
            alertify.error("El Ruc debe tener como minimo 6 caracteres");
            $("#RucN").focus();
        } else if ($("#clientesN").val().length < 5) {
            alertify.error("La Razon Social debe tener como minimo 5 caracteres");
            $("#clientesN").focus();
        } else if ($("#DireccionN").val().length < 5) {
            alertify.error("La Dirección debe tener como minimo 5 caracteres");
            $("#DireccionN").focus();
        } else if ($("#TelefonoN").val().length < 8) {
            alertify.error("El telefono debe tener como minimo 8 digitos");
            $("#TelefonoN").focus();
        } else if ($("#CiuN").val() == "") {
            alertify.error("Seleccione una nacionalidad");
            $("#CiuN").focus();
        } else {
            registrar();
        }
    }
}

function registrar() {
    ruc = $("#RucN").val();
    cli = $("#clientesN").val();
    dir = $("#DireccionN").val();
    tel = $("#TelefonoN").val();
    ciu = $("#CiuN").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/clienteServicios.php",
        data: "ruc=" + ruc + "&cli=" + cli + "&dir=" + dir + "&tel=" + tel + "&ciu=" + ciu + "&accion=N",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        // alert(resp);
        if (resp == 1) {
            alertify.error("El Cliente ingresado ya existe. Cambie por otro");
            $("#RucN").focus();
        } else if (resp == 2) {
            alertify.alert("Atención", "Los datos del Cliente fueron registrados con éxitos!!",
                function() {
                    location.reload();
                }
            );
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}

function obtenerIdEli() {
    //Capturar idCliente de la fila donde se hizo clic
    var fi = 0;
    var tabla = document.getElementById("tablaClientes");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            ruc = tabla.rows[fi].cells[0].innerHTML;
        }
    }
    alertify.confirm().set("labels", {
        ok: "SI",
        cancel: "NO"
    });
    alertify.confirm().set("defaultFocus", "cancel");
    alertify.dialog("confirm").set({
        transition: "flipx"
    });
    alertify.confirm("Eliminar registro", "¿Desea eliminar el registro?",
        function() { //SI
            eliminar(ruc);
        },
        function() { //NO
            alertify.error("Operación cancelada");
        }
    );
}

function eliminar(ruc) {
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/clienteServicios.php",
        data: "ruc=" + ruc + "&accion=E",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 5) {
            alertify.alert("Atención", "El registro del Cliente fue Eliminado",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 6) {
            alertify.alert("Atención", "El registro del Cliente no se puede eliminar debido a que ya se encuentra relacionada con otra tabla!!",
                function() {
                    location.reload();
                }
            );
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}

function obtenerIdModi() {
    $('#Cli_nuevo').modal('hide');
    $('#Cli_modif').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
    $("#accion").val("M");
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaClientes");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            $("#rucSM").val(id);
            $("#cliSM").val(tabla.rows[fi].cells[1].innerHTML);
            $("#dirSM").val(tabla.rows[fi].cells[2].innerHTML);
            $("#ciuSM").val(tabla.rows[fi].cells[5].innerHTML);
            $("#telSM").val(tabla.rows[fi].cells[4].innerHTML);

            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "../servicios/BuscarModCliente.php",
                data: "id=" + id,
            }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
                var porciones = resp.split(','); //separo
                $("#RucM").val(porciones[0]);
                $("#ClientesM").val(porciones[1]);
                $("#DireccionM").val(porciones[2]);
                $("#TelefonoM").val(porciones[3]);
                $("#CiuM").val(porciones[4]);

            }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
                alertify.error(resp);
            });
        }
    }
}

function actualizar() {
    rucM = $("#RucM").val();
    cliM = $("#ClientesM").val();
    dirM = $("#DireccionM").val();
    telM = $("#TelefonoM").val();
    ciuM = $("#CiuM").val();
    rucSM = $("#rucSM").val();
    dirSM = $("#dirSM").val();
    telSM = $("#telSM").val();
    ciuSM = $("#ciuSM").val();
    cliSM = $("#cliSM").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/clienteServicios.php",
        data: "ruc=" + rucM + "&cli=" + cliM + "&dir=" + dirM + "&tel=" + telM + "&ciu=" + ciuM + "&telSM=" + telSM + "&ciuSM=" + ciuSM + "&rucSM=" + rucSM + "&cliSM=" + cliSM + "&dirSM=" + dirSM + "&accion=M",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        // alert(resp);
        if (resp == 3) {
            alertify.error(" El cliente ingresado ya existe. Cambie por otro");
            $("#RucM").focus();
        } else if (resp == 4) {
            alertify.alert("Modificar", "Registro actualizado con éxito!!",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 7) {
            alertify.error("Debe Modificar aunque sea un campo!!");
            $("#RucM").focus();
        } else if (resp == 8) {
            alertify.error("El cliente NO se puede modificar porque ya se encuentra relacionada en otra tabla!!");
            $("#RucM").focus();
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}