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
      $sql = "select * from users".($id?" where id_user='$id'":'');
      break;
    case 'POST':
    $mode = $_POST['mode'];
      $nit = $_POST["id"];
      $name= $_POST["name"];
      $contacto= $_POST["phone"];
      $dir = $_POST["dir"];
      if ($mode=="add") {
        $sql = "insert into users (id_cliente, name_cliente, id, contacto, direccion) values ('$id', '$name', '$id', '$contacto', '$dir')";
      }else{
        $sql = "update users set name_cliente= '$name', contacto='$contacto', direccion='$dir' where id= '$id' ";
      }
      break;
    case 'DELETE':
      $id=$_GET['id'];
      $sql = "DELETE  from users  where id_cliente='$id'";
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
          'tel'=>$row[3],
          'dir'=>$row[4]

      );
      //echo $row[0];
    }
    $jsons=json_encode($json);
    echo $jsons;
}
 ?>
