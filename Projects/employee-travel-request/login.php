<?php

session_start();

require_once "config/connexion.php";

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}

$message = "";

if (isset($_POST["connexion"])) {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = $pdo->prepare("
        SELECT utilisateurs.*, roles.nom AS role
        FROM utilisateurs
        INNER JOIN roles
            ON utilisateurs.role_id = roles.id
        WHERE utilisateurs.email = ?
        AND utilisateurs.actif = 1
        LIMIT 1
    ");

    $sql->execute([$email]);

    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["nom"] = $user["nom"];
        $_SESSION["prenom"] = $user["prenom"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["photo"] = $user["photo"];

        header("Location: dashboard.php");
        exit();

    } else {

        $message = "Email ou mot de passe incorrect.";

    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Connexion - GESTDEP</title>

  <link rel="stylesheet" href="/GESTDEP/css/style.css?v=<?= time() ?>">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body class="login-body">

<div class="login-box">

    <div class="logo">

        <i class="fa-solid fa-plane-departure"></i>

        <h1>GESTDEP</h1>

        <p>Gestion des Déplacements Professionnels</p>

    </div>

    <?php if (!empty($message)) : ?>

        <div class="error">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="input">

            <label>Email</label>

            <input
                type="email"
                name="email"
                required>

        </div>

        <div class="input">

            <label>Mot de passe</label>

            <input
                type="password"
                name="password"
                required>

        </div>

        <button
            type="submit"
            name="connexion">

            <i class="fa-solid fa-right-to-bracket"></i>

            Se connecter

        </button>

    </form>

</div>

</body>

</html>