<?php
include 'conexion.php';

$conn = pg_pconnect("port=$port dbname=$db user=$user password=$pw");
if (!$conn) {
  echo "Ocurrió un error.\n";
  exit;
}
$mode = $_POST['mode'];
if($mode=="login"){
  $user = $_POST['user'];
  $pw = $_POST['pw'];
  $query="SELECT id_user,password,super,cargo from users where id_user='$user'";
  $result = pg_query($conn, $query);
  if (!$result) {
  echo "Ocurrió un error.\n";
  exit;
  }
  $row = pg_fetch_row($result); 
  if($pw==$row[1]){
     echo "true";
    session_start();
   // header("location:sesion.php?user=$mode");
    $_SESSION['access']=true;
    $_SESSION['super']=$row[2];
    $_SESSION['cargo']=$row[3];
     
  }
}
if($mode=="auth"){
 /* if(!empty($_SESSION['user'])){
    
    $json=array();
   
    $json[]=array(
        'user'=>$_SESSION['user'],
        'super'=>$_SESSION['super'],
        'cargo'=>$_SESSION['cargo']
    );
      
    
    $jsons=json_encode($json);
    echo($jsons);
  }else{
    echo "false";
  }*/
  echo $_SESSION['user'];
}

    


?>