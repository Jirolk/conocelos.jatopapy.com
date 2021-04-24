document.getElementById('titulo').innerHTML = 'COMPRAS';
document.title = 'Compras';
document.getElementById("iva5").value = 0;
document.getElementById("iva10").value = 0;
document.getElementById("exenta").value = 0;
document.getElementById("total").value = 0;
document.getElementById("totaliva5").value = 0;
document.getElementById("totaliva10").value = 0;
document.getElementById("montof").value = 0;
document.getElementById("montos").value = 0;
document.getElementById("montoc").value = 0;

function calcular() {
    can = parseInt(document.getElementById("canti").value);
    tot = parseInt(document.getElementById("saldoc").value);
    mon = Math.round(tot / can);
    sum = mon * can;
    if (sum > tot) {
        dif = sum - tot;
        document.getElementById("montos").value = dif;
        document.getElementById("montof").value = 0;
    } else if (sum < tot) {
        dif = tot - sum;
        document.getElementById("montos").value = 0;
        document.getElementById("montof").value = dif;
    } else {
        document.getElementById("montos").value = 0;
        document.getElementById("montof").value = 0;
        document.getElementById("montoc").value = 0;
    }
    document.getElementById("montoc").value = mon;
}

function cal() {
    ent = parseInt(document.getElementById("entrega").value);
    tot = parseInt(document.getElementById("totCompra").value);
    if (ent == null || ent == 0 || ent == "") {
        document.getElementById("entrega").value = 0;
        ent= 0;
    }
    mon = parseInt(tot - ent);
    document.getElementById("saldoc").value = mon;
    if (mon <= 0) {
        alertify.error("Entrega supera al Total, Debe ser inferior");
    } else if (ent == null || ent == 0) {
        document.getElementById("saldoc").value = tot;
    }
    calcular();
}

function busProv() {
    $('#BuscarProv').modal({ backdrop: 'static', keyboard: false, show: true });
}

function modProv() {
    $('#Prov_nuevo').modal({ backdrop: 'static', keyboard: false, show: true });
}

