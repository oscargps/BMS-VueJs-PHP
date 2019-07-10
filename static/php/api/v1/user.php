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
      $id = $_POST["id"];
      $name= $_POST["name"];
      $cargo= $_POST["cargo"];
      $super = $_POST["super"];
      if ($mode=="add") {
        $sql = "insert into users (id_user, nombre,cargo, super, password) values ('$id', '$name', '$cargo', '$super', $id)";
      }else{
        $sql = "update users set nombre= '$name', cargo='$cargo', super='$super' where id_user= '$id' ";
      }
      break;
    case 'DELETE':
      $id=$_GET['id'];
      $sql = "DELETE  from users  where id_user='$id'";
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
          'cargo'=>$row[2],
            'super'=> ($row[3] == 't')? true:false



      );
      //echo $row[0];
    }
    $jsons=json_encode($json);
    echo $jsons;
}
 ?>
