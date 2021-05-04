function habilitar(value) {
    var sele = document.getElementById("tipoCand");
    // alert(sele.options[sele.selectedIndex].value);
    if (sele.options[sele.selectedIndex].value == 1 || sele.options[sele.selectedIndex].value == 2) {
        // alert(sele.options[sele.selectedIndex].value);

        document.getElementById("CampoBusqueda").innerHTML = `
        <div class="row mt-3">
            <div class="col-6"> Nombre del Candidato <br>
                <select class="form-control" id="buscador1" name="candidato1"></select>
                <br>
                <a href="">busqueda avanzada</a>
            </div>
            <div class="col-6"> Nombre del Candidato <br>
            <select class="form-control" id="buscador2" name="candidato1"></select>
            <br>
         
            <a href="">busqueda avanzada</a>
            </div>
        </div>
        <button class="btn btn-info mt-5" onclick="comparar();">Comparar</button>
        `;
        consulta(sele.options[sele.selectedIndex].value);
        $("#buscador1").select2();
        $("#buscador2").select2();

    } else if (sele.options[sele.selectedIndex].value == 0) {
        document.getElementById("CampoBusqueda").innerHTML = "<label for='fec1'class='mt-5 text-danger'>Favor de Elegir una opcion</label>";
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
    var cand1 = document.getElementById("buscador1");
    var cand2 = document.getElementById("buscador2");


    if (cand2.options[cand2.selectedIndex].value == 0 || cand2.options[cand2.selectedIndex].value == 0) {
        alertify.error("Los campos no pueden estar vacios!");
    } else if (cand2.options[cand2.selectedIndex].value == cand2.options[cand2.selectedIndex].value) {
        alertify.error("No te servirá de mucho comparar el mismo Perfil, Elije otro");
    } else {
        alertify.error("Esta en desarrollo!");
    }

}