<?php
require 'db.php';

$stmt = $pdo->query('SELECT id, nom, prenom, date_naissance, email FROM etudiant ORDER BY id DESC');
$etudiants = $stmt->fetchAll();

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
    <title>Liste des étudiants</title>
</head>
<body>
    <h1>Liste des étudiants</h1>
    <p><a href="insert.php">Ajouter un étudiant</a></p>

    <?php if (!$etudiants): ?>
        <p>Aucun étudiant pour le moment.</p>
    <?php else: ?>
        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $row): ?>
                    <tr>
                        <td><?= e($row['id']) ?></td>
                        <td><?= e($row['nom']) ?></td>
                        <td><?= e($row['prenom']) ?></td>
                        <td><?= e($row['date_naissance']) ?></td>
                        <td><?= e($row['email']) ?></td>
                        <td>
                            <form action="delete.php" method="post" onsubmit="return confirm('Supprimer cet étudiant ?');">
                                <input type="hidden" name="id" value="<?= e($row['id']) ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
