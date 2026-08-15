<?php

require_once "../includes/header.php";

$etat = isset($_GET["etat"]) ? (int)$_GET["etat"] : 0;

if($etat > 0){

    $sql = $pdo->prepare("

    SELECT

    d.id,
    d.numero,
    u.nom,
    u.prenom,
    vd.nom AS ville_depart,
    va.nom AS ville_arrivee,
    t.nom AS transport,
    e.nom AS etat,
    d.date_depart,
    d.date_retour

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

    WHERE d.etat_id=?

    ORDER BY d.id DESC

    ");

    $sql->execute([$etat]);

}else{

    $sql = $pdo->query("

    SELECT

    d.id,
    d.numero,
    u.nom,
    u.prenom,
    vd.nom AS ville_depart,
    va.nom AS ville_arrivee,
    t.nom AS transport,
    e.nom AS etat,
    d.date_depart,
    d.date_retour

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

    ORDER BY d.id DESC

    ");

}

?>

<h2 class="mb-20">

Gestion des déplacements

</h2>

<a
href="ajouter.php"
class="btn btn-success mb-20">

<i class="fa-solid fa-circle-plus"></i>

Nouveau déplacement

</a>

<div class="table-container">

<table>

<thead>

<tr>

<th>N°</th>

<th>Employé</th>

<th>Départ</th>

<th>Arrivée</th>

<th>Transport</th>

<th>Date départ</th>

<th>Date retour</th>

<th>État</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php while($row=$sql->fetch()): ?>

<tr>

<td><?= e($row["numero"]) ?></td>

<td><?= e($row["prenom"]) ?> <?= e($row["nom"]) ?></td>

<td><?= e($row["ville_depart"]) ?></td>

<td><?= e($row["ville_arrivee"]) ?></td>

<td><?= e($row["transport"]) ?></td>

<td><?= formatDate($row["date_depart"]) ?></td>

<td><?= formatDate($row["date_retour"]) ?></td>

<td><?= e($row["etat"]) ?></td>

<td>

<div class="actions">

<a
class="view"
href="details.php?id=<?= $row["id"] ?>">

<i class="fa-solid fa-eye"></i>

</a>

<a
class="edit"
href="modifier.php?id=<?= $row["id"] ?>">

<i class="fa-solid fa-pen"></i>

</a>

<a
class="print"
href="../impressions/deplacement.php?id=<?= $row["id"] ?>">

<i class="fa-solid fa-print"></i>

</a>

<a
class="delete"
href="supprimer.php?id=<?= $row["id"] ?>">

<i class="fa-solid fa-trash"></i>

</a>

</div>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php

require_once "../includes/footer.php";

?>