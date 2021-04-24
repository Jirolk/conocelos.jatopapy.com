$(document).ready(function() {
    $('#tablaFuncionarios').DataTable({
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
            //      tittle: 'PDF-FUNCIONARIO',
            //      filename: 'Funcionario-PDf',
            //      // orientation: 'landscape',
            //      exportOptions: {
            //           columns: [0,1,2,3,4,5]
            //      },
            //      customize: function(doc){
            //           doc.content[1].table.widths=[
            //                '10%',
            //                '40%',
            //                '15%',
            //                '15%',
            //                '10%',
            //                '10%'
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
                text: "<i class='fa fa-plus' aria-hidden='true' > <b>Nuevo Funcionario</b> </i>",
                attr: {
                    class: "btn bt mb-3",
                    style: "color:white;"
                },
                action: function(e, dt, node, config) {
                    $('#Funcionario_modif').modal('hide');
                    $('#Funcionario_nuevo').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                    $("#accion").val("N");
                    $("#Nci").focus();
                }
            }
        ]
    });
});

function limpiarCampos() {
    $("#Mci").val("");
    $("#Nci").val("");
    $("#Mnombre").val("");
    $("#Nnombre").val("");
    // $("#Msex").val("");
    // $("#Nsex").val("");
    // $("#Mfnac").val("");
    // $("#Nfnac").val("");
    $("#Mtel").val("");
    $("#Ntel").val("");
    $("#Mdireccion").val("");
    $("#Ndireccion").val("");
    // $("#idban").val("");
    $("#FuncionarioSinModif").val("");
}

function registrar() {
    id = $("#Nci").val();
    fun = $("#Nnombre").val();
    // sex = $("#Nsex").val();
    // nac = $("#Nfnac").val();
    tel = $("#Ntel").val();
    dire = $("#Ndireccion").val();
    // alert(id + fun + tel + dire);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/funcionarioServicios.php",
        data: "id=" + id + "&fun=" + fun + "&dire=" + dire + "&tel=" + tel + "&accion=N",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 1) {
            alertify.error("El Funcionario ingresado ya existe. Cambie por otro");
            $("#Nci").focus();
        } else if (resp == 2) {
            alertify.alert("Atención", "El registro fue Registrado con éxito!",
                function() {
                    location.reload();
                }
            );
        } else {
            alertify.error(resp);
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}

function validarced(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    tecla = String.fromCharCode(tecla);
    return /^[0-9]+$/.test(tecla);
}

function validartel(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    tecla = String.fromCharCode(tecla);
    return /^[0-9]+$/.test(tecla);
}
// function validarnom(e){
//      let isValid = false;
//      const input = document.forms['validationForm']['letras'];
//      //input.willValidate = false;
//      const pattern = new RegExp('^[A-Z]+$', 'i');
//      if(!input.value){
//           isValid=false;
//      }else if(!pattern.test(input.value)){
//                isValid=false;
//      }else {
//           isValid=true;
//      }
// }

function validarCampos() {
    if ($("#accion").val() == "N") {
        if ($("#Nci").val().length < 6 || $("#Nci").val().length > 8) {
            alertify.error("Ingrese como mínimo entre 6 a 8 dígitos");
            $("#Nci").focus();
        } else if ($("#Nnombre").val().length < 3) {
            alertify.error("Ingrese como mínimo 3 dígitos");
            $("#Nnombre").focus();
        } else if ($("#Ndireccion").val() == "") {
            alertify.error("Ingrese una Dirección");
            $("#Ndireccion").focus();
        } else if ($("#Ntel").val().length < 6) {
            alertify.error("Ingrese como mínimo 6 dígitos");
            $("#Ntel").focus();
        } else {
            registrar();
        }
    } else {
        if ($("#Mnombre").val().length < 3) {
            alertify.error("Ingrese como mínimo 3 dígitos");
            $("#Mnombre").focus();
        } else if ($("#Mdireccion").val() == "") {
            alertify.error("Ingrese una Dirección");
            $("#Mdireccion").focus();
        } else if ($("#Mtel").val().length < 6) {
            alertify.error("Ingrese como mínimo 6 dígitos");
            $("#Mtel").focus();
        } else {
            actualizar();
        }
    }

}

