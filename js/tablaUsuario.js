$(document).ready(function() {
    $('#tablaUsuarios').DataTable({
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
                title: 'LISTA DE USUARIOS',
                filename: 'Usuario-PDf',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, ]
                },
                customize: function(doc) {
                    doc.content[1].table.widths = [
                            '25%',
                            '25%',
                            '25%',
                            '25%'

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
                text: "<i class='fa fa-plus' aria-hidden='true' > <b>Nuevo Usuario</b> </i>",
                attr: {
                    class: "btn bt mb-3",
                    style: "color:white;"
                },
                action: function(e, dt, node, config) {
                    $('#Usuario_modif').modal('hide');
                    $('#Usuario_nuevo').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                    $("#accion").val("N");
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
    // else if ($("#pasM").val().length < 4) {
    //     alertify.error("La Contraseña debe tener como mínimo 4 carácteres");

    // $("#pasM").focus();
    if ($("#accion").val() == "M") {
        if ($("#ifunM").val() == "") {
            alertify.error("Seleccione un Funcionario");
            $("#ifunM").focus();
        } else if ($("#estM").val() == "") {
            alertify.error("Seleccione un Estado");
            $("#estM").focus();
        } else if ($("#funcM") == "") {
            alertify.error("Seleccione un Funcion");
            $("#funcM").focus();
        } else {
            actualizar();
        }
    } else {
        //alert("entra");
        if ($("#ifunN").val() == "") {
            alertify.error("Seleccione un Funcionario");
            $("#ifunN").focus();
        } else if ($("#pasN").val().length < 4) {
            alertify.error("La Contraseña debe tener como mínimo 4 carácteres");
            $("#pasN").focus();
        } else if ($("#estN").val() == "") {
            alertify.error("Seleccione un Estado");
            $("#estN").focus();
        } else if ($("#funcN") == "") {
            alertify.error("Seleccione una Funcion");
            $("#funcN").focus();
        } else {
            registrar();
        }
    }
}

function valpass() {
    pas = $('#contraseña').val();
    var mayuscula = false;
    var minuscula = false;
    var numero = false;
    var caracter_raro = false;
    for (var i = 0; i < pas.length; i++) {
        if (pas.charCodeAt(i) >= 65 && pas.charCodeAt(i) <= 90) {
            mayuscula = true;
        } else if (pas.charCodeAt(i) >= 97 && pas.charCodeAt(i) <= 122) {
            minuscula = true;
        } else if (pas.charCodeAt(i) >= 48 && pas.charCodeAt(i) <= 57) {
            numero = true;
        } else {
            caracter_raro = true;
        }
    }
    if (mayuscula == true && minuscula == true && numero == true) { //&& caracter_raro == true
        return true;
    } else {
        return false;
    }
}

function registrar() {
    func = $("#ifunN").val();
    pass = $("#pasN").val();
    est = $("#estN").val();
    fu = $("#funcN").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/usuarioServicios.php",
        data: "func=" + func + "&pass=" + pass + "&est=" + est + "&fu=" + fu + "&accion=N",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        // alert(resp);
        if (resp == 1) {
            alertify.error("El Usuario ingresado ya existe. Cambie por otro");
            $("#ifuncN").focus();
        } else if (resp == 2) {
            alertify.alert("Atención", "El registro del Usuario fue Registrado con éxito!",
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
    var tabla = document.getElementById("tablaUsuarios");
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
    alertify.confirm("Eliminar registro", "¿Desea eliminar el registro del Usuario?",
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
        url: "../servicios/usuarioServicios.php",
        data: "id=" + id + "&accion=E",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 5) {
            alertify.alert("Atención", "El registro del Usuario fue Eliminado",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 6) {
            alertify.alert("Atención", "Error al Eliminar, Usuario ya esta relacionada con otra tabla!",
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
    $('#Usuario_nuevo').modal('hide');
    $('#Usuario_modif').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
    $("#accion").val("M");
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaUsuarios");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            // $("#rucSinModif").val(id);
            $("#ifunsm").val(tabla.rows[fi].cells[1].innerHTML);
            // alert(tabla.rows[fi].cells[1].innerHTML);
            $("#paSinModif").val(tabla.rows[fi].cells[2].innerHTML);
            $("#estsm").val(tabla.rows[fi].cells[4].innerHTML);
            $("#fusm").val(tabla.rows[fi].cells[5].innerHTML);
            // $("#suc").val(tabla.rows[fi].cells[3].innerHTML);
            suc = $("#suc").val();
            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "../servicios/BuscarModUsuario.php",
                data: "id=" + id,
            }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
                var porciones = resp.split(','); //separo
                // alert(resp);
                $("#idusu").val(porciones[0]);
                $("#pasM").val(porciones[1]);
                $("#estM").val(porciones[2]);
                $("#funcM").val(porciones[3]);
                $("#ifunM").val(porciones[4]);
                // $("#ifunM").val('hola');
                // document.getElementById('ifunM').value = porciones[4];
                // a = $("#idusu").val(); //ide
                // e = $("#ifunM").val();
                // b = $("#pasM").val(); //estado
                // c = $("#estM").val();
                // d = $("#funcM").val();
                // alert(a + b + c + d + e);
            }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
                alertify.error(resp);
            });
        }
    }
}

function actualizar() {
    id = $("#idusu").val();
    func = $("#ifunM").val();
    pass = $("#pasM").val();

    est = $("#estM").val();
    fu = $("#funcM").val();
    fsm = $("#ifunsm").val();
    psm = $("#paSinModif").val();
    esm = $("#estsm").val();
    fusm = $("#fusm").val();
    suc = $("#suc").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/usuarioServicios.php",
        data: "id=" + id + "&func=" + func + "&pass=" + pass + "&est=" + est + "&fu=" + fu + "&fsm=" + fsm + "&psm=" + psm + "&esm=" + esm + "&fusm=" + fusm + "&suc=" + suc + "&accion=M",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 3) {
            alertify.error("El Usuario ingresado ya existe, Intente nuevamente!!");
            $("#ifunM").focus();
        } else if (resp == 4) {
            alertify.alert("Modificar", "Registro actualizado    con éxito",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 7) {
            alertify.error("Debe Modificar aunque sea un campo!!");
            $("ifunM").focus();
        } else if (resp == 8) {
            alertify.error("El Usuario No se puede modificar por que ya se encuentra relacionada con otra tabla!!");
            $("ifunM").focus();
        } else if (resp == 9) {
            alertify.error("Debe ingresar una contraseña diferente.");
            $("pasN").focus();
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}