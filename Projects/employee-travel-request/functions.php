<?php

function nettoyer($donnee)
{
    return htmlspecialchars(trim($donnee));
}
function e($texte)
{
    return htmlspecialchars($texte ?? "", ENT_QUOTES, "UTF-8");
}

function redirect($url)
{
    header("Location: ".$url);
    exit();
}

function formatMoney($montant)
{
    return number_format($montant,2,","," ")." DH";
}
/* ===========================
   AUTHENTIFICATION
=========================== */

function isLogged(): bool
{
    return isset($_SESSION["user_id"]);
}

function isAdmin(): bool
{
    return isset($_SESSION["role"]) &&
           $_SESSION["role"] === "Administrateur";
}

function isResponsable(): bool
{
    return isset($_SESSION["role"]) &&
           $_SESSION["role"] === "Responsable";
}

function isEmploye(): bool
{
    return isset($_SESSION["role"]) &&
           $_SESSION["role"] === "Employe";
}



/* ===========================
   AUTORISATION
=========================== */

function autoriser(array $roles): void
{
    if (!isLogged()) {
        redirect(BASE_URL . "login.php");
    }

    if (!in_array($_SESSION['role'], $roles)) {

        http_response_code(403);

        die("<h2>Accès refusé</h2>");

    }
}

function notification(
    PDO $pdo,
    int $utilisateur_id,
    string $type,
    string $titre,
    string $message,
    string $url = null
): void {

    $sql = $pdo->prepare("
        INSERT INTO notifications
        (
            utilisateur_id,
            type,
            titre,
            message,
            url,
            lu,
            created_at
        )
        VALUES (?, ?, ?, ?, ?, 0, NOW())
    ");

    $sql->execute([
        $utilisateur_id,
        $type,
        $titre,
        $message,
        $url
    ]);

}

function historique(
    PDO $pdo,
    int $utilisateur_id,
    string $action,
    string $table_concernee,
    int $element_id,
    string $details
): void {

    $sql = $pdo->prepare("
        INSERT INTO historique
        (
            utilisateur_id,
            action,
            table_concernee,
            element_id,
            details,
            adresse_ip,
            created_at
        )
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");

    $sql->execute([
        $utilisateur_id,
        $action,
        $table_concernee,
        $element_id,
        $details,
        $_SERVER["REMOTE_ADDR"] ?? null
    ]);

}
function numeroDeplacement(PDO $pdo): string
{
    $sql = $pdo->query("
        SELECT MAX(id) AS dernier
        FROM deplacements
    ");

    $dernier = (int) $sql->fetchColumn();

    $nouveau = $dernier + 1;

    return "DEP-" . date("Y") . "-" . str_pad($nouveau, 5, "0", STR_PAD_LEFT);
}
function formatDate($date)
{
    if (empty($date)) {
        return '-';
    }

    return date('d/m/Y', strtotime($date));
}
?>