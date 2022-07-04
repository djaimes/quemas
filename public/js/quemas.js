/***
*
* Funciones para el sistema de control de quemas
*
*/

$(document).ready(function() {
  login();
});

/***
* login
*/
function login(){

  $('#formLogin').submit(function(event) {
    event.preventDefault();             /* evita que se repinte la página*/
    var usuario = $('#loginUsuario').val();
    var contrasena = $('#loginContrasena').val();

    // Checar que sea un id válido
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
function validarLogin(usuario, contrasena){

  $.ajax({
      // Programa que me atenderá en el servidor
      url: "/controladores/indexmvc.php",

      // Si la petición tuvo éxito
      success: function(data, textStatus, jqXHR){
	console.log(data);
                $('#mensajeSeervidor').text(data);
              },
      data: {
        // controlador debe ser siempre el primer dato que envíe
        // de otro modo no funciona bien router.php
        controlador: 'login',
        usuario: usuario,
        contrasena: contrasena
      },
      // Qué espero de regreso del servidor
      dataType: 'text',
      // Si ocurre un error técnico
      error: function(jqHR, status, error){
        //alert("error técnico");
      },
      // Ejecutar esto no importando si la petición falló o tuvo éxito
      complete: function(){
        //alert("concluida");
      }

    });
}
