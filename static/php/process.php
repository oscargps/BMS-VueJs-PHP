<?php

include 'conexion.php';

$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
$key=$_POST['key'];
if($key=='get'){
  $query='SELECT * FROM procesos';
  $result = pg_query($conn, $query);
  if (!$result) {
    echo "Ocurrió un error.\n";
    exit;
  }
  $json=array();
  while ($row = pg_fetch_row($result)) {
    $json[]=array(
        'id'=>$row[0],
        'desc'=>$row[1],
        'time'=>$row[2],
        'nombre'=>$row[3]
    );
    
  }
  $jsons=json_encode($json);
  echo($jsons);
}else if($key=='delete'){
  $query="DELETE FROM procesos WHERE id_proceso='$_POST[id]'";
  $result = pg_query($conn, $query);
  if (!$result) {
    echo "Ocurrió un error.\n";
    exit;
  }
}else if($key=='new'){
  $id = $_POST['id'];
  $name=$_POST['name'];
  $desc = $_POST['desc'];
  $time=$_POST['time'].':00:00';


  $query="INSERT INTO procesos(id_proceso,description, nombre,timeprom) values('$id','$desc', '$name','$time')";

  $result = pg_query($conn, $query);
  if (!$result) {
    echo "Ocurrió un error.\n";
    exit;
  }else{
      echo "true";
  }
}

?>