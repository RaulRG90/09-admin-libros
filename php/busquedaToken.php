<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');



include 'conecta.php';
//recibe valores externo en formato json
$data = file_get_contents('php://input');
if(!$data){
  echo "No hay datos";
}else{
  //conversion a array
  $data = json_decode($data, true);
  //asignacion de datos en variables
  $token = $data['token'] ;
  //'b8IgVzIz0SbMtvNQgM7IFXhBhdCIKD';
  $email = $data['usuario'];
  //'asian.kyo@gmail.com';
  //comprobacion de que existen valores
  if($token && $email){
    //query
    $q = "SELECT id_usuario as token FROM usuario inner join token_sesion on token_sesion.id_usuario = usuario.id where idToken ='$token' and email = '$email'" ;
    //conexion
    $conn	=	conecta_bd();
    if ($result = mysqli_query($conn,$q)) {
      //desconecta de la bd
      desconectar_bd($conn);
      //verifica si existen datos
      if($result->num_rows){
        //recorre las columnas y las almacena en un array
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
          $myArray = $row;
        }
        //para guardar en archivo json
        $jsonencoded = json_encode($myArray,JSON_UNESCAPED_UNICODE);
        $data = str_replace("\\/", "/", $jsonencoded);
        echo $data;
    
      }else{
        desconectar_bd($conn);
        //desconecta de la bd
        echo 'no se encontro nada';
        //$myArray['token'] = '0'; 
      }
      
    
    }

  }else{
    echo "Algo anda mal";
  }

}


	

?>
