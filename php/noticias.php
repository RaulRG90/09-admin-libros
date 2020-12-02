<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');


include 'conecta.php';
$q = "SELECT * FROM noticias WHERE publicada = 1 ORDER by id ASC" ;

$conn	=	conecta_bd();
$result = mysqli_query($conn,$q);
if ($result->num_rows) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $myArray[] = $row;
  }
  desconectar_bd($conn);
  //para mostrar en navegador
  $arbol_php = json_encode($myArray);
  //para guardar en archivo json
  $jsonencoded = json_encode($myArray,JSON_UNESCAPED_UNICODE);
  $data = str_replace("\\/", "/", $jsonencoded);
  echo $data;
}else{
  echo 'no se encontraaron registros';
}
	

?>
