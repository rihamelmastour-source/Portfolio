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

if(isset($_POST["valider"])){

$etat = 3;
    $update = $pdo->prepare("

    UPDATE deplacements

    SET etat_id=?,
        updated_at=NOW()

    WHERE id=?

    ");

    $update->execute([

        $etat,

        $id

    ]);

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

        $etat,

        nettoyer($_POST["commentaire"])

    ]);

    notification(

        $pdo,

        $deplacement["utilisateur_id"],

        "validation",

        "Déplacement validé",

        "Votre déplacement ".$deplacement["numero"]." a été validé.",

        "../deplacements/details.php?id=".$id

    );

    historique(

        $pdo,

        $_SESSION["user_id"],

        "Validation déplacement",

        "deplacements",

        $id,

        $deplacement["numero"]

    );

    redirect("liste.php");

}

?>

<h2 class="mb-20">

Validation du déplacement

</h2>

<div class="form-box">

<form method="post">

<div class="form-group">

<label>Commentaire</label>

<textarea
name="commentaire"></textarea>

</div>

<button
type="submit"
name="valider"
class="btn btn-success">

<i class="fa-solid fa-circle-check"></i>

Valider

</button>

</form>

</div>

<?php

require_once "../includes/footer.php";

?>