function obtenerIdEli() {
    //Capturar idCliente de la fila donde se hizo clic
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaFuncionarios");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            suc = tabla.rows[fi].cells[5].innerHTML;
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
            eliminar(id, suc);
        },
        function() { //NO
            alertify.error("Operación cancelada");
        }
    );
}

function eliminar(id, ) {

    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/funcionarioServicios.php",
        data: "id=" + id + "&accion=E",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        // alert(resp);
        if (resp == 8) {
            alertify.alert("Atención", "El registro del Funcionario fue Eliminado",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 7) {
            alertify.alert("Atención", "Error al Eliminar, Funcionario ya esta relacionada con otra tabla!",
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
    id = $("#idfun").val(); //sinmodificar
    ci = $("#Mci").val();
    fun = $("#Mnombre").val();
    // sex = $("#Msex").val();
    nac = $("#Mdireccion").val();
    tel = $("#Mtel").val();

    //csm = $("#ciSM").val();
    // ssm = $("#sexSM").val();
    nsm = $("#nacSM").val(); //direccion
    tsm = $("#telSM").val();
    fsm = $("#FuncionarioSinModif").val();
    // alert("Dirección sin modificar: " + nsm + "Mdirección:" + nac);
    // data = $("#Funcionario_modif").serialize();
    // alert("datos Serializado: " + data);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/funcionarioServicios.php",
        data: "id=" + id + "&ci=" + ci + "&fun=" + fun + "&dire=" + nac +
            "&tel=" + tel + "&fsm=" + fsm + "&tsm=" + tsm + "&direm=" + nsm + "&accion=M",

    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        // alert(resp);
        if (resp == 3) {
            alertify.error("Funcionario Ingresado ya existe, Intente nuevamente!!");
            $("#Mnombre").focus();
        } else if (resp == 4) {
            alertify.error("Debe modificar el Funcionario!!");
            $("#Mnombre").focus();
        } else if (resp == 5) {
            alertify.alert("Modificar", "Registro actualizado con éxito",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 6) {
            alertify.alert("Modificar", "Error al modificar, Funcionario ya esta en una transaccion y no se puede modificar..lo siento!!",
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
    $('#Funcionario_nuevo').modal('hide');
    $('#Funcionario_modif').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
    $("#accion").val("M");
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaFuncionarios");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            $("#Mci").val(id);
            //$("#Mci").val(tabla.rows[fi].cells[0].innerHTML);
            // $("#Msex").val(tabla.rows[fi].cells[2].innerHTML);
            $("#Mnombre").val(tabla.rows[fi].cells[1].innerHTML);
            // $("#Msex").val(tabla.rows[fi].cells[2].innerHTML);
            $("#Mdireccion").val(tabla.rows[fi].cells[3].innerHTML);
            $("#Mtel").val(tabla.rows[fi].cells[2].innerHTML);
            suc = tabla.rows[fi].cells[5].innerHTML;
            //window.location="marcas_am.php?accion=M&id="+id;
            $("#idfun").val(id);
            // alert(id);
            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "../servicios/BuscarModFun.php",
                data: "id=" + id,
            }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
                // alert(resp);
                var parte = resp.split(',');
                $("#ciSM").val(parte[0]);
                $("#FuncionarioSinModif").val(parte[1]);
                // $("#sexSM").val(parte[2]);
                $("#telSM").val(parte[2]); //telefono
                $("#nacSM").val(parte[3]); //dirección
                // a = $("#ciSM").val();
                // b = $("#FuncionarioSinModif").val();
                // c = $("#telSM").val(); //telefono
                // d = $("#nacSM").val(); //dirección
                // alert("Traido del array CI:" + a + "Nombre: " + b + "Telefono: " + c + "Dirección: " + d) + "\n" + resp;
                // $("#Mdireccion").val(parte[3]);
            }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
                alertify.error(resp);
            });
        }
    }
}