<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');

$anio = date("Y");  
$mes = date("n");  

if($mes == 1){
    $anio = $anio - 1;
    $mes = 13;
}

include 'conecta.php';
$q = "SELECT id,titulo,img,autor,paginas,edicion,coedicion,anio,pais,resena,orden,mes_p FROM libros_mes WHERE MONTH(mes_p) < $mes AND YEAR(mes_p) = $anio ORDER BY mes_p DESC, orden ASC" ;

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
  echo 'no se encontraron registros';
}
	

?>
