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
  $email = $data['email'];
  $contrasena = $data['password'];
  $nombre = $data['nombre'];
  if($contrasena && $email && $nombre ){
    //query
    $q = "SELECT id from usuario where email = '$email'";
    $conn = conecta_bd();
    $result = mysqli_query($conn,$q);
    if($result->num_rows){
        echo $email." ya existe, Intenta acceder o logearte.";
    }else{
        $q = "INSERT INTO usuario (nombre, email, password) VALUES ('$nombre', '$email', '$contrasena' )";
        if(putSQL($q)){
            $q = "SELECT id from usuario where email = '$email'";
            $result = mysqli_query($conn,$q);
            if($result->num_rows){
                while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $myArray = $row;
                }
                $id = $myArray['id'];
                $newToken = generaalfanumericos();
                $q = "INSERT INTO token_sesion (id_usuario, idToken, duracion) VALUES ('$id', '$newToken', 3600 )";
                    if(putSQL($q)){
                        $q = "SELECT nombre,email,idToken,duracion from usuario inner join token_sesion on token_sesion.id_usuario = usuario.id  where email = '$email' and password='$contrasena' and id_usuario = $id" ;
                        $result = mysqli_query($conn,$q);
                        if($result->num_rows){
                            //recorre las columnas y las almacena en un array
                            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                                $myArray = $row;
                            }
                            desconectar_bd($conn);
                            $jsonencoded = json_encode( $myArray ,JSON_UNESCAPED_UNICODE);
                            $data = str_replace("\\/", "/", $jsonencoded);
                            echo $data; 
                    }else{
                        desconectar_bd($conn);
                        return 'Se registro el usuario pero no se pudo tener acceso, Intenta acceder o logearte.';
                    }
                }else{
                    desconectar_bd($conn);
                    return 'Se registro el usuario pero no se pudo tener acceso, Intenta acceder o logearte.';
                }
                
            }else{
                desconectar_bd($conn);
                echo 'Se registro el usuario pero no se pudo tener acceso, Intenta acceder o logearte.';
            }
        }else{
            desconectar_bd($conn);
            echo 'Algo mal sucedio al registrar, Intenta de nuevo.';
        }
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

?>
