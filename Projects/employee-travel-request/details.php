<?php

require_once "../includes/header.php";

if (!isset($_GET["id"])) {
    redirect("liste.php");
}

$id = (int)$_GET["id"];

$sql = $pdo->prepare("

SELECT

d.*,

u.nom,

u.prenom,

vd.nom AS ville_depart_nom,

va.nom AS ville_arrivee_nom,

t.nom AS transport,

e.nom AS etat

FROM deplacements d

INNER JOIN utilisateurs u
ON d.utilisateur_id=u.id

INNER JOIN villes vd
ON d.ville_depart=vd.id

INNER JOIN villes va
ON d.ville_arrivee=va.id

INNER JOIN transports t
ON d.transport_id=t.id

INNER JOIN etats e
ON d.etat_id=e.id

WHERE d.id=?

");

$sql->execute([$id]);

$row = $sql->fetch();

if(!$row){
    redirect("liste.php");
}

?>

<h2 class="mb-20">

Détails du déplacement

</h2>

<div class="profile">

<table>

<tr>
<th>Numéro</th>
<td><?= e($row["numero"]) ?></td>
</tr>

<tr>
<th>Employé</th>
<td><?= e($row["prenom"]) ?> <?= e($row["nom"]) ?></td>
</tr>

<tr>
<th>Ville départ</th>
<td><?= e($row["ville_depart_nom"]) ?></td>
</tr>

<tr>
<th>Ville arrivée</th>
<td><?= e($row["ville_arrivee_nom"]) ?></td>
</tr>

<tr>
<th>Transport</th>
<td><?= e($row["transport"]) ?></td>
</tr>

<tr>
<th>Objet</th>
<td><?= e($row["objet"]) ?></td>
</tr>

<tr>
<th>Description</th>
<td><?= nl2br(e($row["description"])) ?></td>
</tr>

<tr>
<th>Date départ</th>
<td><?= formatDate($row["date_depart"]) ?></td>
</tr>

<tr>
<th>Date retour</th>
<td><?= formatDate($row["date_retour"]) ?></td>
</tr>

<tr>
<th>Distance</th>
<td><?= e($row["distance"]) ?> Km</td>
</tr>

<tr>
<th>Coût estimé</th>
<td><?= formatMoney($row["cout_estime"]) ?></td>
</tr>

<tr>
<th>Avance</th>
<td><?= formatMoney($row["avance"]) ?></td>
</tr>

<tr>
<th>État</th>
<td><?= e($row["etat"]) ?></td>
</tr>

</table>

</div>

<?php

require_once "../includes/footer.php";

?>