function validarProv() {
    if ($("#RucN").val().length < 6) {
        alertify.error("El Ruc debe tener como minimo 6 digitos");
        $("#RucN").focus();
    } else if ($("#proveedoresN").val().length < 5) {
        alertify.error("La Razon Social debe tener como minimo 5 caracteres");
        $("#proveedoresN").focus();
    } else if ($("#TelefonoN1").val().length < 8) {
        alertify.error("El telefono debe tener como minimo 8 digitos");
        $("#TelefonoN1").focus();
    } else if ($("#iciu").val() == "") {
        alertify.error("Debe seleccionar Ciudad!");
        $("#iciu").focus();
    } else {
        //registrarProv();
        newProveedor();
    }
}
/*function validarInsumo(){
    if($("#insumo").val()==""){
         alertify.error("Introduzca el nombre del insumo");
         $("#insumo").focus();
    }else if ($("#costo").val()<=0){
         alertify.error("El costo del insumo debe ser mayor a 0");
         $("#costo").focus();
    }else if ($("#costo").val() ==""){
         alertify.error("Introduzca el costo del insumo");
         $("#costo").focus();
    }else if ($("#categoria").val()==""){
         alertify.error("Seleccione una categoria");
         $("#categoria").focus();
    }else if ($("#marca").val() == ""){
         alertify.error("Seleccione una marca");
         $("#marca").focus();
    }else if ($("#iva").val()==""){
         alertify.error("Seleccione el I.V.A.");
         $("#iva").focus();
    }else{
      registrarInsumo();
     }
}*/
/*function registrarInsumo(){
  insu = $("#insumo").val();
  stck = $("#stck").val();
  marc = $("#marca").val();
  costo = $("#costo").val();
  cat = $("#categoria").val();
  iva = $("#ivai").val();
  $.ajax({
       type: "POST",
       dataType: 'html',
       url: "../servicios/insumoServicios.php",
       data: "insu=" + insu+"&stck="+stck + "&marc="+marc+ "&costo="+costo+"&cat="+cat+"&iva="+iva+ "&accion=N",
  }).done( function(resp){
       if (resp == 1){
            alertify.error("El Insumo ingresado ya existe. Cambie por otro");
            $("#insumo").focus();
       }else if (resp == 15) {
           alertify.success("Los datos del Insumo fueron registrados con éxitos!!");
           $("#Insumo_nuevo").modal('hide');
           buscarInsu();
       }
  }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
       alertify.error(resp);
  });
}*/
function validarNum(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    tecla = String.fromCharCode(tecla);
    if (tecla == 13) {
        validarCampos();
    }
    return /^[0-9\-]+$/.test(tecla);
}
/*function buscarInsu(){
  insu = $("#insumo").val();
  stck = $("#stck").val();
  marc = $("#marca").val();
  costo = $("#costo").val();
  cat = $("#categoria").val();
  suc = $("#sucursal").val();
  iva = $("#ivai").val();
  $.ajax({
       type: "POST",
       dataType: 'html',
       url: "../servicios/busqueda.php",
       data: "criterio=Insumo&valor="+insu+"&tabla=insumo&busqueda=Id",
  }).done( function(resp){
    $("#cod").append('<option value="'+resp+'">'+insu.toUpperCase()+'</option>');
    var t = $('#tablaInsumo').DataTable();
    i = '<td class="text-center" style="cursor:pointer" onclick="obtenerIdI()"><i class="fa fa-check text-center" style="cursor:pointer" onclick="obtenerIdI()"></i></td>';
    t.row.add([resp,insu,costo,iva,stck,cat,suc,i]).draw(false);
    $("#insumo").val("");
    $("#stck").val("");
    $("#marca").val("");
   $("#costo").val("");
     $("#categoria").val("");
    $("#ivai").val("");
  }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
       alertify.error(resp);
  });
}*/

function obtenerIdI() {
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaInsumo");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            $("#icod").val(id);
            $("#articulo").val(tabla.rows[fi].cells[1].innerHTML); //RECUPERAR los datos para los campos del insumo luego nuevo
            $("#precio").val(tabla.rows[fi].cells[2].innerHTML); //RECUPERAR los datos para los campos del insumo luego nuevo
            //$("#iva").val(tabla.rows[fi].cells[3].innerHTML);//RECUPERAR los datos para los campos del insumo luego nuevo
            $('#BuscarInsumo').modal('hide');
        }
    }
}

function obtenerId() {
    var fi = 0;
    var id = 0;
    var tabla = document.getElementById("tablaProveedores");
    var filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < filas.length; i++) {
        filas[i].onclick = function() {
            //Obtener el id (columna oculta)
            fi = this.rowIndex;
            id = tabla.rows[fi].cells[0].innerHTML;
            $("#iruc").val(id);
            $("#razon").val(tabla.rows[fi].cells[1].innerHTML);
            $('#BuscarProv').modal('hide');
        }
    }
}

