<?php

require_once "../includes/header.php";

autoriser(["Administrateur"]);

$sql = $pdo->query("

SELECT

h.*,

u.nom,

u.prenom

FROM historique h

INNER JOIN utilisateurs u

ON h.utilisateur_id=u.id

ORDER BY h.created_at DESC

LIMIT 500

");

?>

<h2 class="mb-20">

Historique des actions

</h2>

<div class="table-container">

<table>

<thead>

<tr>

<th>Date</th>

<th>Utilisateur</th>

<th>Action</th>

<th>Table</th>

<th>Détails</th>

<th>IP</th>

</tr>

</thead>

<tbody>

<?php while($row=$sql->fetch()): ?>

<tr>

<td><?= formatDate($row["created_at"]) ?></td>

<td><?= e($row["prenom"]) ?> <?= e($row["nom"]) ?></td>

<td><?= e($row["action"]) ?></td>

<td><?= e($row["table_concernee"]) ?></td>

<td><?= e($row["details"]) ?></td>

<td><?= e($row["adresse_ip"]) ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php

require_once "../includes/footer.php";

?>