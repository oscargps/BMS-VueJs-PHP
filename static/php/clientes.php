<?php
include 'conexion.php';

$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
$key=$_GET['key'];
if($key=='get'){
  $query='SELECT * FROM clientes';
  $result = pg_query($conn, $query);
  if (!$result) {
    echo "Ocurrió un error.\n";
    exit;
  }
  $json=array();
  while ($row = pg_fetch_row($result)) {
      $json[]=array(
        'id'=>$row[0],
          'name'=>$row[1],
          'nit'=>$row[2],
          'tel'=>$row[3],
          'dir'=>$row[4]

      );
      //echo $row[0];
    }
    $jsons=json_encode($json);
    echo $jsons;
}else if($key=='delete'){
  $query="DELETE FROM clientes WHERE id_cliente='$_POST[id]'";
  $result = pg_query($conn, $query);
  if (!$result) {
    http_response_code(404);
  die(mysqli_error($con));
    exit;
  }
}else if($key=='new'){
  $nit = $_POST['nit'];
  $name=$_POST['name'];
  $tel = $_POST['tel'];
  $dir=$_POST['dir'];


  $query="INSERT INTO clientes(id_cliente,name_cliente, nit,contacto,direccion) values('$nit','$name', '$nit','$tel','$dir')";

  $result = pg_query($conn, $query);
  if (!$result) {
    echo "Ocurrió un error.\n";
    exit;
  }


}


?>
