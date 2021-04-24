$(document).ready(function() {
    $('#tablaCategoria').DataTable({
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
        //dom: 'lBf',
        dom: 'Blfrtip',
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
            //      tittle: 'PDF-BANCO',
            //      filename: 'Bancos-PDf',
            //      // orientation: 'landscape',
            //      exportOptions: {
            //           columns: [0,1]
            //      },
            //      customize: function(doc){
            //           doc.content[1].table.widths=[
            //                '50%',
            //                '50%'
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
                text: "<i class='fa fa-plus' aria-hidden='true' > <b>Nueva Categoria</b> </i>",
                attr: {
                    class: "btn bt mb-3",
                    style: "color: white;"
                },
                action: function(e, dt, node, config) {
                    $('#Ciudad_modif').modal('hide');
                    $('#Ciudad_nuevo').modal({ backdrop: 'static', keyboard: false, show: true });
                    $("#accion").val("N");
                }
            }
        ]
    });
});

function limpiarCampos() {
    $("#ciudadN").val("");
    $("#ciudadM").val("");
    $("#accion").val("");
    $("#idCiudad").val("");
    $("#ciudadSM").val("");
}

function registrar() {
    ciudad = $("#ciudadN").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/categoriaServicios.php",
        data: "ciudad=" + ciudad + "&accion=N",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 1) {
            alertify.error("La categoria ingresada ya existe. Cambie por otra");
            $("#ciudadN").focus();
        } else if (resp == 2) {
            alertify.alert("Atención", "El registro de la Categoria fue Registrado con éxito!",
                function() {
                    location.reload();
                }
            );
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}

function validarCampos() {
    if ($("#accion").val() == "N") {
        if ($("#ciudadN").val().length < 3) {
            alertify.error("Ingrese como mínimo 3 dígitos en Categoria");
            $("#ciudadN").focus();
        } else {
            registrar();
        }
    } else {
        if ($("#ciudadM").val().length < 3) {
            alertify.error("Ingrese como mínimo 3 dígitos en Categoria");
            $("#ciudadM").focus();
        } else {
            actualizar();
        }
    }

}

function obtenerIdEli() {
    //Capturar idCliente de la fila donde se hizo clic
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaCategoria");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
        }
    }
    alertify.confirm().set("labels", { ok: "SI", cancel: "NO" });
    alertify.confirm().set("defaultFocus", "cancel");
    alertify.dialog("confirm").set({ transition: "flipx" });
    alertify.confirm("Eliminar registro", "¿Desea eliminar el registro de la Categoria?",
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
        url: "../servicios/categoriaServicios.php",
        data: "id=" + id + "&accion=E",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 6) {
            alertify.alert("Atención", "El registro de la Categoria fue Eliminado",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 7) {
            alertify.alert("Atención", "Error al Eliminar, la Categoria ya esta relacionada con otra tabla!",
                function() {
                    location.reload();
                }
            );
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}

function actualizar() {
    id = $("#idCiudad").val();
    ciudad = $("#ciudadM").val();
    ciudadSM = $("#ciudadSM").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/categoriaServicios.php",
        data: "id=" + id + "&ciudad=" + ciudad + "&ciudadSM=" + ciudadSM + "&accion=M",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 3) {
            alertify.error("La Categoria ingresada ya existe, Intente nuevamente!!");
            $("#ciudadM").focus();
        } else if (resp == 4) {
            alertify.error("Debe modificar la Categoria!!");
            $("#ciudadM").focus();
        } else if (resp == 5) {
            alertify.alert("Modificar", "Registro actualizado con éxito",
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
    $('#Ciudad_nuevo').modal('hide');
    $('#Ciudad_modif').modal({ backdrop: 'static', keyboard: false, show: true });
    $("#accion").val("M");
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaCategoria");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            $("#idCiudad").val(id);
            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "../servicios/BuscarModCategoria.php",
                data: "id=" + id,
            }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
                $("#ciudadM").val(resp);
                $("#ciudadSM").val(resp);
            }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
                alertify.error(resp);
            });
        }
    }
}