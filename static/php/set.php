

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
 
</head>
<body>
<?php
//include ('conexion.php')
$conn = pg_pconnect("port=5432 dbname=refugio2 user=postgres password=admin22");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
$query="insert into pedidos(superuser,state_of,file_name, auth_user,client,id_cod)
 values('$_POST[su]','inicio','$_POST[id].txt','$_POST[auth_users]','$_POST[cliente]',$_POST[id])";
 echo $query;
/*$result = pg_query($conn, "SELECT * FROM mascotas_mascota");
if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
}

while ($row = pg_fetch_row($result)) {
  echo "name: '$row[1]'  raza: '$row[2]'";
  echo "<br />\n";
}*/

?>
</body>
</html>