<?php

require_once __DIR__ . "/config.php";

/*
|--------------------------------------------------------------------------
| Connexion PDO
|--------------------------------------------------------------------------
*/

$dbHost = "localhost";
$dbName = "gestdep";
$dbUser = "root";
$dbPass = "";

try {

    $pdo = new PDO(

        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",

        $dbUser,

        $dbPass

    );

    $pdo->setAttribute(

        PDO::ATTR_ERRMODE,

        PDO::ERRMODE_EXCEPTION

    );

    $pdo->setAttribute(

        PDO::ATTR_DEFAULT_FETCH_MODE,

        PDO::FETCH_ASSOC

    );

    $pdo->setAttribute(

        PDO::ATTR_EMULATE_PREPARES,

        false

    );

} catch (PDOException $e) {

    die(

        "<h2>Erreur de connexion</h2>

        <p>" .

        $e->getMessage() .

        "</p>"

    );

}