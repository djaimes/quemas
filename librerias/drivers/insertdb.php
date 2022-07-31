<?php
   $host        = "host=127.0.0.1";
   $port        = "port=5432";
   $dbname      = "dbname = quemas";
   $credentials = "user = postgres password=colage";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }

   $sql = "INSERT INTO REPORTE (ID, CORREO, LATITUD, LONGITUD)
      VALUES (60, 'daniel.jaimes@gmail.com', 90.6, 18.3)";

   $ret = pg_query($db, $sql);
   if(!$ret) {
      echo pg_last_error($db);
   } else {
      echo "Records created successfully\n";
   }
   
   pg_close($db);
?>
