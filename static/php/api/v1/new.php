<?php
include('conexion.php');
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Bogota');
$date = date('d-m-Y H:i:s');
$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
switch ($method) {
    case 'POST':
    $mode = $_POST['mode'];
    if($mode == 'new'){
      $cliente=$_POST['cliente'];
      $nit = explode('/',$cliente);
      $expect=$_POST['expect'];
      $auth_users=$_POST['auth_users'];
      $proc_assoc=$_POST['proc_assoc'];
      $obs=$_POST['obs'];
      $born=$date;
      $user=$_POST['user'];
      $id=$nit[0].'-'.$date;
      $file=$id.'.txt';
      $productos = $_POST['productos'];
      $sql= "INSERT INTO pedidos(id_pedido,usercreate,born_time,expect_time,file_name,auth_user,client,proc_asoc,obs, productos) VALUES".
      "('$id','$user','$born','$expect','$file','$auth_users','$cliente','$proc_assoc','$obs', '$productos')";
  //  echo $sql;
}elseif($mode=='update'){
      $id=$_POST['id'];
      $state = $_POST['state'];
      $sql = "UPDATE pedidos set state_of='$state' WHERE id_pedido='$id'";
    }else{
      $id=$_POST['id'];
      $sql = "UPDATE pedidos set end_time='$date' WHERE id_pedido='$id'";
    }

  }

 $result = pg_query($conn, $sql);
  if (!$result) {
    http_response_code(404);
    die(mysqli_error($conn));
    exit;
  }
?>
