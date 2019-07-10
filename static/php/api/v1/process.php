<?php
include('conexion.php');
error_reporting(E_ALL ^ E_NOTICE);
$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
//$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
switch ($method) {
    case 'GET':
      $id=$_GET['id'];
      $sql = "select * from process".($id?" where id='$id'":'');
      break;
    case 'POST':
    $mode = $_POST['mode'];
      $id = $_POST["id"];
      $name= $_POST["name"];
      $descr= $_POST["descr"];
      $time = $_POST["time"];
      if ($mode=="add") {
        $sql = "insert into process (id, name_cliente, id, descr, direccion) values ('$id', '$name', '$id', '$descr', '$time')";
      }else{
        $sql = "update process set name_cliente= '$name', descr='$descr', direccion='$time' where id= '$id' ";
      }
      break;
    case 'DELETE':
      $id=$_GET['id'];
      $sql = "DELETE  from process  where id='$id'";
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
          'name'=>$row[1],
          'id'=>$row[2],
          'descr'=>$row[3],
          'time'=>$row[4]

      );
      //echo $row[0];
    }
    $jsons=json_encode($json);
    echo $jsons;
}
 ?>
