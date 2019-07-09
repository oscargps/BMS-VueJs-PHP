<?php

include 'conexion.php';

$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}

$query='SELECT id_pedido,client,born_time,state_of FROM pedidos';
$result = pg_query($conn, $query);
if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
}
$json=array();
while ($row = pg_fetch_row($result)) {
  $json[]=array(
      'id'=>$row[0],
      'cliente'=>$row[1],
      'born'=>$row[2],
      'state'=>$row[3]
  );
  
}
$jsons=json_encode($json);
echo($jsons);
?>