<?php

require_once "../includes/header.php";

if (!isset($_GET["id"])) {
    redirect("liste.php");
}

$id = (int) $_GET["id"];

$sql = $pdo->prepare("
SELECT *
FROM deplacements
WHERE id = ?
");

$sql->execute([$id]);

$deplacement = $sql->fetch();

if (!$deplacement) {
    redirect("liste.php");
}

if (isset($_POST["modifier"])) {

    $update = $pdo->prepare("

    UPDATE deplacements SET

        ville_depart=?,
        ville_arrivee=?,
        transport_id=?,
        objet=?,
        description=?,
        date_depart=?,
        heure_depart=?,
        date_retour=?,
        heure_retour=?,
        distance=?,
        cout_estime=?,
        avance=?,
        updated_at=NOW()

    WHERE id=?

    ");

    $update->execute([

        $_POST["ville_depart"],
        $_POST["ville_arrivee"],
        $_POST["transport"],
        nettoyer($_POST["objet"]),
        nettoyer($_POST["description"]),
        $_POST["date_depart"],
        $_POST["heure_depart"],
        $_POST["date_retour"],
        $_POST["heure_retour"],
        $_POST["distance"],
        $_POST["cout_estime"],
        $_POST["avance"],
        $id

    ]);

    historique(
        $pdo,
        $_SESSION["user_id"],
        "Modification déplacement",
        "deplacements",
        $id,
        $deplacement["numero"]
    );

    redirect("liste.php");

}

$villes = $pdo->query("
SELECT *
FROM villes
ORDER BY nom
");

$transports = $pdo->query("
SELECT *
FROM transports
ORDER BY nom
");

?>

<h2 class="mb-20">

Modifier un déplacement

</h2>

<div class="form-box">

<form method="post">

<div class="form-group">

<label>Numéro</label>

<input
type="text"
value="<?= e($deplacement["numero"]) ?>"
readonly>

</div>

<div class="form-group">

<label>Ville départ</label>

<select name="ville_depart">

<?php while($v=$villes->fetch()): ?>

<option
value="<?= $v["id"] ?>"
<?= $deplacement["ville_depart"]==$v["id"]?"selected":"" ?>>

<?= e($v["nom"]) ?>

</option>

<?php endwhile; ?>

</select>

</div>

<?php

$villes = $pdo->query("
SELECT *
FROM villes
ORDER BY nom
");

?>

<div class="form-group">

<label>Ville arrivée</label>

<select name="ville_arrivee">

<?php while($v=$villes->fetch()): ?>

<option
value="<?= $v["id"] ?>"
<?= $deplacement["ville_arrivee"]==$v["id"]?"selected":"" ?>>

<?= e($v["nom"]) ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="form-group">

<label>Transport</label>

<select name="transport">

<?php while($t=$transports->fetch()): ?>

<option
value="<?= $t["id"] ?>"
<?= $deplacement["transport_id"]==$t["id"]?"selected":"" ?>>

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
value="<?= e($deplacement["objet"]) ?>"
required>

</div>

<div class="form-group">

<label>Description</label>

<textarea
name="description"><?= e($deplacement["description"]) ?></textarea>

</div>

<div class="form-group">

<label>Date départ</label>

<input
type="date"
name="date_depart"
value="<?= $deplacement["date_depart"] ?>"
required>

</div>

<div class="form-group">

<label>Heure départ</label>

<input
type="time"
name="heure_depart"
value="<?= $deplacement["heure_depart"] ?>"
required>

</div>

<div class="form-group">

<label>Date retour</label>

<input
type="date"
name="date_retour"
value="<?= $deplacement["date_retour"] ?>"
required>

</div>

<div class="form-group">

<label>Heure retour</label>

<input
type="time"
name="heure_retour"
value="<?= $deplacement["heure_retour"] ?>"
required>

</div>

<div class="form-group">

<label>Distance</label>

<input
type="number"
step="0.01"
name="distance"
value="<?= $deplacement["distance"] ?>">

</div>

<div class="form-group">

<label>Coût estimé</label>

<input
type="number"
step="0.01"
name="cout_estime"
value="<?= $deplacement["cout_estime"] ?>">

</div>

<div class="form-group">

<label>Avance</label>

<input
type="number"
step="0.01"
name="avance"
value="<?= $deplacement["avance"] ?>">

</div>

<button
type="submit"
name="modifier">

<i class="fa-solid fa-floppy-disk"></i>

Mettre à jour

</button>

</form>

</div>

<?php

require_once "../includes/footer.php";

?>