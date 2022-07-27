/***
*
* Funciones para el sistema de control de quemas
*
*/

$(document).ready(function(){
  login();
})


/***
* login
*/
function login() {

  $('#formLogin').submit(function (event) {
    event.preventDefault();             /* evita que se repinte la página*/
    var usuario = ($('#loginUsuario').val());
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
* validarLogin
*/
function validarLogin(usuario, contrasena) {

  $.ajax({
    url: "/controladores/indexmvc.php",
    success: function (data, textStatus, jqXHR) {
      console.log(data);
      $('#nombreUsuario').val(data);
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
