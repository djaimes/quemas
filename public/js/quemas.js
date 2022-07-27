/***
*
* Funciones para el sistema de control de quemas
*
*/

$(document).ready(function(){
  login();
  reporte();
})


/***
* login
*/
function login() {

  $('#formLogin').submit(function(event){

    event.preventDefault();             /* evita que se repinte la página*/
    var usuario = $('#loginUsuario').val();
    var contrasena = $('#loginContrasena').val();
    if (usuario.length > 0 && contrasena.length > 0) {

      validarLogin(usuario, contrasena);

    } else {
      $('#loginUsuario').val('');
      $('#loginContrasena').val('');
    }
  });
}

/***
* login
*/
function reporte() {

  $('#formReporte').submit(function(event){

    event.preventDefault();             /* evita que se repinte la página*/

    var latitud = $('#inputLatitud').val();
    var longitud = $('#inputLongitud').val();

    if (latitud.length > 0 && longitud.length > 0) {

      agregarReporte(latitud, longitud);

    } else {
      $('#inputLatitud').val('');
      $('#inputLongitud').val('');
    }
  });
}

/***
* validarLogin
*/
function validarLogin(usuario, contrasena) {

  $.ajax({
    url: "/controladores/bootstrap.php",
    success: function (data, textStatus, jqXHR) {
      $('#nombreUsuario').text(data);
    },
   
    data: {
      controlador: 'login',
      usuario: usuario,
      contrasena: contrasena
    },

    dataType: 'text',         // Valor esperado de regreso
    error: function (jqHR, status, error) {
    },
    complete: function () {
    }

  });
}

/***
* agregarReporte
*/
function agregarReporte(latitud, longitud) {

  alert('lat '+ latitud + 'lon ' + longitud);

  $.ajax({
    url: "/controladores/bootstrap.php",
    success: function (data, textStatus, jqXHR) {
      $('#numeroFolio').text(data);
    },
   
    data: {
      controlador: 'reporte',
      latitud: latitud,
      longitud: longitud
    },

    dataType: 'text',         // Valor esperado de regreso
    error: function (jqHR, status, error) {
    },
    complete: function () {
    }

  });
}

