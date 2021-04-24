$(document).ready(function() {
    $('#tablaInsumos').DataTable({
        // scrollX: true,
        // "scrollY": "100%", //para que aparezca la barra
        scrollCollapse: true,
        // fixedColumns: false,
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
                text: "<i class='fa fa-plus' aria-hidden='true'> <b>Nuevo Insumo</b> </i>",
                attr: {
                    class: "btn bt",
                    style: "color: white;"
                },
                action: function(e, dt, node, config) {
                    $('#ins_modif').modal('hide'); 
                    
                    $('#ins_nuevo').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                    $("#desN").focus();
                    $("#accion").val("N");
                    
                }
            }
        ]
    });
});


function modColor() {
    $('#color_nuevo').modal({ backdrop: 'static', keyboard: false, show: true });
}

function validarColor() {
        if ($("#color").val().length < 3) {
            alertify.error("El Color debe tener como minimo 3 digitos");
            $("#color").focus();
        } else {
            newcolor();
        }
}

function newcolor(){
    color = $("#color").val();
    $.ajax({
         type: "POST",
         dataType: 'html',
         url: "../servicios/coloresServicios.php",
         data: "color=" + color + "&accion=N",
    }).done( function(resp){ //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp== 1){
                alertify.error("El color ingresado ya existe. Cambie por otro");
                $("#color").focus();
        }else if (resp == 2) {
                alertify.alert("Atención", "El registro del Color fue Registrado con éxito!");
                $("color").val("");  
                agregarcolor(color);
         }
    }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
         alertify.error(resp);
    });
}


function agregarcolor(color){
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/nuevocolor.php",
         data: "",
   }).done( function(resp){ //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        // alert(resp);
        $('#color').append("<option uppercase value='"+resp 
        +"'>"+color+"</option>");
         $("#color").focus();
         $("#color_nuevo").modal('hide');
        //  }
   }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
   });
}

function limpiar() {
    $("#color").val("");
}

function limpiarCampos() {
    $("#desN").val("");
    $("#uniN").val("");
    $("#catN").val("");
    $("#colN").val("");
    $("#convN").val("");
    $("#precN").val("");
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
    $("#desN").focus();
}

 function validarCampos() {
     if ($("#accion").val() == "M") {
         if ($("#desM").val().length < 6) {
             alertify.error("La descripcion debe tener como minimo 6 caracteres");
             $("#desM").focus();
         } else if ($("#uniM").val() == "") {
              alertify.error("Seleccione una unidad de medida");
              $("#uniM").focus();
         }  else if ($("#catM").val() == "") {
             alertify.error("Seleccione una categoria");
             $("#catM").focus();
         }  else if ($("#colM").val() == "") {
                 alertify.error("Seleccione un color");
                 $("#colM").focus();
         }   else {
             actualizar();
         }
     } else {
         if ($("#desN").val().length < 6) {
             alertify.error("La descripcion debe tener como minimo 6 caracteres");
             $("#desN").focus();
         }else if ($("#uniN").val() == "") {
             alertify.error("Seleccione una unidad de medida");
             $("#uniN").focus();
         }  else if ($("#catN").val() == "") {
             alertify.error("Seleccione una categoria");
             $("#catN").focus();
         }  else if ($("#colN").val() == "") {
            alertify.error("Seleccione un color");
            $("#colN").focus();
    }else {
             registrar();
         }
     }
 }

