<?php
include('conexion.php');
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Bogota');
$date = date(' d-m-Y H:i:s');
$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
//$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
switch ($method) {
    case 'GET':
      $id=$_GET['id'];
      $sql = "select * from facturas".($id?" where id_factura='$id'":'');
      break;
    case 'POST':
    $mode = $_POST['mode'];
      $id = $_POST["id"];
      $client= $_POST["client"];
      $total= $_POST["total"];

      if ($mode=="new") {
        $sql = "insert into facturas (id_factura, cliente, total_factura, fecha) values ('$id', '$client',$total, '$date')";
      }else{
        $sql = "update facturas set state= 'true', pago='$date' where id_factura= '$id' ";
      }
      break;
    case 'DELETE':
      $id=$_GET['id'];
      $sql = "DELETE  from facturas  where id_factura='$id'";
}
$result = pg_query($conn, $sql);
if (!$result) {
  http_response_code(404);
  die(mysqli_error($conn));
  exit;
}
if ($method == 'GET') {
  $json=array();
  while ($row = pg_fetch_row($result)) {
      $json[]=array(
        'id'=>$row[0],
          'born'=>$row[1],
          'cliente'=>$row[2],
          'total'=>$row[3],
          'state' => ($row[4] == 't')? true:false,
          'pago' => $row[5]


      );
      //echo $row[0];
    }
    $jsons=json_encode($json);
    echo $jsons;
}
 ?>
