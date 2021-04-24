function buscarCodi() {
    $("#articulo").val("");
    $("#precio").val("");
    document.getElementById("iva").selectedIndex = 0;
    cod = $("#icod").val();
    if(cod == ""){
        alertify.error("Ingrese código a buscar!")
    }else{
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "../servicios/busqueda.php",
            data: "criterio=idinsumo&valor=" + cod + "&tabla=insumos&busqueda=descripcion",
        }).done(function (resp) {
            if (resp == ",,") {
                alertify.error("Insumo no existe!!");
                $("#icod").focus();
                //document.getElementById('accion').value = 'N';
            }else {
                var porciones = resp.split(',');//separo
                 $("#articulo").val(porciones[0]);
                 $("#precio").val(porciones[1]);
                 if(porciones[2]==0){
                   $("#iva").val('Exenta');
                 }else{
                   $("#iva").val(porciones[2]);
                 }
                document.getElementById('accion').value = 'M';
                $("#cantidad").val("1");
                $("#cantidad").focus();
            }
        }).fail(function (resp) {
            alertify.error(resp);
        });
    }
}
function recorrer(codart){
    var tabla = $("#tablaDetalle").DataTable();
     var canFilas = tabla.page.info().recordsTotal;
     var scant=0;
     for(i=0; i<canFilas; i++) {
         data = tabla.row(i).data();
         cod = data[1];
         can = data[3];
         if (cod==codart) {
              scant=scant+parseInt(can,10);
         }
     }
     return scant;
}
function agregar(){
    if($("#icod").val() < 1){
         alertify.error("Ingrese o Seleccione un Código de Insumo");
         $("#icod").focus();
    }else if ($("#articulo").val() == "") {
         alertify.error("Seleccione Artículo");
         $("#icod").focus();
    }else if ($("#precio").val() < 500) {
         alertify.error("Ingrese precio superior a 500");
         $("#precio").focus();
    }else if ($("#iva").val() == "") {
         alertify.error("Seleccione I.V.A.");
         $("#iva").focus();
    }else if ($("#cantidad").val() < 0) {
         alertify.error("Ingrese Cantidad Válida");
         $("#cantidad").focus();
    }else{
         acc = $("#accion").val();
         var cod = $("#icod").val();
         var art = $("#articulo").val();
         var can = $("#cantidad").val();
         var pre = $("#precio").val();
         var iva = $("#iva").val();
         var exe =0;
         var iv5 =0;
         var iv1 =0;
        /* $.ajax({//PARA VENTAAA
            type: "POST",
            dataType: 'html',
            url: "../servicios/busqueda.php",
            data: "criterio=idinsumo&valor="+cod+"&tabla=insumos&busqueda=stock",
        }).done( function(resp){
            if (resp>0) {
                 if (parseInt(can,10) <= parseInt(resp,10)) {
                    var sumcant = recorrer(cod);
                    cantot = parseInt(sumcant,10)+parseInt(can,10);
                    if (cantot>resp) {
                            alertify.error("No se puede agregar mas items del mismo articulo, supera al stock actual: "+resp);
                    }else {*/
                        tb5 = 0;
                        tbe = 0;
                        tb1 = 0;
                        cantidad = parseInt(can,10);
                        precio = parseInt(pre,10);
                        var valor = cantidad*precio;
                        if(iva == "Exenta"){
                            tbe = precio;
                            exe  = valor;
                            e = parseInt(document.getElementById("exenta").value);
                            document.getElementById("exenta").value =(e + exe);
                        }else if(iva == 5){
                            tb5 = precio;
                            iv5=valor;
                            i5 = parseInt(document.getElementById("iva5").value);
                            document.getElementById("iva5").value = (i5 +iv5);
                        }else{
                            tb1 = precio;
                            iv1=valor;
                            i1 = parseInt(document.getElementById("iva10").value);
                            document.getElementById("iva10").value = (i1+iv1);
                        }
                        tt =parseInt($("#total").val());
                        document.getElementById("total").value=  (tt + valor);
                        //para mi total iva
                        if(iva!=0){
                            ti = parseInt($("#totaliva5").val(),10);
                            ti2 = parseInt($("#totaliva10").val(),10);
                            if(iva==5){
                                v1 = parseInt(Math.round(valor/21));
                                document.getElementById("totaliva5").value = (ti +v1);
                            }else if (iva == 10) {
                                v2 = Math.round(valor/11);
                                document.getElementById("totaliva10").value = (ti2 +v2);
                            }
                        }
                        var t = $('#tablaDetalle').DataTable();
                        i = '<i class="fa fa-trash-o" style="cursor:pointer;text-align:center;" onclick="pregunta(this);"></i>';
                        t.row.add([acc,cod,art,can,tbe,tb5,tb1,valor,i]).draw(false);
                        $("#articulo").val("");
                        $("#icod").val("");
                        $("#precio").val("");
                        document.getElementById("iva").selectedIndex=0;
                        $("#cantidad").val("1");
                        $("#icod").focus();
                    /*}
                }else {
                    alertify.error("La cantidad ingresada supera al Stock actual: "+resp);
               }    
            }else {
                alertify.error("No hay producto en stock");
            }
        }).fail( function(resp){ //se ejecuta en que caso de que haya ocurrido algún error
            alertify.error(resp);
        });*/
    }
}
function pregunta(bot){
    alertify.confirm().set("labels", {ok:"SI", cancel:"NO"});
    alertify.confirm().set("defaultFocus", "cancel");
    alertify.dialog("confirm").set({transition:"flipx"});
    alertify.confirm("Quitar Insumo o producto", "¿Desea quitar el registro del detalle?",
         function(){ //SI
              quitar(bot);
         },
         function(){ //NO
              alertify.error("Operación cancelada");
              $("#icod").focus();
         }
    );
}
function quitar(bot){
    var t = $("#tablaDetalle").DataTable();
    data = t.row($(bot).parents('tr')).data();
    tv = parseInt(data[7]);
    ti = parseInt($("#totaliva").val(),10);
    tt = parseInt($("#total").val());
    if(data[4]!=0){
         te = parseInt(data[7]);
         document.getElementById("exenta").value -= te;
         tt = tt - tv;
    }else if(data[5]!=0){
         t5 = parseInt(data[7]);
         document.getElementById("iva5").value -= t5;
         document.getElementById("totaliva5").value -= Math.round(tv/21);
         tt = tt - tv;
    }else if(data[6]!=0){
         t1 = parseInt(data[7]);
         document.getElementById("iva10").value -= t1;
         document.getElementById("totaliva10").value -= Math.round(tv/11);
         tt = tt - tv;
    }
    document.getElementById("total").value -= tv;
    t.row($(bot).parents('tr')).remove().draw();

}
function validar(){
 if($("#entrega").val() < 0){
      alertify.error("Ingrese Entrega válida!");
      $("#entrega").focus();
 }else if($("#saldoc").val() <= 0){
      alertify.error("Entrega no debe superar al Monto Total de la Compra!");
      $("#entrega").focus();
 }else if($("#canti").val() <= 0){
         alertify.error("Ingrese cantidad de cuotas válida!");
         $("#canti").focus();
    }else if($("#fechaV").val() == ""){
         alertify.error("Seleccione fecha del Primer vencimiento!");
         $("#fechaV").focus();
    }else if($("#fechaV").val() < $("#fechaC").val()){
         alertify.error("Fecha debe ser superior a la fecha de compra!");
         $("#fechaV").focus();
    }else{
        registrar();
        //registrarCuotas();
    }
}