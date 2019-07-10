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
      $sql = "select * from procesos".($id?" where id_proceso='$id'":'');
      break;
    case 'POST':
    $mode = $_POST['mode'];
      $id = $_POST["id"];
      $name= $_POST["name"];
      $descr= $_POST["descr"];

      if ($mode=="add") {
        $time = $_POST["time"].':00:00';
        $sql = "insert into procesos (id_proceso, nombre, description, timeprom) values ('$id', '$name','$descr', '$time')";
      }else{
        $time = $_POST["time"];
        $sql = "update procesos set nombre= '$name', description='$descr', timeprom='$time' where id_proceso= '$id' ";
      }
      break;
    case 'DELETE':
      $id=$_GET['id'];
      $sql = "DELETE  from procesos  where id_proceso='$id'";
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
          'descr'=>$row[1],
          'time'=>$row[2],
          'name'=>$row[3],


      );
      //echo $row[0];
    }
    $jsons=json_encode($json);
    echo $jsons;
}
 ?>
