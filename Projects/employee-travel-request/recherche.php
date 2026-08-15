<?php

require_once "includes/header.php";

$mot = nettoyer($_GET["q"] ?? "");

$resultats = [];

if($mot != ""){

$sql = $pdo->prepare("

SELECT

d.id,

d.numero,

d.objet,

u.nom,

u.prenom

FROM deplacements d

INNER JOIN utilisateurs u

ON d.utilisateur_id=u.id

WHERE

d.numero LIKE ?

OR d.objet LIKE ?

OR u.nom LIKE ?

OR u.prenom LIKE ?

ORDER BY d.id DESC

");

$like = "%".$mot."%";

$sql->execute([

$like,

$like,

$like,

$like

]);

$resultats = $sql->fetchAll();

}

?>

<h2 class="mb-20">

Recherche

</h2>

<div class="form-box">

<form method="get">

<div class="form-group">

<input
type="text"
name="q"
value="<?= e($mot) ?>"
placeholder="Numéro, employé ou objet...">

</div>

<button>

Rechercher

</button>

</form>

</div>

<br>

<div class="table-container">

<table>

<thead>

<tr>

<th>Numéro</th>

<th>Employé</th>

<th>Objet</th>

<th></th>

</tr>

</thead>

<tbody>

<?php foreach($resultats as $r): ?>

<tr>

<td><?= e($r["numero"]) ?></td>

<td><?= e($r["prenom"]) ?> <?= e($r["nom"]) ?></td>

<td><?= e($r["objet"]) ?></td>

<td>

<a
class="btn btn-primary"
href="deplacements/details.php?id=<?= $r["id"] ?>">

Voir

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<?php

require_once "includes/footer.php";

?>