<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/db.php';

$db = getDB();

$stmt = $db->prepare(
    "SELECT id, nom, prenom, email
     FROM utilisateurs
     WHERE id = ?"
);

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$pageTitle = 'Mon Profil';

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/profil.css">
</head>
<body>
    

<main class="profile-page">

    <div class="profile-card">

        <div class="profile-avatar">
            👩‍🍳
        </div>

        <h1 class="profile-name">
            <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>
        </h1>

        <p class="profile-email">
            <?php echo htmlspecialchars($user['email']); ?>
        </p>

        <div class="profile-info">

            <div class="info-item">
                <strong>ID du compte :</strong>
                #<?php echo $user['id']; ?>
            </div>

            <div class="info-item">
                <strong>Statut :</strong>
                ✔ Actif
            </div>

        </div>

        <div class="profile-actions">

            <a href="accueil.html" class="btn-profile">
                🏠 Accueil
            </a>

            <a href="logout.php" class="btn-profile logout-btn">
                🚪 Déconnexion
            </a>

        </div>

    </div>

</main>


</body>
</html>
<?php
include 'footer.php';
?>