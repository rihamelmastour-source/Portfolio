<?php

require_once "includes/header.php";

$totalUtilisateurs = $pdo->query("
SELECT COUNT(*)
FROM utilisateurs
")->fetchColumn();

$totalDemandes = $pdo->query("
SELECT COUNT(*)
FROM deplacements
")->fetchColumn();

$enAttente = $pdo->query("
SELECT COUNT(*)
FROM deplacements
WHERE etat_id = 1
")->fetchColumn();

$valide = $pdo->query("
SELECT COUNT(*)
FROM deplacements
WHERE etat_id = 3
")->fetchColumn();

$refuse = $pdo->query("
SELECT COUNT(*)
FROM deplacements
WHERE etat_id = 4
")->fetchColumn();

?>
<div class="cards">
<div class="card"
onclick="window.location.href='/GESTDEP/utilisateurs/liste.php'"     style="cursor:pointer;">

    <i class="fa-solid fa-users"></i>

    <h4>Utilisateurs</h4>

    <h2><?= $totalUtilisateurs ?></h2>

</div>

<div class="card"
     onclick="window.location.href='/GESTDEP/deplacements/liste.php'"
     style="cursor:pointer;">

    <i class="fa-solid fa-route"></i>

    <h4>Déplacements</h4>

    <h2><?= $totalDemandes ?></h2>

</div>

<div class="card"
     onclick="window.location.href='/GESTDEP/validations/liste.php?etat=1'"
     style="cursor:pointer;">

    <i class="fa-solid fa-clock"></i>

    <h4>En attente</h4>

    <h2><?= $enAttente ?></h2>

</div>

<div class="card"
     onclick="window.location.href='/GESTDEP/validations/liste.php?etat=3'"
     style="cursor:pointer;">

    <i class="fa-solid fa-circle-check"></i>

    <h4>Validés</h4>

    <h2><?= $valide ?></h2>

</div>

<div class="card"
     onclick="window.location.href='/GESTDEP/validations/liste.php?etat=4'"
     style="cursor:pointer;">

    <i class="fa-solid fa-circle-xmark"></i>

    <h4>Refusés</h4>

    <h2><?= $refuse ?></h2>

</div>

</div>

<div class="table-container">

<h2 class="mb-20">

Dernières demandes

</h2>

<table>

<thead>

<tr>

<th>N°</th>

<th>Employé</th>

<th>Objet</th>

<th>Date départ</th>

<th>Date retour</th>

<th>État</th>

</tr>

</thead>

<tbody>

<?php
$sql = $pdo->query("
SELECT
    d.numero,
    d.objet,
    d.date_depart,
    d.date_retour,
    e.nom AS etat,
    u.nom,
    u.prenom
FROM deplacements d
INNER JOIN utilisateurs u
    ON u.id = d.utilisateur_id
INNER JOIN etats e
    ON e.id = d.etat_id
ORDER BY d.id DESC
LIMIT 10
");


while($row = $sql->fetch()):

?>

<tr>

<td><?= e($row["numero"]) ?></td>

<td><?= e($row["prenom"]) ?> <?= e($row["nom"]) ?></td>

<td><?= e($row["objet"]) ?></td>

<td><?= formatDate($row["date_depart"]) ?></td>

<td><?= formatDate($row["date_retour"]) ?></td>

<td><?= e($row["etat"]) ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php

require_once "includes/footer.php";

?>