<?php
// ══════════════════════════════════════════
// COOK WITH SOUMI — login.php
// User login page
// ══════════════════════════════════════════

session_start();

// Déjà connecté
if (!empty($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}

require_once(__DIR__ . '/db.php');

$error = '';
$oldEmail = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération des données
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $oldEmail = htmlspecialchars($email);

    // Validation
    if (empty($email) || empty($password)) {

        $error = 'Please fill in all fields.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = 'Please enter a valid e-mail address.';

    } else {

        $db = getDB();

        // Recherche de l'utilisateur
        $stmt = $db->prepare(
            "SELECT id, username, password_hash
             FROM users
             WHERE email = ?
             LIMIT 1"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        // Vérification du mot de passe
        if (!$user || !password_verify($password, $user['password_hash'])) {

            $error = 'Invalid e-mail or password.';

        } else {

            // Sécurité
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header('Location: profile.php');
            exit;
        }
    }
}

$pageTitle = 'Log in';

include 'header.php';
?>

<main class="auth-page">

    <div class="auth-card">

        <img
            class="auth-logo"
            src="./img/CookWithSoumi-logo.png"
            alt="Cook With Soumi Logo">

        <h1 class="auth-title">Welcome back!</h1>

        <p class="auth-subtitle">
            Log in to your Cook With Soumi account
        </p>

        <?php if ($error): ?>
            <div class="alert alert-error">
                ⚠ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form
            class="auth-form"
            method="POST"
            action="login.php"
            novalidate>

            <div class="form-group">

                <label for="email">E-mail</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo $oldEmail; ?>"
                    placeholder="you@example.com"
                    required
                    autocomplete="email">

            </div>

            <div class="form-group">

                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Your password"
                    required
                    autocomplete="current-password">

            </div>

            <button type="submit" class="btn-auth">
                Log in 🍽️
            </button>

        </form>

        <p class="auth-link">
            No account yet ?
            <a href="register.php">Sign up</a>
        </p>

    </div>

</main>

<?php
closeDB();
include 'includes/footer.php';
?>