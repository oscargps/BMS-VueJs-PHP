<?php
include('conexion.php');
$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
$method = 'GET';//$_SERVER['REQUEST_METHOD'];
//$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
//$input = json_decode(file_get_contents('php://input'),true);
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
switch ($method) {
    case 'GET':
      $id = $_GET['id'];
      $sql = "select * from $id";
      echo $sql;
      break;
    case 'POST':
      $name = $_POST["name"];
      $phone = $_POST["phone"];
      $direccion = $_POST["direccion"];
      $nit = $_POST["nit"];

      $sql = "insert into contacts (name, email, city, country, job) values ('$name', '$email', '$city', '$country', '$job')";
      break;
}
/*$result = pg_query($conn, $sql);
if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
}
*/
 ?>
