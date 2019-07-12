<?php
include 'conexion.php';
error_reporting(E_ALL ^ E_NOTICE);
$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
switch ($method) {
    case 'POST':
    $cliente=$_POST['cliente'];
    $date=$_POST['date'];
    $auth_users=$_POST['auth_users'];
    $proc_assoc=$_POST['proc_assoc'];
    $obs=$_POST['obs'];
    $born=$_POST['born'];
    $user=$_POST['user'];
    $id=$_POST['id'];
    $file=$_POST['file'];

    $sql= "INSERT INTO pedidos(id_pedido,usercreate,born_time,expect_time,file_name,auth_user,client,proc_asoc,obs) VALUES".
    "('$id','$user','$born','$date','$file','$auth_users','$cliente','$proc_assoc','$obs')";
  }
  echo $sql;

  $result = pg_query($conn, $sql);
  if (!$result) {
    http_response_code(404);
    die(mysqli_error($conn));
    exit;
  }
?>
