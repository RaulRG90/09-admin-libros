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
  $titulo = $data['titulo'];
  $img = $data['img'];
  $autor = $data['autor'];
  $paginas = $data['paginas'];
  $edicion = $data['edicion'];
  $coedicion = $data['coedicion'];
  $anio = $data['anio'];
  $pais = $data['pais'];
  $resena = $data['resena'];
  $publicado = $data['publicado'];
  $mes_p = $data['mes_p'];
  $orden = $data['orden'];


  if( $titulo && $autor && $paginas && $edicion && $anio && $pais && $resena ){
    //query
    
    $q = "INSERT INTO libros_mes (titulo, img, autor, paginas, edicion, coedicion, anio, pais, resena, publicado, mes_p, orden ) VALUES ( '$titulo' , '$img' , '$autor' , '$paginas' , '$edicion' , '$coedicion' , $anio , '$pais' , '$resena' ,$publicado, '$mes_p', $orden)";
    $conn = conecta_bd();
    if(putSQL($q)){
      $q = "SELECT * FROM libros_mes WHERE publicado = 1 ORDER by id ASC" ;
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