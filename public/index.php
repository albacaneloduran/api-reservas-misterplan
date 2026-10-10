<?php
require_once __DIR__ . '/../src/Controllers/ReservaController.php';
$controlador = new ReservaController();

$metodo = $_SERVER['REQUEST_METHOD'];
$ruta = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$partes = explode('/', trim($ruta, '/'));

if ($metodo == 'GET' && $ruta == '/reservas') {
    $controlador->listarR();
}else if($metodo == 'GET' && $partes[0] == 'reservas' && isset($partes[1])) {
    $id = $partes[1];
    $controlador->detalleR($id); 
}elseif($metodo=='POST' && $ruta=='/reservas'){
    $datos=json_decode(file_get_contents("php://input"),true);
    $controlador->crearR($datos);
}else if($metodo=='PUT' && $partes[0]=='reservas' && isset($partes[1])){
    $id=$partes[1];
    $datos=json_decode(file_get_contents("php://input"),true);
    $controlador->cambiarR($id,$datos['estado']);
}
?>