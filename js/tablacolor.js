$(document).ready(function() {
    $('#tablaColor').DataTable({
        // scrollX: true,
        //"scrollY":"200px",para que aparezca la barra
        scrollCollapse: true,
        // fixedColumns: true,
        //paging:false,
        //ordering:false,//para que la tabla no ordene automaticamente
        language: {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "info": "Del _START_ al _END_ de _TOTAL_ ",
            "infoEmpty": "Mostrando 0 registros de un total de 0.",
            "infoFiltered": "(Filtrados de un total de _MAX_ registros)",
            "infoPostFix": "(actualizados)",
            "lengthMenu": "Mostrar _MENU_ registro&nbsp&nbsp&nbsp",
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
        // dom: 'lBf',
        dom: 'Blfrtip',
        buttons: [
            // 'copyHtml5',
            // {
            //     extend: "copyHtml5",
            //     name: "copyBtn",
            //     attr: {
            //         //id: "copyb"
            //         class: "btn btn-danger",
            //         style: "color:black;"
            //     },
            //     text: "<i class='fa fa-copy'> <b>Copiar</b></i>",
            //     titleAttr: 'Copiar',
            // },
            // 'excelHtml5',
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
            // 'pdfHtml5',
            {
                extend: "pdfHtml5",
                name: "pdfBtn",
                attr: {
                    class: "btn bt mb-3",
                    style: "color:white;"
                },
                text: "<i class='fa fa-file-pdf-o text bg-danger'></i>",
                titleAttr: 'Exportar a pdf',
                title: 'LISTA DE COLORES',
                filename: 'COLORES-PDf',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, ]
                },
                customize: function(doc) {
                    doc.content[1].table.widths = [
                            '50%',
                            '50%'


                        ],
                        doc['footer'] = (function(page, pages) {
                            return {
                                columns: [{
                                    alignment: 'center',
                                    text: [
                                        { text: page.toString(), italics: true }, ' de ',
                                        { text: pages.toString(), italics: true }
                                    ]
                                }],
                                margin: [10, 0]
                            }
                        });
                }
            },
            {
                text: "<i class='fa fa-plus' aria-hidden='true' > <b>Nuevo Color</b> </i>",
                attr: {
                    class: "btn bt mb-3",
                    style: "color:white;"
                },
                action: function(e, dt, node, config) {
                    $('#color_modif').modal('hide');
                    $('#color_nuevo').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                    $("#accion").val("N");
                    $("#color").focus();
                }
            }
        ]
    });
});

function limpiarCampos() {
    document.getElementById("form_nuevo").reset();
    document.getElementById("form_mod").reset();
}


function validarCampos() {
    if ($("#accion").val() == "M") {
        if ($("#color").val() == "") {
            alertify.error("Seleccione un Color");
            $("#color").focus();
        } else {
            actualizar();
        }
    } else {
        // alert("entra" + $("#colorN").val());
        // if ($("#accion").val() == "N") {
        if ($("#colorN").val() == "") {
            alertify.error("Seleccione un Color");
            $("#colorN").focus();
        } else {
            registrar();
        }
        // }
    }
}

function registrar() {
    color = $("#colorN").val();
    // pass = $("#pasN").val();
    // est = $("#estN").val();
    // fu = $("#funcN").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/coloresServicios.php",
        data: "color=" + color + "&accion=N",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        // alert(resp);
        if (resp == 1) {
            alertify.error("El color ingresado ya existe. Cambie por otro");
            $("#colorN").focus();
        } else if (resp == 2) {
            alertify.alert("Atención", "El registro de Color fue Registrado con éxito!",
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
    var id = 0;
    var tabla = document.getElementById("tablaColor");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            // Obtener el id(columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            // suc = tabla.rows[fi].cells[3].innerHTML;
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
    alertify.confirm("Eliminar registro", "¿Desea eliminar el registro del Color?",
        function() { //SI
            eliminar(id);
        },
        function() { //NO
            alertify.error("Operación cancelada");
        }
    );
}

function eliminar(id) {

    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/coloresServicios.php",
        data: "id=" + id + "&accion=E",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 6) {
            alertify.alert("Atención", "El registro del Color fue Eliminado",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 7) {
            alertify.alert("Atención", "Error al Eliminar, Color ya esta relacionada con otra tabla!",
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
    $('#color_nuevo').modal('hide');
    $('#color_modif').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
    $("#accion").val("M");
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaColor");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            // $("#rucSinModif").val(id);
            $("#colorsinM").val(tabla.rows[fi].cells[1].innerHTML);

            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "../servicios/BuscarModcolor.php",
                data: "id=" + id,
            }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
                // var porciones = resp.split(','); //separo
                // alert(id);
                $("#idcolor").val(id);
                $("#color").val(resp);

            }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
                alertify.error(resp);
            });
        }
    }
}

function actualizar() {
    id = $("#idcolor").val();
    color = $("#color").val();
    colosiM = $("#colorsinM").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/coloresServicios.php",
        data: "id=" + id + "&color=" + color + "&olosiM=" + colosiM + "&accion=M",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 3) {
            alertify.error("El Color ingresado ya existe, Intente nuevamente!!");
            $("#color").focus();
        } else if (resp == 4) {
            alertify.alert("Modificar", "Registro actualizado    con éxito",
                function() {
                    location.reload();
                }
            );
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}

function enter(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) {
        // alert("al darle enter");
        validarCampos();
    }
}