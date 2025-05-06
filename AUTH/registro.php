<?php

$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
if ($mysql->connect_errno) {
  echo "Fallo al conectar a MySQL: (" . $mysql->connect_errno . ") " . $mysql->connect_error;
  } else {
  echo "Conectado a MySQL";
  }

?>  