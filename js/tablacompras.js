// scrollX: true,
// "scrollY": "200px",
// para que aparezca la barra
//paging:false,
//ordering:false,//para que la tabla no ordene automaticamente
$(document).ready(function() {
    $('#tablaCompras').DataTable({
        scrollCollapse: true,
        scrollX:true,
        // fixedColumns: false,
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
        dom: 'Blfrtip',
        buttons: [

            {
                text: "<i class='fa fa-plus' aria-hidden='true'> <b>Nueva Compra</b> </i>",
                attr: {
                    class: "btn tc mb-3",
                    style: "color:black;",
                    id: "nuevo"
                },
                action: function(e, dt, node, config) {
                    if ($("#idCaja").val() == 0 || $("#idCaja").val() == "") {
                        window.location = "cajasAcciones_lista.php?menu=COMPRA";
                    } else {
                        window.location = "compra_cab_am.php?accion=N";
                    }
                }
            },
            {
                text: "<i class='fa fa-table' aria-hidden='true'> <b>Pago de Compras</b> </i>",
                attr: {
                    class: "btn tc mb-3",
                    style: "color:black;"
                },
                action: function(e, dt, node, config) {
                    if ($("#caja").val() == 0) {
                        alertify.confirm("Pago de Compras", "Para realizar esta operación debe realizar la apertura de caja!",
                        function() { //SI
                            window.location = "cajasAcciones_lista.php?menu=COMPRA";
                        },
                        function() { //NO
                            alertify.error("Operación cancelada");
                        }
                        );
                    } else {
                        window.location = "pagoCredito_compras.php";
                    }
                }
            }
        ]
    });
});

function mod() {
    if($("#niv").val() == "Administrador"){
        if ($("#caja").val() == 0) {
            alertify.confirm("Anular Compras", "Para realizar esta operación debe realizar la apertura de caja!",
            function() { //SI
                window.location = "cajasAcciones_lista.php?menu=COMPRA";
            },
            function() { //NO
                alertify.error("Operación cancelada!");
            }
            );
        }else{
            var tabla = document.getElementById("tablaCompras");
            var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            for (i = 0; i < filas.length; i++) {
                filas[i].onclick = function() {
                    //Obtener el id (columna oculta)
                    fi = this.rowIndex;
                    id = tabla.rows[fi].cells[0].innerHTML;
                    est = tabla.rows[fi].cells[5].innerHTML;
                    if (est == "Anulado") {
                        alertify.error("Compra ya fué ANULADA!!Seleccione otro..");
                    } else {
                        $("#observacion").val("");
                        $("#modalObs").modal();
                        document.getElementById("fila").value = fi;
                    }
    
                }
            }
            
        }
    }else{
        alertify.error("No tiene el permiso para realizar esta operación");
    }
}

function validar() {
    if ($("#observacion").val().length >= 10) {
        $('#modalObs').modal('hide');
        fila = document.getElementById("fila").value;
        obtenerId(fila);
    } else {
        alertify.error("Debe ingresar mínimo de 10 caracteres");
    }
}

function obtenerId(fila) {
    var tabla = document.getElementById("tablaCompras");
    alertify.confirm().set("labels", {
        ok: "SI",
        cancel: "NO"
    });
    alertify.confirm().set("defaultFocus", "cancel");
    alertify.dialog("confirm").set({
        transition: "flipx"
    });
    alertify.confirm("Anular registro", "¿Desea anular el registro de la Compra?",
        function() { //SI
            id = tabla.rows[fila].cells[0].innerHTML;
            est = tabla.rows[fila].cells[7].innerHTML;
            condi = tabla.rows[fila].cells[5].innerHTML;
            if (est == "Anulado") {
                alertify.error("Compra ya fué ANULADA!!Seleccione otro..");
            } else {
                anular(id, condi);
            }
        },
        function() { //NO
            alertify.error("Operación cancelada");
        }
    );
}

function obtenerIdAnu() {
    //Capturar idCliente de la fila donde se hizo clic
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaCompras");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            est = tabla.rows[fi].cells[8].innerHTML;
            condi = tabla.rows[fi].cells[5].innerHTML;
            if (est == "Anulado") {
                alertify.error("Compra ya fué ANULADA!!Seleccione otro..");
            } else {
                alertify.confirm().set("labels", {
                    ok: "SI",
                    cancel: "NO"
                });
                alertify.confirm().set("defaultFocus", "cancel");
                alertify.dialog("confirm").set({
                    transition: "flipx"
                });
                alertify.confirm("Anular registro", "¿Desea anular el registro de la Compra?",
                    function() { //SI
                        anular(id, condi);
                        //alert("hola");
                    },
                    function() { //NO
                        alertify.error("Operación cancelada");
                    }
                );
            }
        }
    }
}

function obtenerIdDeta() {
    //Capturar idCliente de la fila donde se hizo clic
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaCompras");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            window.location = "compra_det_lista.php?accion=D&id=" + id;
        }
    }
}

function anular(id, condi) {
    obs = $("#observacion").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/compraServicios.php",
        data: "id=" + id + "&accion=A&observacion=" + obs + "&condicion=" + condi,
    }).done(function(resp) {
        if (resp == 3) {
            alertify.alert("Atención", "El registro de la Compra fue ANULADO!",
                function() {
                    location.reload();
                }
            );

        } else if (resp == 4) {
            alertify.error("Error al Anular, compra ya fue pagada parcialmente o totalmente y no se puede anular!");
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
};