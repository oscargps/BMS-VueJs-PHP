<?php
include 'conexion.php';

$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
$query1="SELECT id_user,nombre FROM users";
$result = pg_query($conn, $query1);
if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
}
while ($row = pg_fetch_row($result)) {

    $query2="UPDATE users SET password = '$row[0]' WHERE users.id_user = '$row[0]' ";
    
    $result2 = pg_query($conn, $query2);
if (!$result2) {
  echo "Ocurrió un error.\n";
  exit;
}

}

?>