function registrar() {
     if ($("#uniN").val() == "Metro") {
         con=100;
         document.getElementById('convN').value=con;
     }else if ($("#uniN").val() == "Litro") {
         con=1000;
         document.getElementById('convN').value=con;
     }else if ($("#uniN").val() == "Unidad") {
         con=1;
         document.getElementById('convN').value=con;
     }else if ($("#uniN").val() == "Gramo") {
         con=1000;
         document.getElementById('convN').value=con;
     }else if ($("#uniN").val() == "Resma") {
         con=500;
         document.getElementById('convN').value=con;
     }
    // id = $("#idinsN").val();
    des = $("#desN").val();
    // alert(des);
    uni = $("#uniN").val();
    // alert(uni);
    cat = $("#catN").val();
    // alert(cat);
    col = $("#colN").val();
    // alert(col);
    conv = $("#convN").val();
    // alert(conv);
    stoc=0;
    document.getElementById('stockN').value=stoc;
    sto = $("#stockN").val();
    // alert(sto);
    pre = $("#precN").val();
    // alert(pre);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/insumoServicios.php",
        data: "des=" + des + "&uni=" + uni + "&cat=" + cat + "&col=" + col + "&conv=" + conv + "&sto=" + sto + "&pre=" + pre + "&accion=N",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        //  alert(resp);
        if (resp == 1) {
            alertify.error("El insumo ingresado ya existe. Cambie por otro");
            $("#desN").focus();
        } else if (resp == 2) {
            alertify.alert("Atención", "Los datos del Insumo fueron registrados con éxitos!!",
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
    //Capturar id de la fila donde se hizo clic
    var fi = 0;
    var tabla = document.getElementById("tablaInsumos");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
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
        url: "../servicios/InsumoServicios.php",
        data: "id=" + id + "&accion=E",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        if (resp == 5) {
            alertify.alert("Atención", "El registro del Insumo fue Eliminado",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 6) {
            alertify.alert("Atención", "El registro del Insumo no se puede eliminar debido a que ya se encuentra relacionada con otra tabla!!",
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
    $('#ins_nuevo').modal('hide');
    $('#ins_modif').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
    $("#accion").val("M");
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaInsumos");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            $("#idinsumo").val(id);
            $("#desSM").val(tabla.rows[fi].cells[1].innerHTML);
            $("#uniSM").val(tabla.rows[fi].cells[2].innerHTML);
            $("#catSM").val(tabla.rows[fi].cells[3].innerHTML);
            $("#colSM").val(tabla.rows[fi].cells[4].innerHTML);
            $("#convSM").val(tabla.rows[fi].cells[5].innerHTML);
            // $("#stockSM").val(tabla.rows[fi].cells[6].innerHTML);
            $("#precSM").val(tabla.rows[fi].cells[7].innerHTML);

            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "../servicios/BuscarModInsumo.php",
                data: "id=" + id,
            }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
                //alert(resp);
                var porciones = resp.split(','); //separo
                $("#desM").val(porciones[0]);
                $("#uniM").val(porciones[1]);
                $("#catM").val(porciones[2]);
                $("#colM").val(porciones[3]);
                $("#convM").val(porciones[4]);
                // $("#stockM").val(porciones[5]);
                $("#precM").val(porciones[6]);

            }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
                alertify.error(resp);
            });
        }
    }
}

function actualizar() {
    if ($("#uniM").val() == "Metro") {
        con=100;
        document.getElementById('convM').value=con;
    }else if ($("#uniM").val() == "Litro") {
        con=1000;
        document.getElementById('convM').value=con;
    }else if ($("#uniM").val() == "Unidad") {
        con=1;
        document.getElementById('convM').value=con;
    }else if ($("#uniM").val() == "Gramo") {
        con=1000;
        document.getElementById('convM').value=con;
    }else if ($("#uniM").val() == "Resma") {
        con=500;
        document.getElementById('convM').value=con;
    }
    id = $("#idinsumo").val();
    // alert(id);
    desM = $("#desM").val();
    // alert(desM);
    uniM = $("#uniM").val();
    //  alert(uniM);
    catM = $("#catM").val();
    //  alert(catM);
    colM = $("#colM").val();
    //  alert(colM);
    convM = $("#convM").val();
    //  alert(convM);
    // stockM = $("#stockM").val();
    //  alert(stockM);
    precM = $("#precM").val();
    //  alert(precM);
    desSM = $("#desSM").val();
    // alert(desSM);
    uniSM = $("#uniSM").val();
    // alert(uniSM);
    catSM = $("#catSM").val();
    // alert(catSM);
    colSM = $("#colSM").val();
    // alert(colSM);
    convSM = $("#convSM").val();
    // alert(convSM);
    // stockSM = $("#stockSM").val();
    // alert(stockSM);
    precSM = $("#precSM").val();
    // alert(precSM);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/insumoServicios.php",
        data: "id=" + id +"&desM=" + desM + "&uniM=" + uniM + "&catM=" + catM + "&colM=" + colM + "&convM=" + convM + "&precM=" + precM + "&desSM=" + desSM + "&uniSM=" + uniSM + "&catSM=" + catSM + "&colSM=" + colSM + "&convSM=" + convSM + "&precSM=" + precSM + "&accion=M",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
    //    alert(resp);
        if (resp == 3) {
            alertify.error(" El insumo ingresado ya existe. Cambie por otro");
            $("#desM").focus();
        } else if (resp == 4) {
            alertify.alert("Modificar", "Registro actualizado con éxito!!",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 7) {
            alertify.error("Debe Modificar aunque sea un campo!!");
            $("#desM").focus();
        } else if (resp == 8) {
            alertify.error("El insumo NO se puede modificar porque ya se encuentra relacionada en otra tabla!!");
            $("#desM").focus();
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}