<?php
include 'conexion.php';

$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
$cliente=$_POST['cliente'];
$date=$_POST['date'];
$auth_users=$_POST['auth_users'];
$proc_assoc=$_POST['proc_assoc'];
$obs=$_POST['obs'];
$born=$_POST['born'];
$user=$_POST['user'];
$id=$_POST['id'];
$file=$_POST['file'];

$query= "INSERT INTO pedidos(id_pedido,usercreate,born_time,expect_time,file_name,auth_user,client,proc_asoc,obs) VALUES".
"('$id','$user','$born','$date','$file','$auth_users','$cliente','$proc_assoc','$obs')";
$result = pg_query($conn, $query);
if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
}else{
    echo "Pedido Añadido Correctamente";
}
?>