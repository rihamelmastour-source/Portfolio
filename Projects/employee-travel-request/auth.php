<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/functions.php";

if (!isLogged()) {

    redirect(BASE_URL . "login.php");

}