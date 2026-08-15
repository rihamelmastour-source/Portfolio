<?php

require_once "../includes/header.php";

$id = $_SESSION["user_id"];

$sql = $pdo->prepare("

SELECT

u.*,

r.nom AS role,

d.nom AS departement,

p.nom AS poste

FROM utilisateurs u

INNER JOIN roles r
ON r.id=u.role_id

INNER JOIN departements d
ON d.id=u.departement_id

INNER JOIN postes p
ON p.id=u.poste_id

WHERE u.id=?

");

$sql->execute([$id]);

$user = $sql->fetch();

?>

<h2 class="mb-20">

Mon Profil

</h2>

<div class="profile">

<div class="profile-header">

<img
src="../images/<?= e($user["photo"]) ?>"
alt="Photo">

<div>

<h2>

<?= e($user["prenom"]) ?>

<?= e($user["nom"]) ?>

</h2>

<p><?= e($user["role"]) ?></p>

</div>

</div>

<table>

<tr>

<th>Email</th>

<td><?= e($user["email"]) ?></td>

</tr>

<tr>

<th>Matricule</th>

<td><?= e($user["matricule"]) ?></td>

</tr>

<tr>

<th>Téléphone</th>

<td><?= e($user["telephone"]) ?></td>

</tr>

<tr>

<th>Département</th>

<td><?= e($user["departement"]) ?></td>

</tr>

<tr>

<th>Poste</th>

<td><?= e($user["poste"]) ?></td>

</tr>

</table>

</div>

<?php

require_once "../includes/footer.php";

?>