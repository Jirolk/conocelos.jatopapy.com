function calcular() {
    if ($("#cien").val() < 0) {
        alertify.error("Solo acepta numero positivos");
        $("#cien").focus();
    } else if ($("#cincuenta").val() < 0) {
        alertify.error("Solo acepta numero positivos");
        $("#cincuenta").focus();
    } else if ($("#veinte").val() < 0) {
        alertify.error("Solo acepta numero positivos");
        $("#veinte").focus();
    } else if ($("#diez").val() < 0) {
        alertify.error("Solo acepta numero positivos");
        $("#diez").focus();
    } else if ($("#cinco").val() < 0) {
        alertify.error("Solo acepta numero positivos");
        $("#cinco").focus();
    } else if ($("#dos").val() < 0) {
        alertify.error("Solo acepta numero positivos");
        $("#dos").focus();
    } else if ($("#mil").val() < 0) {
        alertify.error("Solo acepta numero positivos");
        $("#mil").focus();
    } else if ($("#quin").val() < 0) {
        alertify.error("Solo acepta numero positivos");
        $("#quin").focus();
    } else if ($("#cieni").val() < 0) {
        alertify.error("Ingrese solo numero positivos");
        $("#cieni").focus();
    } else {
        // ci= document.getElementById('cien');
        ci = $("#cien").val();
        // alert(ci);
        cin = $("#cincuenta").val();
        // alert(cin);
        ve = $("#veinte").val();
        // alert(ve);
        di = $("#diez").val();
        // alert(di);
        cn = $("#cinco").val();
        // alert(cn);
        d = $("#dos").val();
        // alert(d);
        mi = $("#mil").val();
        // alert(mi);
        qu = $("#quin").val();
        // alert(qu);
        cen = $("#cieni").val();
        // alert(cen);
        sum = (ci * 100000) + (cin * 50000) + (ve * 20000) + (di * 10000) + (cn * 5000) + (d * 2000) + (mi * 1000) + (qu * 500) + (cen * 100);
        //alert(sum);
        document.getElementById('rec').value = sum;
        arqeo = parseInt(document.getElementById('arq').value);
        diferencia = sum - arqeo;
        document.getElementById('dif').value = diferencia;
        $("#mod").modal();
    }
}

function enviar() {
    id = $("#id").val();
    //alert(id);
    feci = $("#feci").val();
    //alert(feci);
    arq = $("#arq").val();
    //alert(arq);
    rec = $("#rec").val();
    //alert(rec);
    dif = $("#dif").val();
    //alert(dif);
    acc = $("#accion").val();
    var ge = $("#geti").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "../servicios/arqueoServicio.php",
        data: "id=" + id + "&feci=" + feci + "&arq=" + arq + "&rec=" + rec + "&ge=" + ge + "&dif=" + dif + "&accion=" + acc,
    }).done(function(resp) {
        if (resp == 1) {
            alertify.alert("Atención", "Registro guardado con éxito",
                function() {
                    window.location = "/DeoCreaciones/menu.php";
                }
            );
        } else if (resp == 2) {
            alertify.error("Atención, ocurrio un error");
        } else if (resp == 3) {
            window.location = "/DeoCreaciones/servicios/cerrarsesion.php";
        }
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error(resp);
    });
}