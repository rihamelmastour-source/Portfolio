<?php

require_once "../config/connexion.php";
require_once "../includes/functions.php";

if (!isset($_GET["id"])) {
    exit();
}

$id = (int) $_GET["id"];

$sql = $pdo->prepare("

SELECT

d.*,

u.nom,
u.prenom,
u.signature,

vd.nom AS depart,
va.nom AS arrivee,

t.nom AS transport,

e.nom AS etat

FROM deplacements d

INNER JOIN utilisateurs u
ON d.utilisateur_id = u.id

INNER JOIN villes vd
ON d.ville_depart = vd.id

INNER JOIN villes va
ON d.ville_arrivee = va.id

INNER JOIN transports t
ON d.transport_id = t.id

INNER JOIN etats e
ON d.etat_id = e.id

WHERE d.id = ?

");

$sql->execute([$id]);

$data = $sql->fetch();

if (!$data) {
    exit();
}

?>

<!DOCTYPE html>

<html lang="fr">

<head>

<meta charset="UTF-8">

<title>Ordre de Mission</title>

<link rel="stylesheet" href="../css/style.css">

</head>

<body onload="window.print()">

<h1 style="text-align:center;">
ISICOD
</h1>

<h2 style="text-align:center;">
Ordre de Mission
</h2>

<table border="1" width="100%" cellpadding="8">

<tr>
<th>Numéro</th>
<td><?= e($data["numero"]) ?></td>
</tr>

<tr>
<th>Employé</th>
<td><?= e($data["prenom"]) ?> <?= e($data["nom"]) ?></td>
</tr>

<tr>
<th>Ville de départ</th>
<td><?= e($data["depart"]) ?></td>
</tr>

<tr>
<th>Ville d'arrivée</th>
<td><?= e($data["arrivee"]) ?></td>
</tr>

<tr>
<th>Transport</th>
<td><?= e($data["transport"]) ?></td>
</tr>

<tr>
<th>Objet</th>
<td><?= e($data["objet"]) ?></td>
</tr>

<tr>
<th>Description</th>
<td><?= nl2br(e($data["description"])) ?></td>
</tr>
<tr>
<th>Date de départ</th>
<td><?= formatDate($data["date_depart"]) ?></td>
</tr>

<tr>
<th>Date de retour</th>
<td><?= formatDate($data["date_retour"]) ?></td>
</tr>

<tr>
<th>État</th>
<td><?= e($data["etat"]) ?></td>
</tr>

</table>

<br><br>

<table width="100%">

<tr>

<td align="center" width="50%">

<strong>Signature Employé</strong>

<br><br><br><br><br><br>

_________________________

</td>

<td align="center" width="50%">

<strong>Signature Responsable</strong>

<br><br>

<?php if(!empty($data["signature"])): ?>

<img
src="../uploads/signatures/<?= e($data["signature"]) ?>"
width="150"
alt="Signature">

<?php endif; ?>

</td>

</tr>

</table>
</body>

</html>