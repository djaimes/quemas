<?php
   $host        = "host = 127.0.0.1";
   $port        = "port = 5432";
   $dbname      = "dbname = quemas";
   $credentials = "user = postgres password=colage";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      SELECT id,correo, latitud, longitud, ST_AsText(ubicacion) from reporte;
EOF;

   $ret = pg_query($db, $sql);
   if(!$ret) {
      echo pg_last_error($db);
      exit;
   } 
   while($row = pg_fetch_row($ret)) {
      echo "ID = ". $row[0] . "\n";
      echo "CORREO = ". $row[1] ."\n";
      echo "LATITUD = ". $row[2] ."\n";
      echo "LONGITUD =  ".$row[3] ."\n\n";
      echo "UBICACION =  ".$row[4] ."\n\n";
   }
   echo "Operation done successfully\n";
   pg_close($db);
?>
