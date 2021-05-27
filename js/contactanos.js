function contactanos() {
    // alert("hola");
    nombre = "Hola *mi Nombre es: ";



    const swalWithBootstrapButtons = Swal.mixin({

        customClass: {

            confirmButton: 'btn btn-success ml-1 px-2',

            cancelButton: 'btn btn-danger px-2'

        },

        buttonsStyling: false

    })



    swalWithBootstrapButtons.fire({

        title: 'Gracias por Confiar en Nosotros',

        text: 'Necesitamos saber su Nombre',

        icon: 'success',

        showCancelButton: true,

        confirmButtonText: 'Si, deseo seguir!',

        cancelButtonText: 'No, gracias!',

        reverseButtons: true

    }).then((result) => {

        if (result.value) {

            swalWithBootstrapButtons.mixin({

                input: 'text',

                showCancelButton: true,

                cancelButtonText: 'Cancelar',

                confirmButtonText: 'Enviar',

                icon: 'success'

            }).queue([{

                    title: 'Genial, ahora Introduzca su Nombre:',

                    text: 'Es para adjuntar al Mensaje de Whatsapp'

                }

            ]).then((result) => {

                if (result.value) {
                    var textoEnviar = ", estoy interesado en formar parte de la Base de datos, ¿me das mas detalles?";
                    nombre += result.value;

                    var contacto = '971678081'

                    // window.location.href = "https://api.whatsapp.com/send?phone=+595" + contacto + "&text=" + nombre + "*" + textoEnviar + ".";
                    window.open("https://api.whatsapp.com/send?phone=+595" + contacto + "&text=" + nombre + "*" + textoEnviar + ".", "_blank");

                }

            });



        } else if (

            /* Read more about handling dismissals below */

            result.dismiss === Swal.DismissReason.cancel

        ) {

            swalWithBootstrapButtons.fire({

                title: 'Ups!',

                text: 'Puede seguir navegando por la página',

                icon: 'error'

            }).then(function() {



            });

        }

    })
}