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
  $usuario = $data['email'];
  $contrasena = $data['password'];
  //comprobacion de que existen valores
  if($contrasena && $usuario ){
    //query
    $q = "SELECT nombre,email,idToken,duracion from usuario inner join token_sesion on token_sesion.id_usuario = usuario.id  where email = '$usuario' and password='$contrasena'" ;
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
        //trigger_error("No existe el usuario", E_USER_ERROR);
        echo "No existe el Usuario";
      }
    
    }

  }else{
    echo "Algo anda mal";
  }

}


	

?>
