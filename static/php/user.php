<?php

include 'conexion.php';

$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
$key=$_POST['key'];
if($key=='get'){
    $query="SELECT * FROM users";
    $result = pg_query($conn, $query);
if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
}
$json=array();
while ($row = pg_fetch_row($result)) {
    $json[]=array(
        'id'=>$row[0],
        'nombre'=>$row[1],
        'cargo'=>$row[2],
        'permisos'=>$row[3]
    );
    
  }
  $jsons=json_encode($json);
echo($jsons);
}elseif($key=='new'){
    $id = $_POST['id'];
$name_user=$_POST['nombre'];
$cargo = $_POST['cargo'];
$su=$_POST['sup'];

if ($su =='true'){
    $query="INSERT INTO users(id_user,nombre,cargo,super) VALUES ('$id','$name_user','$cargo','$su')";
}else{
    $query="INSERT INTO users(id_user,nombre,cargo) VALUES ('$id','$name_user','$cargo')";
}
$result = pg_query($conn, $query);
if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
}else{
    echo "true";
}
}elseif($key=='delete'){
    $query="DELETE FROM users WHERE id_user='$_POST[id]'";
    $result = pg_query($conn, $query);
    if (!$result) {
      echo "Ocurrió un error.\n";
      exit;
    }
}



?>