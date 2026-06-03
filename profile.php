<?php
// ══════════════════════════════════════════
// COOK WITH SOUMI — profile.php
// Protected profile page (logged-in users only)
// ══════════════════════════════════════════

session_start();

// Vérification de connexion
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/db.php';

$db = getDB();

// Récupération des informations utilisateur
$stmt = $db->prepare(
    "SELECT id, username, email, created_at
     FROM users
     WHERE id = ?
     LIMIT 1"
);

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

// Utilisateur supprimé de la base
if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$pageTitle = 'My Profile';

include 'includes/header.php';
?>

<main class="profile-page">

    <div class="profile-card">

        <div class="profile-avatar">👩‍🍳</div>

        <h1 class="profile-name">
            <?php echo htmlspecialchars($user['username']); ?>
        </h1>

        <p class="profile-email">
            <?php echo htmlspecialchars($user['email']); ?>
        </p>

        <div class="profile-info">

            <div class="profile-info-row">
                <span class="profile-info-label">
                    Member since
                </span>

                <span class="profile-info-value">
                    <?php echo date('F j, Y', strtotime($user['created_at'])); ?>
                </span>
            </div>

            <div class="profile-info-row">
                <span class="profile-info-label">
                    Account ID
                </span>

                <span class="profile-info-value">
                    #<?php echo htmlspecialchars($user['id']); ?>
                </span>
            </div>

            <div class="profile-info-row">
                <span class="profile-info-label">
                    Status
                </span>

                <span
                    class="profile-info-value"
                    style="color:#276749;font-weight:800;">
                    ✔ Active
                </span>
            </div>

        </div>

        <a href="logout.php" class="btn-logout">
            🚪 Log out
        </a>

    </div>

</main>

<?php
closeDB();
include 'includes/footer.php';
?>