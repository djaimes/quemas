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
    event.preventDefault();
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
* reporte
*/
function reporte() {
  $('#formReporte').submit(function(event){
    event.preventDefault();
    var latitud = $('#inputLatitud').val();
    var longitud = $('#inputLongitud').val();
    var correoReporte = $('#correoReporte').val();
    if (latitud.length > 0 && longitud.length > 0) {
      agregarReporte(correoReporte, latitud, longitud);
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
function agregarReporte(correoReporte, latitud, longitud) { // grrr tardé 3 días por qué faltaba correoReporte

  $.ajax({
    url: "/controladores/bootstrap.php",
    success: function (data, textStatus, jqXHR) {
      console.log("Data: " + data);
      $('#numeroFolio').text(data);
    },
   
    data: {
      controlador: 'reporte',
      latitud: latitud,
      longitud: longitud,
      correo: correoReporte
    },

    dataType: 'text',         // Valor esperado de regreso
    
    error: function (jqHR, status, error) {
      console.log("error");
    },
    
    complete: function () {
      //console.log("completado");
    }

  });

}

