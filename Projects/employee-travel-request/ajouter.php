<?php

require_once "../includes/header.php";

$numero = numeroDeplacement($pdo);

if(isset($_POST["enregistrer"])){

$numero = numeroDeplacement($pdo);

$sql = $pdo->prepare("

INSERT INTO deplacements(

numero,

utilisateur_id,

ville_depart,

ville_arrivee,

transport_id,

etat_id,

objet,

description,

date_depart,

heure_depart,

date_retour,

heure_retour,

distance,

cout_estime,

avance


)

VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)

");

$sql->execute([

$numero,

$_SESSION["user_id"],

$_POST["ville_depart"],

$_POST["ville_arrivee"],

$_POST["transport"],

1,

nettoyer($_POST["objet"]),

nettoyer($_POST["description"]),

$_POST["date_depart"],

$_POST["heure_depart"],

$_POST["date_retour"],

$_POST["heure_retour"],

$_POST["distance"],

$_POST["cout_estime"],

$_POST["avance"]

]);

historique(

$pdo,

$_SESSION["user_id"],

"Création déplacement",

"deplacements",

$pdo->lastInsertId(),

$numero

);

redirect("liste.php");

}

$villes=$pdo->query("SELECT * FROM villes ORDER BY nom");

$transports=$pdo->query("SELECT * FROM transports ORDER BY nom");

?>

<h2 class="mb-20">

Nouveau déplacement

</h2>

<div class="form-box">

<form method="post">

<div class="form-group">

<label>Numéro</label>

<input
type="text"
value="<?= e($numero) ?>"
readonly>

</div>

<div class="form-group">

<label>Ville départ</label>

<select name="ville_depart" required>

<?php while($v=$villes->fetch()): ?>

<option value="<?= $v["id"] ?>">

<?= e($v["nom"]) ?>

</option>

<?php endwhile; ?>

</select>

</div>

<?php

$villes->execute();

?>

<div class="form-group">

<label>Ville arrivée</label>

<select name="ville_arrivee" required>

<?php while($v=$villes->fetch()): ?>

<option value="<?= $v["id"] ?>">

<?= e($v["nom"]) ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="form-group">

<label>Transport</label>

<select name="transport">

<?php while($t=$transports->fetch()): ?>

<option value="<?= $t["id"] ?>">

<?= e($t["nom"]) ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="form-group">

<label>Objet</label>

<input
type="text"
name="objet"
required>

</div>

<div class="form-group">

<label>Description</label>

<textarea name="description"></textarea>

</div>

<div class="form-group">

<label>Date départ</label>

<input
type="date"
name="date_depart"
required>

</div>

<div class="form-group">

<label>Heure départ</label>

<input
type="time"
name="heure_depart"
required>

</div>

<div class="form-group">

<label>Date retour</label>

<input
type="date"
name="date_retour"
required>

</div>

<div class="form-group">

<label>Heure retour</label>

<input
type="time"
name="heure_retour"
required>

</div>

<div class="form-group">

<label>Distance (Km)</label>

<input
type="number"
step="0.01"
name="distance">

</div>

<div class="form-group">

<label>Coût estimé</label>

<input
type="number"
step="0.01"
name="cout_estime">

</div>

<div class="form-group">

<label>Avance</label>

<input
type="number"
step="0.01"
name="avance">

</div>

<button
type="submit"
name="enregistrer">

<i class="fa-solid fa-floppy-disk"></i>

Enregistrer

</button>

</form>

</div>

<?php

require_once "../includes/footer.php";

?>