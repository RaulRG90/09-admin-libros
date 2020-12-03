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
  $id = $data['id'];
  $titulo = $data['titulo'];
  $fecha = $data['fecha'];
  $noticia_url = $data['noticia_url'];
  $publicada = $data['Publicada'];
  $orden = $data['orden'];

  if($id && $titulo && $fecha && $noticia_url && $orden  ){
    //query
    $q = "UPDATE noticias SET titulo = '$titulo', fecha = '$fecha', noticia_url = '$noticia_url', publicada = $publicada , orden = $orden WHERE id = $id";
    $conn = conecta_bd();
    if(putSQL($q)){
      $q = "SELECT * FROM noticias ORDER by orden DESC, publicada ASC" ;
        $result = mysqli_query($conn,$q);
        if($result->num_rows){
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
              $myArray[] = $row;
            }
            $jsonencoded = json_encode( $myArray ,JSON_UNESCAPED_UNICODE);
            $data = str_replace("\\/", "/", $jsonencoded);
            echo $data;
            desconectar_bd($conn);
        }else{
            desconectar_bd($conn);
            echo 'Se actualizaron los datos, pero no se pudo devolver los datos de la tabla';
        }
    }else{
        desconectar_bd($conn);
        echo 'No se puedo actualizar los datos, intentalo de nuevo';
    }
   

  }else{
    echo "Algo anda mal";
  }

}

?>
