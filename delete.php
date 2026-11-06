<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id !== false && $id !== null) {
    $stmt = $pdo->prepare('DELETE FROM etudiant WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

header('Location: index.php');
exit;
