<?php

require_once __DIR__ . "/../config/connexion.php";
require_once __DIR__ . "/session.php";
require_once __DIR__ . "/functions.php";

?>
<!DOCTYPE html>
<html lang="fr">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= APP_NAME ?></title>

<link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<div class="sidebar">

<?php include "sidebar.php"; ?>

</div>

<div class="main">

<?php include "navbar.php"; ?>

<div class="content">
<a href="/GESTDEP/validations/liste.php">
</a>