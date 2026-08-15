<?php

require_once "../includes/header.php";

autoriser(["Administrateur","Responsable"]);

if(!isset($_GET["id"])){
    redirect("liste.php");
}

$id = (int)$_GET["id"];

$sql = $pdo->prepare("
SELECT numero
FROM deplacements
WHERE id=?
");

$sql->execute([$id]);

$data = $sql->fetch();

if(!$data){
    redirect("liste.php");
}

if(isset($_POST["supprimer"])){

    $delete = $pdo->prepare("
    DELETE FROM deplacements
    WHERE id=?
    ");

    $delete->execute([$id]);

    historique(
        $pdo,
        $_SESSION["user_id"],
        "Suppression déplacement",
        "deplacements",
        $id,
        $data["numero"]
    );

    redirect("liste.php");

}

?>

<h2 class="mb-20">

Supprimer un déplacement

</h2>

<div class="form-box">

<p>

Voulez-vous supprimer le déplacement

<strong><?= e($data["numero"]) ?></strong> ?

</p>

<br>

<form method="post">

<button
type="submit"
name="supprimer"
class="btn btn-danger">

Supprimer

</button>

<a
href="liste.php"
class="btn btn-secondary">

Annuler

</a>

</form>

</div>

<?php

require_once "../includes/footer.php";

?>