function newProveedor() {
    ruc = $("#RucN").val();
    prov = $("#proveedoresN").val();
    dir = $("#DireccionN").val();
    tel1 = $("#TelefonoN1").val();
    tel2 = $("#TelefonoN2").val();
    ciu = $("#iciu").val();
    //var val = document.getElementById('iciu').value;
    var city = "";
    var opts = document.getElementById('ciu').childNodes;
    for (var i = 0; i < opts.length; i++) {
        if (opts[i].value !== undefined) {
            if (opts[i].value === ciu) {
                // document.getElementById('cust_name').innerText = opts[i].innerText;
                city = opts[i].innerText;
                break;
            }
        }
    }
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/proveedorServicios.php",
        data: "ruc=" + ruc + "&prov=" + prov + "&tel1=" + tel1 + "&tel2=" + tel2 + "&dir=" + dir + "&ciu=" + ciu + "&accion=N",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriament
        if (resp == 1) {
            alertify.error("El Proveedor ingresado ya existe. Cambie por otro");
            $("#RucN").focus();
        } else if (resp == 2) {
            alertify.success("Proveedor registrado con éxito!!")
            $('#Prov_nuevo').modal('hide');
            $("#ruc").append('<option value="' + ruc + '">' + prov.toUpperCase() + '</option>');
            var t = $('#tablaProveedores').DataTable();
            i = '<td class="text-center" style="cursor:pointer" onclick="obtenerId()"><i class="fa fa-check text-center" style="cursor:pointer" onclick="obtenerId()"></i></td>';
            t.row.add([ruc, prov, tel1, tel2, dir, city, i]).draw(false);
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
    $("#RucN").val("");
    $("#proveedoresN").val("");
    $("#TelefonoN1").val("");
    $("#TelefonoN2").val("");
    $("#DireccionN").val("");
    $("#iciu").val("");
}
$(document).ready(function() {
    var table = $('#tablaProveedores').DataTable({
        // scrollCollapse: true,
        //    scrollX: true,
        //    fixedColumns: false,
        language: {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "info": "Del _START_ al _END_ de _TOTAL_ ",
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
        dom: 'lfrtip'
    });
});
$(document).ready(function() {
    $('#tablaInsumo').DataTable({
        //    scrollCollapse: true,
        //    scrollX: true,
        // fixedColumns:true,
        //    autoWidth: true,
        //    columnDefs: [ //para ajustar tamaño del dataTables
        //        { "width": "10%", "targets": [0] },
        //        { "width": "30%", "targets": [2] },
        //        { "width": "10%", "targets": [1, 3, 4, 5, 6], "className": "dt-body-right" },
        //        { "width": "10%", "targets": [7], "className": "dt-body-center" }
        //    ],
        language: {
            "emptyTable": "No hay datos disponibles en la tabla.",
            "info": "Del _START_ al _END_ de _TOTAL_ ",
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
        dom: 'lfrtip'
    });
});
$(document).ready(function() {
    $('#tablaDetalle').DataTable({
        //scrollX: true,
        //    "scrollY": "200px", //para que aparezca la barra
        //scrollCollapse: true,
        //fixedColumns:true,
        //    paging: false,
        autoWidth: false,
        columnDefs: [ //para ajustar tamaño del dataTables
            { "width": "10%", "targets": [2, 3] },
            { "width": "40%", "targets": [1] },
            { "width": "10%", "targets": [4, 5, 6, 7], "className": "dt-body-right" },
            { "width": "10%", "targets": [8], "className": "dt-body-center" },
            { "targets": [0], "visible": false, "searchable": false }
        ],
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
            //   "paginate": {
            //       "first": "Primera",
            //       "last": "Última",
            //       "next": "Siguiente",
            //       "previous": "Anterior"
            //   },
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
        dom: 'l'
            //dom: 'Blfrtip',
    });
});

function format(input) {
    var num = input.value.replace(/\./g, '');
    if (!isNaN(num)) {
        num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
        num = num.split('').reverse().join('').replace(/^[\.]/, '');
        input.value = num;
    } else {
        alert('Solo se permiten numeros');
        input.value = input.value.replace(/[^\d\.]*/g, '');
    }
    alertify.error(input.value * 5);
}

function buscarRuc() {
    ruc = $("#iruc").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/busqueda.php",
        data: "criterio=ruc&valor=" + ruc + "&tabla=proveedores&busqueda=razon_social",
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriament
        document.getElementById("razon").value = resp;
        $("#icod").focus();
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}



function registrarCuotas(){
     fact = $("#factura").val();
     can = $("#canti").val();
     ent = $("#entrega").val();
     fec = $("#fechaV").val();
     fecC = $("#fecha").val();
     mon = $("#montoc").val();
     mons = $("#montos").val();
     monf = $("#montof").val();
     $.ajax({
          type: "POST",
          dataType: 'html',
          url: "../servicios/generarCred.php",
          data: "idFact="+fact+"&cantidad=" + can +"&fec=" + fecC + "&entrega=" + ent +"&fecha=" + fec +"&monto=" + mon+"&mons="+mons+"&monf="+monf,
     }).done( function(resp){
          if (resp == 1){
           //  registrar();
          }
     }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
          alertify.error(resp);
     });
}

function registrar() {
    nro = $("#factura").val();
    fec = $("#fecha").val();
    ruc = $("#iruc").val();
    detalle = $("#detalle").val();
    totIva5 = $("#totaliva5").val();
    totIva10 = $("#totaliva10").val();
    total = $("#total").val();
    cond = $("#condicion").val();
    efe = $("#efectivo").val();
    che = $("#cheque").val();
    vuelto = $("#vuelto").val();
    tarj = $("#tarjeta").val();
    if (cond == "Contado") {
        var tabla = $("#tablaFormaPago").DataTable();
        var canFilas = tabla.page.info().recordsTotal;
        var array = new Array();
        var pos = 0;
        for (i = 0; i < canFilas; i++) {
            data = tabla.row(i).data();
            tipo = data[0];
            array[pos] = tipo;
            pos = pos + 1;

            iden = data[1];
            array[pos] = iden;
            pos = pos + 1;

            ban = data[2];
            array[pos] = ban;
            pos = pos + 1;

            mon = data[3];
            array[pos] = mon;
            pos = pos + 1;
        }
        //Convertir el array en String y almacenar en un campo oculto
        document.getElementById("detalleContado").value = array.toString();
        var detalleContado = document.getElementById("detalleContado").value;
    }
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/compraServicios.php",
        data: "fecha=" + fec + "&condicion=" + cond + "&vuelto="+vuelto+"&factura=" + nro + "&ruc=" + ruc + "&detalle=" + detalle + "&totIva5=" + totIva5 + "&totIva10=" + totIva10 + "&total=" + total + "&detalleContado=" + detalleContado + "&efectivo=" + efe + "&cheque=" + che + "&tarjeta=" + tarj + "&accion=N",
    }).done(function(resp) {
        if (resp == 1) {
            alertify.error("Ya existe un registro con el Número Factura y Fecha ingresada. Cambie por otro");
            $("#factura").focus();
        } else if (resp == 2) {
            if (cond == "Contado") {
                exportarPDF();
            }else{
                registrarCuotas();
            }
            alertify.alert("Atención", "Se registró la Compra!",
                function() {
                    location.reload();
                }
            );
        } else if (resp == 4) {
            alertify.error("No tiene suficiente dinero en Caja para realizar la Operación!");
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}
function limpiarCampos() {
    $("#factura").val("");
    $("#fecha").val("");
    $("#iruc").val("");
    $("#razon").val("");
    $("#detalle").val("");
    var table = $('#tablaDetalle').DataTable();
    table.clear().draw();
    document.getElementsByName('condicion')[0].checked = true;
    document.getElementById("iva5").value = 0;
    document.getElementById("iva10").value = 0;
    document.getElementById("totaliva").value = 0;
    document.getElementById("exenta").value = 0;
    document.getElementById("total").value = 0;
    $("#factura").focus();
}

function validarCampos() {
    var table = $('#tablaDetalle').DataTable();
    var can = table.page.info().recordsTotal;
    var f = new Date();
    m = f.getMonth() + 1;
    d = f.getDate();
    if (m < 10) {
        m = "0" + m;
    }
    if (d < 10) {
        d = "0" + d;
    }
    var fhoy = f.getFullYear() + "-" + m + "-" + d;
    if ($("#factura").val().length < 7 || $("#factura").val().length > 15) {
        alertify.error("Ingrese N° Factura correcta!!");
        $("#factura").focus();
    } else if ($("#fecha").val() == "") {
        alertify.error("Seleccione Fecha!!");
        $("#fecha").focus();
    } else if ($("#fecha").val() > fhoy) {
        alertify.error("La fecha no debe superar a la fecha de HOY!!");
        $("#fecha").focus();
    } else if ($("#iruc").val() == "" || $("#razon").val() == "") {
        alertify.error("Seleccione Ruc!!");
        $("#iruc").focus();
    } else if (can < 1) {
        alertify.error("Debe registrar mínimo un artículo!!");
        $("#icod").focus();
    } else {
        var tabla = $("#tablaDetalle").DataTable();
        var canFilas = tabla.page.info().recordsTotal;
        var array = new Array();
        var pos = 0;
        for (i = 0; i < canFilas; i++) {
            data = tabla.row(i).data();
            accion = data[0];
            array[pos] = accion;
            pos = pos + 1;

            cod = data[1];
            array[pos] = cod;
            pos = pos + 1;

            art = data[2];
            array[pos] = art;
            pos = pos + 1;

            can = data[3];
            array[pos] = can;
            pos = pos + 1;

            if (data[4] != 0) {
                pre = data[4];
                iva = 'Exenta';
            } else if (data[5] != 0) {
                pre = data[5];
                iva = 5;
            } else if (data[6] != 0) {
                pre = data[6];
                iva = 10;
            }
            array[pos] = pre;
            pos = pos + 1;

            array[pos] = iva;
            pos = pos + 1;

            sub = data[7];
            array[pos] = sub;
            pos = pos + 1;
        }
        //Convertir el array en String y almacenar en un campo oculto
        document.getElementById("detalle").value = array.toString();
        if ($("#condicion").val() == "Contado") {
            $("#modalPago").modal({ backdrop: 'static', keyboard: false, show: true });
            tot = $("#total").val();
            $("#Cobro").val(tot);
            $("#saldo").val(tot);
            $("#efectivo").focus();
        } else if ($("#condicion").val() == "Crédito") {
            $("#modalGene").modal({ backdrop: 'static', keyboard: false, show: true });
            tot = $("#total").val();
            fec = $("#fecha").val();
            $("#totCompra").val(tot);
            $("#saldoc").val(tot);
            $("#fechaC").val(fec);
            calcular();
        }
    }
}

function cancelar() {
alertify.confirm("Confirmación", "¿Desea cancelar la carga de datos y limpiar los campos?",
    function() {
        if ($("#accion").val() == "N") {
            alertify.error("Operación cancelada. Se limpiaron los campos");
            limpiarCampos();
        } else if ($("#accion").val() == "M") {
            alertify.alert("Atención", "Operación cancelada",
                function() {
                    window.location = "compra_cab_lista.php";
                }
            );
        }

    },
    function() {
        alertify.error("Puede continuar con la carga de datos");
    }).set("labels", { ok: "SI", cancel: "NO" });
    $("#factura").focus();
}

function cancelar() {
    alertify.confirm("Confirmación", "¿Desea cancelar la carga de datos y limpiar los campos?",
        function() {
            alertify.error("Operación cancelada. Se limpiaron los campos");
            limpiarCampos();

        },
        function() {
            alertify.error("Puede continuar con la carga de datos");
        }).set("labels", { ok: "SI", cancel: "NO" });
}

//PARTE DE Pago
//===============================================================================//
const number = document.querySelector('.number');

function formatNumber(n) {
    n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
}
number.addEventListener('keyup', (e) => {
    const element = e.target;
    const value = element.value;
    element.value = formatNumber(value);
});
$('#tablaFormaPago').DataTable({
    "scrollY": "200px", //para que aparezca la barra
    paging: false,
    autoWidth: false,
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
    // iDisplayLength:			5,
    dom: 'l'
        //dom: 'Blfrtip',
});


function restar() {
    var ef = $("#efectivo").val();
    var che = $("#cheque").val();
    var tar = $("#tarjeta").val();
    var tot = $("#Cobro").val();
    var vue = $("vuelto").val();
    var total = 0;
    var sal = 0;
    if (tot == null || tot == undefined || tot == "" || tot < 0) {
        tot = 0;
        document.getElementById('spTotal').value = tot;
    }
    if (ef == null || ef == undefined || ef == "" || ef < 0) {
        ef = 0;
        document.getElementById('efectivo').value = ef;
    }
    if (che == null || che == undefined || che == "" || che < 0) {
        che = 0;
        document.getElementById('cheque').value = che;
    }
    if (tar == null || tar == undefined || tar == "" || tar < 0) {
        tar = 0;
        document.getElementById('tarjeta').value = tar;
    }
    total = (parseInt(ef) + parseInt(che) + parseInt(tar));
    saldo = tot - total;
    if (saldo < 0) {
        vuelto = saldo * (-1);
        saldo = 0;
        document.getElementById('vuelto').value = vuelto;
    } else {
        vuelto = 0;
        document.getElementById('saldo').value = saldo;
    }
    document.getElementById('vuelto').value = vuelto;
    document.getElementById('saldo').value = saldo;
    $("#efectivo").focus();
}


function PagoRealizado() {
    var tot = $("#saldo").val();
    if (tot == 0) {
        registrar();
    } else if (tot < 0) {
        alertify.error("Error. Saldo Negativo!");
        $("#efectivo").focus();
    } else {
        alertify.error("Debe abonar todo la deuda!!");
        $("#efectivo").focus();
    }
}

function cargarFormadePago() {

    var che2 = $("#montocheque").val();
    var tar2 = $("#montotarjeta").val();
    var nroc = $("#nrocheque").val();
    var nrot = $("#nrotarjeta").val();
    var ban = 0;

    if ((tar2 == null || tar2 == undefined || tar2 == "" || tar2 < 0) && (che2 == null || che2 == undefined || che2 == "" || che2 < 0)) {
        alertify.error('campos vacios');
        $("#montocheque").focus();
    } else if ((!(che2 == "")) && (!(tar2 == ""))) {

        if ($("#cheBanco").val() == "") {
            alertify.error('Seleccione un Banco');
            $("#cheBanco").focus();
        } else if ($("#nrocheque").val() == "") {
            alertify.error('Ingrese un Nro. de Cuenta');
            $("#nrocheque").focus();
        } else if (che2 < 0) {
            alertify.error('Monto invalido');
            $("#montocheque").focus();
        } else if ($("#tarBanco").val() == "") {
            alertify.error('Seleccione un Banco');
            $("#tarBanco").focus();
        } else if ($("#nrotarjeta").val() == "") {
            alertify.error('Ingrese un Nro. de Cuenta');
            $("#nrotarjeta").focus();
        } else if (tar2 < 0) {
            alertify.error('Monto invalido');
            $("#montotarjeta").focus();
        } else if ($("#tipotarj").val() == "") {
            alertify.error('Que tipo de tarjeta posee?');
            $("#tipotarj").focus();
        } else {

            var chban = $('#cheBanco').val();
            var chban1 = $('#cheBanco option:selected').text();

            var chnro = $('#nrocheque').val();
            var chmon = $('#montocheque').val();
            var z = $('#tablaFormaPago').DataTable();
            var ti = "Cheque";
            y = '<i class="fa fa-trash-o" style="cursor:pointer;text-align:center;" onclick="preguntaPago(this);"></i>';

            var tarban = $('#tarBanco').val();
            var ban1 = $('#tarBanco option:selected').text();
            var tarnro = $('#nrotarjeta').val();
            var tarmon = $('#montotarjeta').val();
            var tarje = document.getElementById('tipotarj').value;
            var w = $('#tablaFormaPago').DataTable();
            var tip = "Tarjeta " + tarje;
            bt = '<i class="fa fa-trash-o" style="cursor:pointer;text-align:center;" onclick="preguntaPago(this);"></i>';

            w.row.add([tip, tarnro, ban1, tarmon, bt]).draw(false);
            z.row.add([ti, chnro, chban1, chmon, y]).draw(false);
            valoc = 0;
            valot = 0;
            valoc = parseInt($('#cheque').val()) + parseInt(che2);
            valot = parseInt($('#tarjeta').val()) + parseInt(tar2);
            document.getElementById('cheque').value = valoc;
            document.getElementById('tarjeta').value = valot;

            $('#montocheque').val('');
            $('#nrocheque').val('');
            $('#montotarjeta').val('');
            $('#nrotarjeta').val('');
            $('#cheBanco').val('');
            $('#montocheque').val('');
            $('#nrocheque').val('');
            $('#montotarjeta').val('');
            $('#nrotarjeta').val('');
            $('#tarBanco').val('');
            $("#tipotarj").val('');
            restar();
            $("#efectivo").focus();
        }

    } else if (!(che2 == "")) {

        if ($("#cheBanco").val() == "") {
            alertify.error('Seleccione un Banco');
            $("#cheBanco").focus();
        } else if ($("#nrocheque").val() == "") {
            alertify.error('Ingrese un Nro. de Cuenta');
            $("#nrocheque").focus();
        } else if (che2 < 0) {
            alertify.error('Monto invalido');
            $("#montocheque").focus();
        } else {


            var chban = $('#cheBanco').val();
            var chban1 = $('#cheBanco option:selected').text();

            var chnro = $('#nrocheque').val();
            var chmon = $('#montocheque').val();
            var z = $('#tablaFormaPago').DataTable();
            var ti = "Cheque";
            y = '<i class="fa fa-trash-o" style="cursor:pointer;text-align:center;" onclick="preguntaPago(this);"></i>';
            // var fila= '<tr><td>Cheque</td><td>'+chnro+'</td><td>'+chban+'</td><td>'+chmon+'</td><td>'+y+'</td></tr>';
            // $('#tablaFormaPago').append(fila);
            z.row.add([ti, chnro, chban1, chmon, y]).draw(false);
            var valoc = parseInt($('#cheque').val()) + parseInt(che2);
            document.getElementById('cheque').value = valoc;
            $('#montocheque').val('');
            $('#nrocheque').val('');
            $('#montotarjeta').val('');
            $('#nrotarjeta').val('');
            $('#cheBanco').val('');
            restar();
            $("#efectivo").focus();
        }
    } else if (!(tar2 == "")) {

        if ($("#tarBanco").val() == "") {
            alertify.error('Seleccione un Banco');
            $("#tarBanco").focus();
        } else if ($("#nrotarjeta").val() == "") {
            alertify.error('Ingrese un Nro. de Cuenta');
            $("#nrotarjeta").focus();
        } else if (tar2 < 0) {
            alertify.error('Monto invalido');
            $("#montotarjeta").focus();
        } else if ($("#tipotarj").val() == "") {
            alertify.error('Que tipo de tarjeta posee?');
            $("#tipotarj").focus();
        } else {
            var tarban = $('#tarBanco').val();
            var ban1 = $('#tarBanco option:selected').text();
            var tarnro = $('#nrotarjeta').val();
            var tarmon = $('#montotarjeta').val();
            var tarje = document.getElementById('tipotarj').value;

            var z = $('#tablaFormaPago').DataTable();
            var tip = "Tarjeta " + tarje;
            bt = '<i class="fa fa-trash-o" style="cursor:pointer;text-align:center;" onclick="preguntaPago(this);"></i>';

            z.row.add([tip, tarnro, ban1, tarmon, bt]).draw(false);
            var valot = parseInt($('#tarjeta').val()) + parseInt(tar2);

            document.getElementById('tarjeta').value = valot;
            $('#montocheque').val('');
            $('#nrocheque').val('');
            $('#montotarjeta').val('');
            $('#nrotarjeta').val('');
            $('#tarBanco').val('');
            $("#tipotarj").val('');
            restar();
            $("#efectivo").focus();
        }
    } //fin


} //fin de la funcion cargar tablaFormaPago

/*function registarPago(){
    nro = $("#factura").val();
    fec = $("#fecha").val();
    ruc = $("#iruc").val();
    detalle = $("#detalle").val();
    totIva5 = $("#totaliva5").val();
    totIva10 = $("#totaliva10").val();
    total = $("#total").val();
    cond = $("#condicion").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/compraServicios.php",
        data: "fecha=" + fec + "&condicion=" + cond +"&factura=" + nro +"&ruc=" + ruc +"&detalle=" + detalle+"&totIva5="+totIva5+"&totIva10="+totIva10+"&total="+total+"&accion=N",

    }).done( function(resp){
        if (resp == 1){
            alertify.error("Ya existe un registro con el Número Factura y Fecha ingresada. Cambie por otro");
            $("#factura").focus();
        }else if (resp == 2) {
        //exportarPDF();
            alertify.alert("Atención", "Se registró la Compra!",
                function(){
                    location.reload();
                }
            );
        }else if(resp == 4){
            alertify.error("No tiene suficiente dinero en Caja para realizar la Operación!");
        }
    }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}*/
function exportarPDF() {
    //detalle = $("#detalle").val();
    idfac = $("#factura").val();
    fec = $("#fecha").val();
    //idestadia = $("#idestadia").val();
    window.open("../servicios/PDFpagoServicios3.php?fac=" + idfac+"&fec="+fec);

}

function preguntaPago(bot) {
    alertify.confirm().set("labels", { ok: "SI", cancel: "NO" });
    alertify.confirm().set("defaultFocus", "cancel");
    alertify.dialog("confirm").set({ transition: "flipx" });
    alertify.confirm("Quitar Forma de Pago", "¿Desea quitar el registro del detalle?",
        function() { //SI
            quitarPago(bot);
        },
        function() { //NO
            alertify.error("Operación cancelada");
            $("#icod").focus();
        }
    );
}

function quitarPago(bot) {
    var t = $("#tablaFormaPago").DataTable();
    data = t.row($(bot).parents('tr')).data();
    mon = data[3];
    tik = data[0];

    if ((tik == "Cheque")) {
        var actual = 0;
        actual = parseInt($("#cheque").val()) - parseInt(mon);
        document.getElementById("cheque").value = actual;
    } else if (tik == "Tarjeta Credito" || tik == "Tarjeta Debito") {
        var actual = 0;
        actual = parseInt($("#tarjeta").val()) - parseInt(mon);
        document.getElementById("tarjeta").value = actual;
    }
    // document.getElementById("cheque").value = tv;
    t.row($(bot).parents('tr')).remove().draw();

    restar();
    $("#efectivo").focus();

}

function borrarformapago() {
    var confirm = alertify.confirm('Atención', "Desea cancelar la operación y perder los datos del pago?", null, null).set('labels', { ok: 'Si', cancel: 'No' });
    confirm.set({ transition: 'slide' });
    confirm.set('onok', function() { //callbak al pulsar botón positivo
        $("#cheque").val('');
        $("#tarjeta").val('');
        $("#vuelto").val('');
        $("#efectivo").val('');
        $("#saldo").val('');
        var table = $('#tablaFormaPago').DataTable();
        table.clear().draw();
    });
    confirm.set('oncancel', function() { //callbak al pulsar botón negativo
        alertify.warning('Operación Cancelada!');
    });

}

function enter(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) {
        validarCampos();
    }
}