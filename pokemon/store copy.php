<?php
session_start();

//1º habilito la visualización de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

//comoruebo si el usuario ha iniciado la sesion
if(!isset($_SESSION['user'])) {
    header('Location:.');//redireccion
    exit;//detengo la ejecicion
}

//realizp la conexion con la BD
try {
    $connection = new \PDO(
      'mysql:host=localhost;dbname=pokemon',
      'pokemon',
      'user',
      array(
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8')
    );
} catch(PDOException $e) {
    header('Location: create.php?op=errorconnection&result=0');
    exit;
}

//compruebo que me llegan los datos obligatorios
if(isset($_POST['name'])) {
    $name = $_POST['name'];
} else {
    header('Location: create.php?op=errorname&result=0');
    exit;
}
if(isset($_POST['weight'])) {
    $weight = $_POST['weight'];
} else {
    header('Location: create.php?op=errorweight&result=0');
    exit;
}
if(isset($_POST['height'])) {
    $height = $_POST['height'];
} else {
    header('Location: create.php?op=errorheight&result=0');
    exit;
}
if(isset($_POST['type'])) {
    $type = $_POST['type'];
} else {
    header('Location: create.php?op=errortype&result=0');
    exit;
}
if(isset($_POST['evolution'])) {
    $evolution = $_POST['evolution'];
} else {
    header('Location: create.php?op=errorevolution&result=0');
    exit;
}

//validacion y limpieza de datos
$name = trim($name); // en realidad si al final es la cadena vacia, y no es obligatorio, se asigna null
$type = trim($name);
$evolution = trim($name);
$ok = true;
if(strlen($name) < 2 || strlen($name) > 100) {
    $ok = false;
}
if(!(is_numeric($weight) && $weight >= 0 && $weight <= 1000000)) {
    $ok = false;
}
if(!(is_numeric($height) && $height >= 0 && $height <= 1000000)) {
    $ok = false;
}
if(strlen($type) < 2 || strlen($type) > 100) {
    $ok = false;
}
if(strlen($evolution) < 2 || strlen($evolution) > 100) {
    $ok = false;
}

//hack, uso la sesion para guardar datos 'temporales'
$_SESSION['old']['name'] = $name;
$_SESSION['old']['weight'] = $weight;
$_SESSION['old']['height'] = $height;
$_SESSION['old']['type'] = $type;
$_SESSION['old']['evolution'] = $evolution;

//si falla la validacion, redireccion
if($ok === false) {
    header('Location: create.php?op=errordata&result=0');
    exit;
}

//insert con sentencia preparada
$sql = 'insert into pokemon (name, weight, height, type, evolution) values (:name, :weight, :height, :type, :evolution)';
$sentence = $connection->prepare($sql);
$parameters = ['name' => $name, 'weight' => $weight, 'height' => $height, 'type' => $type, 'evolution' => $evolution];
foreach($parameters as $nombreParametro => $valorParametro) {
    $sentence->bindValue($nombreParametro, $valorParametro);
}

//sentencia preparada en ejecucion
//2º capturo el error
try {
    /*if(!$sentence->execute()){
        echo 'no sql';
        exit;
    }*/
    $sentence->execute();
    //esta es la UNICA dorma de obtener EL ID
    $result = $connection->lastInsertId();
	$url = 'index.php?op=insertpokemon&result=' . $result;
    unset($_SESSION['old']['name']);
    unset($_SESSION['old']['weight']);
    unset($_SESSION['old']['height']);
    unset($_SESSION['old']['type']);
    unset($_SESSION['old']['evolution']);
} catch(PDOException $e) {
    //echo '<pre>' . var_export($e, true) . '</pre>';
    $result = 0;
	$url = 'store.php?op=insertpokemon&result=' . $result;
    //exit;
}

header('Location: ' . $url); //redireccion
