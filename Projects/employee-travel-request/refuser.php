<?php

require_once "../includes/header.php";

autoriser(["Administrateur","Responsable"]);

if(!isset($_GET["id"])){

    redirect("liste.php");

}

$id = (int)$_GET["id"];

$sql = $pdo->prepare("

SELECT *

FROM deplacements

WHERE id=?

");

$sql->execute([$id]);

$deplacement = $sql->fetch();

if(!$deplacement){

    redirect("liste.php");

}

if(isset($_POST["refuser"])){

    $update = $pdo->prepare("

    UPDATE deplacements

    SET etat_id=4,
        updated_at=NOW()

    WHERE id=?

    ");

    $update->execute([$id]);

    $workflow = $pdo->prepare("

    INSERT INTO workflow_validation(

        deplacement_id,

        valide_par,

        etat_avant,

        etat_apres,

        commentaire

    )

    VALUES(?,?,?,?,?)

    ");

    $workflow->execute([

        $id,

        $_SESSION["user_id"],

        $deplacement["etat_id"],

        4,

        nettoyer($_POST["commentaire"])

    ]);

    notification(

        $pdo,

        $deplacement["utilisateur_id"],

        "refus",

        "Déplacement refusé",

        "Votre déplacement ".$deplacement["numero"]." a été refusé.",

        "../deplacements/details.php?id=".$id

    );

    historique(

        $pdo,

        $_SESSION["user_id"],

        "Refus déplacement",

        "deplacements",

        $id,

        $deplacement["numero"]

    );

    redirect("liste.php");

}

?>

<h2 class="mb-20">

Refuser un déplacement

</h2>

<div class="form-box">

<form method="post">

<div class="form-group">

<label>Motif du refus</label>

<textarea
name="commentaire"
required></textarea>

</div>

<button
type="submit"
name="refuser"
class="btn btn-danger">

<i class="fa-solid fa-circle-xmark"></i>

Refuser

</button>

</form>

</div>

<?php

require_once "../includes/footer.php";

?>