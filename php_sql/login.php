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
  if($contrasena && $usuario ){
    //query
    $q = "SELECT id from usuario where email = '$usuario' and password='$contrasena'" ;
    //conexion
    $conn	=	conecta_bd();
    $result = mysqli_query($conn,$q);
      //verifica si existen datos
      if($result->num_rows){
        //recorre las columnas y las almacena en un array
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $myArray = $row;
        }
        $id = $myArray['id'];
        //busca token
        $q = "SELECT id_usuario from token_sesion where id_usuario = $id" ;
        $result = mysqli_query($conn,$q);
        if($result->num_rows){
            //actualiza token
            $newToken = generaalfanumericos();
            $q = "UPDATE token_sesion SET idToken ='$newToken' where id_usuario = $id";
            if(putSQL($q)){
                //envia datos de validacion de usuario al solicitante
                //para guardar en archivo json
                $jsonencoded = json_encode( regresavalores($id,$usuario,$contrasena,$conn) ,JSON_UNESCAPED_UNICODE);
                $data = str_replace("\\/", "/", $jsonencoded);
                echo $data;
            }else{
                desconectar_bd($conn);
                echo 'Algo salio mal, intentalo de nuevo!';
            }
        }else{
            //inserta token
            $newToken = generaalfanumericos();
            $q = "INSERT INTO token_sesion (id_usuario, idToken, duracion) VALUES ('$id', '$newToken', 3600 )";
            if(putSQL($q)){
                //envia datos de validacion de usuario al solicitante
                //para guardar en archivo json
                $jsonencoded = json_encode( regresavalores($id,$usuario,$contrasena,$conn) ,JSON_UNESCAPED_UNICODE);
                $data = str_replace("\\/", "/", $jsonencoded);
                echo $data;
            }else{
                desconectar_bd($conn);
                echo 'Algo salio mal, intentalo de nuevo!';
            }
        }
        
    
      }else{
        desconectar_bd($conn);
        echo "Los valores introducidos no son validos";
      }
    
    

  }else{
    echo "Algo anda mal";
  }

}

function generaalfanumericos( $length = 30 ) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function regresavalores($id, $usuario, $contrasena,$conn){
    $q = "SELECT nombre,email,idToken,duracion from usuario inner join token_sesion on token_sesion.id_usuario = usuario.id  where email = '$usuario' and password='$contrasena' and id_usuario = $id" ;
    $result = mysqli_query($conn,$q);
    if($result->num_rows){
        //recorre las columnas y las almacena en un array
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $myArray = $row;
        }
        desconectar_bd($conn);
        return $myArray;
    }else{
        desconectar_bd($conn);
        return 'Algo salio mal, intentalo de nuevo!';
    }
}

	

?>
