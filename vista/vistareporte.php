<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Listado de Profesores</title>
    <style media="screen">
        h3 {
          color: red;
        }
    </style>
  </head>
  <body>
    <!-- (Paso 16) Creamos la vista de profesores -->
    <h1>Datos del Profesor</h1>
    <h2>Id:</h2>
    <h3><?php echo $data['id']; ?> </h3>
    <h2>Nombre:</h2>
    <h3><?php echo $data['nombre']; ?> </h3>
    <h2>Paterno:</h2>
    <h3><?php echo $data['paterno']; ?> </h3>
    <h2>Materno:</h2>
    <h3><?php echo $data['materno']; ?> </h3>
  </body>
</html>
