<?php
require 'db.php';

$erreur = '';
$nom = '';
$prenom = '';
$dateNaissance = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $dateNaissance = trim($_POST['date_naissance'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $date = DateTime::createFromFormat('Y-m-d', $dateNaissance);
    $dateValide = $date && $date->format('Y-m-d') === $dateNaissance;

    if ($nom === '' || $prenom === '' || !$dateValide || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Vérifiez les champs saisis, puis réessayez.';
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO etudiant (nom, prenom, date_naissance, email) VALUES (:nom, :prenom, :date_naissance, :email)'
        );
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':date_naissance' => $dateNaissance,
            ':email' => $email,
        ]);

        header('Location: index.php');
        exit;
    }
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un étudiant</title>
</head>
<body>
    <h1>Ajouter un étudiant</h1>
    <p><a href="index.php">Retour à la liste</a></p>

    <?php if ($erreur !== ''): ?>
        <p role="alert"><?= e($erreur) ?></p>
    <?php endif; ?>

    <form method="post" action="insert.php">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= e($nom) ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= e($prenom) ?>" required><br>

        <label for="date_naissance">Date de naissance :</label>
        <input type="date" name="date_naissance" id="date_naissance" value="<?= e($dateNaissance) ?>" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?= e($email) ?>" required><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
