var c = 0;

function habilitar(value) {
    var sele = document.getElementById("tipoCand");
    // alert(sele.options[sele.selectedIndex].value);
    if (sele.options[sele.selectedIndex].value == 1 || sele.options[sele.selectedIndex].value == 2) {
        // alert(sele.options[sele.selectedIndex].value);

        document.getElementById("CampoBusqueda").innerHTML = `
        <div class="row mt-3">
            <div class="col col-md-6 mt-3"> Nombre del Candidato <br>
                <select class="form-control" id="buscador1" name="candidato1"></select>
                <br>
            </div>
            <div class="col col-md-6 mt-3"> Nombre del Candidato <br>
            <select class="form-control" id="buscador2" name="candidato1"></select>
            <br>
            </div>
        </div>
        <br><hr>
        <a id="busqueAva" class="btn text-success" onclick="busqueAva();">busqueda avanzada <b><i class="fa fa-angle-double-down"></b></i></a>
        <hr><br>

        <button class="btn btn-info mt-5 mb-5" onclick="comparar();">Comparar</button>
        `;
        consulta(sele.options[sele.selectedIndex].value);
        $("#buscador1").select2();
        $("#buscador2").select2();

    } else if (sele.options[sele.selectedIndex].value == 0) {
        document.getElementById("CampoBusqueda").innerHTML = "<label for='fec1'class='mt-5 text-danger'>Favor de Elegir una opción</label>";
    }
}
// document.getElementById("CampoBusqueda").innerHTML = "<label for='fec1'class='mt-5 text-danger'>Favor de Elegir una opcion</label>";


function consulta(sele) {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "../contenido/ComparadorServicio/buscar.php",
        data: "candi=" + sele,
    }).done(function(resp) { //se ejecuta cuando la solicitud Ajax ha concluido satisfactoriamente
        // alert(resp);
        if (resp == 1) {

            alertify.error("Lo sentimos no hay resultado en su busqueda :(");
        } else {
            $("#buscador1").append(`
            <option value="0"> Elije un candidato </option>`);
            $("#buscador2").append(`
            <option value="0"> Elije un candidato </option>`);
            for (var i in resp) {
                $("#buscador1").append(`
                <option value="` + resp[i].ide + `">` + resp[i].nom + `</option>`);
                $("#buscador2").append(`
                <option value="` + resp[i].ide + `">` + resp[i].nom + `</option>`);
            };


        };
    }).fail(function(resp) { //se ejecuta en que caso de que haya ocurrido algún error
        alertify.error("Problemas con la base de datos");
    });

}

function comparar() {
    if (document.getElementById("buscador1")) {
        var cand1 = document.getElementById("buscador1");
        var cand2 = document.getElementById("buscador2");
        // alert(cand1.options[cand1.selectedIndex].value)

        if (cand1.options[cand1.selectedIndex].value == 0) {
            alertify.error("Los campos no pueden estar vacios!");
            $("#buscador1").select2('open');
        } else if (cand2.options[cand2.selectedIndex].value == 0) {
            alertify.error("Los campos no pueden estar vacios!");
            $("#buscador2").select2('open');
        } else if (cand2.options[cand2.selectedIndex].value == cand1.options[cand1.selectedIndex].value) {
            alertify.error("No te servirá de mucho comparar el mismo Perfil, Elije otro");
        } else {


            alertify.error("Esta en desarrollo!");
        }

    } else {
        alertify.error("Esta en desarrollo!");
    }

}


function busqueAva() {
    // alert(c);
    if (c == 0) {
        document.getElementById("busqueAva").innerHTML = `<a id = "busqueAva" class="btn text-success" onclick=" ">busqueda avanzada <b><i class="fa fa-angle-double-up "></b></i></a>`;
        desplegarBusqueda();
        c = 1;
    } else {
        document.getElementById("busqueAva").innerHTML = `<a id="busqueAva" class="btn text-success" onclick="">busqueda avanzada <b><i class="fa fa-angle-double-down"></b></i></a>`;
        habilitar();
        c = 0;
    }

}

function desplegarBusqueda() {

    document.getElementById("CampoBusqueda").innerHTML = `
    <div class="row mt-3">
        <div class="col col-md-6 mt-3"> Nombre del Candidato <br>
            
        <input type="text">
            <br>
        </div>
        <div class="col col-md-6 mt-3"> Nombre del Candidato <br>
        <input type="text">
        <br>
        </div>
    </div>
    <br><hr>
    <a id="busqueAva" class="btn text-success" onclick="busqueAva();">busqueda avanzada <b><i class="fa fa-angle-double-up"></b></i></a>
    <hr><br>

    <button class="btn btn-info mt-5 mb-5" onclick="comparar();">Comparar</button>
    `;
}