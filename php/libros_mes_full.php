<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');


include 'conecta.php';
$q = "SELECT * from libros_mes ORDER by  publicado ASC, mes_p DESC, orden ASC" ;

$conn	=	conecta_bd();
if ($result = mysqli_query($conn,$q)) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $myArray[] = $row;
  }
}
//para mostrar en navegador
$arbol_php = json_encode($myArray);
//para guardar en archivo json
$jsonencoded = json_encode($myArray,JSON_UNESCAPED_UNICODE);
$data = str_replace("\\/", "/", $jsonencoded);
echo $data;
	

?>
