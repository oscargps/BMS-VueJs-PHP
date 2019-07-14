<?php

include 'conexion.php';
error_reporting(E_ALL ^ E_NOTICE);
$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
$id=$_GET['id'];
$query='SELECT * FROM pedidos'.($id?" where id_pedido='$id'":'');

$result = pg_query($conn, $query);
if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
}
$json=array();
while ($row = pg_fetch_row($result)) {
  $json[]=array(
      'id'=>$row[0],
      'usercreate'=>$row[1],
      'born'=>$row[2],
      'end'=>$row[3],
      'expect' => $row[4],
      'state' => $row[5],
      'process' => $row[9],
      'client' => $row[8],
      'obs' => $row[10],
      'productos' => $row[11]
  );

}
$jsons=json_encode($json);
echo($jsons);
?>
