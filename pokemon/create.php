<?php
// control de ssión
session_start();
if(!isset($_SESSION['user'])) {
    header('Location:.');
    exit;
}
//para ver todos los errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

//lectura de datos de lña sesion
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
    $price = $_SESSION['old']['weight'];
    unset($_SESSION['old']['weight']);
}
if(isset($_SESSION['old']['height'])) {
    $price = $_SESSION['old']['height'];
    unset($_SESSION['old']['height']);
}
if(isset($_SESSION['old']['type'])) {
    $price = $_SESSION['old']['type'];
    unset($_SESSION['old']['type']);
}
if(isset($_SESSION['old']['evolution'])) {
    $evolution = $_SESSION['old']['evolution'];
    unset($_SESSION['old']['evolution']);
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>dwes</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="..">dwes</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="..">home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./">Pokemon</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div class="container">
                    <h4 class="display-4">pokemon</h4>
                </div>
            </div>
            <div class="container">
                <?php
                    if(isset($_GET['op']) && isset($_GET['result'])) {
                        if($_GET['result'] > 0) {
                            ?>
                            <div class="alert alert-primary" role="alert">
                                result: <?= $_GET['op'] . ' ' . $_GET['result'] ?>
                            </div>
                            <?php 
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                result: <?= $_GET['op'] . ' ' . $_GET['result'] ?>
                            </div>
                            <?php
                        }
                    }
                ?>
                <div>
                    <form action="store.php" method="post">
                        <div class="form-group">
                            <label for="name">pokemon name</label>
                            <input value="<?= $name ?>" required type="text" class="form-control" id="name" name="name" placeholder="pokemon name">
                        </div>
                        <div class="form-group">
                            <label for="weight">pokemon weight (kg)</label>
                            <input value="<?= $weight ?>" required type="number" step="0.001" class="form-control" id="weight" name="weight" placeholder="pokemon weight">
                        </div>
                        <div class="form-group">
                            <label for="height">pokemon height (m)</label>
                            <input value="<?= $height ?>" required type="number" step="0.001" class="form-control" id="height" name="height" placeholder="pokemon height">
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label><br>
                            <select name="type" id="type">
                            <option value="Normal" <?= $type == 'Normal' ? 'selected' : '' ?>>Normal</option>
                                <option value="Fire" <?= $type == 'Fire' ? 'selected' : '' ?>>Fire</option>
                                <option value="Water" <?= $type == 'Water' ? 'selected' : '' ?>>Water</option>
                                <option value="Grass" <?= $type == 'Grass' ? 'selected' : '' ?>>Grass</option>
                                <option value="Electric" <?= $type == 'Electric' ? 'selected' : '' ?>>Electric</option>
                                <option value="Ice" <?= $type == 'Ice' ? 'selected' : '' ?>>Ice</option>
                                <option value="Fighting" <?= $type == 'Fighting' ? 'selected' : '' ?>>Fighting</option>
                                <option value="Poison" <?= $type == 'Poison' ? 'selected' : '' ?>>Poison</option>
                                <option value="Ground" <?= $type == 'Ground' ? 'selected' : '' ?>>Ground</option>
                                <option value="Flying" <?= $type == 'Flying' ? 'selected' : '' ?>>Flying</option>
                                <option value="Psychic" <?= $type == 'Psychic' ? 'selected' : '' ?>>Psychic</option>
                                <option value="Bug" <?= $type == 'Bug' ? 'selected' : '' ?>>Bug</option>
                                <option value="Rock" <?= $type == 'Rock' ? 'selected' : '' ?>>Rock</option>
                                <option value="Ghost" <?= $type == 'Ghost' ? 'selected' : '' ?>>Ghost</option>
                                <option value="Dragon" <?= $type == 'Dragon' ? 'selected' : '' ?>>Dragon</option>
                                <option value="Dark" <?= $type == 'Dark' ? 'selected' : '' ?>>Dark</option>
                                <option value="Steel Fairy" <?= $type == 'Steel Fairy' ? 'selected' : '' ?>>Steel Fairy</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="evolution">pokemon evolutions</label>
                            <input value="<?= $evolution ?>" required type="text" step="0.001" class="form-control" id="evolution" name="evolution" placeholder="pokemon evolution">
                        </div>
                        <button type="submit" class="btn btn-primary">add</button>
                    </form>
                </div>
                <hr>
            </div>
        </main>
        <footer class="container">
            <p>Pokemon 2024</p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>