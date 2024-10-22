<?php

session_start();

if(!isset($_SESSION['user'])) {
    header('Location:.');
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$user = null;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

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
    echo 'no connection';
    exit;
}

$name = '';
$weight = '';
$height = '';
$type = '';
$evolution = '';
if(isset($_SESSION['old']['name'])) {
    $name = $_SESSION['old']['name'];
    unset($_SESSION['old']['name']);
}
if(isset($_SESSION['old']['weight'])) {
    $weight = $_SESSION['old']['weight'];
    unset($_SESSION['old']['weight']);
}
if(isset($_SESSION['old']['height'])) {
    $height = $_SESSION['old']['height'];
    unset($_SESSION['old']['height']);
}
if(isset($_SESSION['old']['type'])) {
    $type = $_SESSION['old']['type'];
    unset($_SESSION['old']['type']);
}
if(isset($_SESSION['old']['evolution'])) {
    $evolution = $_SESSION['old']['evolution'];
    unset($_SESSION['old']['evolution']);
}


if(isset($_POST['name'])) {
    $name = $_POST['name'];
} else {
    echo 'no name';
    exit;
}
if(isset($_POST['weight'])) {
    $weight = $_POST['weight'];
} else {
    echo 'no weight';
    exit;
}
if(isset($_POST['height'])) {
    $height = $_POST['height'];
} else {
    echo 'no height';
    exit;
}
if(isset($_POST['type'])) {
    $type = $_POST['type'];
} else {
    echo 'no type';
    exit;
}
if(isset($_POST['evolution'])) {
    $evolution = $_POST['evolution'];
} else {
    echo 'no evolution';
    exit;
}
if(isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo 'no id';
    exit;
}

$sql = 'update pokemon set name = :name, weight = :weight,  height = :height,  type = :type,  evolution = :evolution where id = :id';
$sentence = $connection->prepare($sql);
$parameters = ['name' => $name, 'weight' => $weight, 'height' => $height, 'type' => $type, 'evolution' => $evolution, 'id' => $id];
foreach($parameters as $nombreParametro => $valorParametro) {
    $sentence->bindValue($nombreParametro, $valorParametro);
}

$resultado = 1;
try {
    $sentence->execute();
    $resultado = $sentence->rowCount();
    $url = '.?op=editpokemon&result=' . $resultado;
} catch(PDOException $e) {
    $resultado = 0;
    $_SESSION['old']['name'] = $name;
    $_SESSION['old']['weight'] = $weight;
    $_SESSION['old']['height'] = $height;
    $_SESSION['old']['type'] = $type;
    $_SESSION['old']['evolution'] = $evolution;
    $url = 'edit.php?id=' . $id . '&op=editpokemon&result=' . $resultado;
}

header('Location: ' . $url);