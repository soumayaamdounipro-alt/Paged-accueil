<?php
session_start();

// Si déjà connecté
if (!empty($_SESSION['user_id'])) {
    header('Location:Accueil.php');
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

        $error = 'Veuillez remplir tous les champs.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = 'Adresse e-mail invalide.';

    } else {

        $db = getDB();

        // Recherche de l'utilisateur
        $stmt = $db->prepare(
            "SELECT id, nom, `Prenom`, email, password
             FROM utilisateurs
             WHERE email = ?
             LIMIT 1"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        // Vérification du mot de passe
        if (!$user || !password_verify($password, $user['password'])) {

            $error = 'E-mail ou mot de passe incorrect.';

        } else {

            // Sécurité
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['nom'];
            $_SESSION['prenom'] = $user['Prenom'];
            $_SESSION['email'] = $user['email'];

            header('Location: Accueil.php');
            exit;
        }
    }
}

$pageTitle = 'Connexion';

?>


 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>         Cook With Soumi
  <?php echo isset($pageTitle) ? ' — ' . htmlspecialchars($pageTitle) : ''; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/auth.css">
</head>
<body>
    <main class="auth-page">

    <div class="auth-card">

        <img
            class="auth-logo"
            src="./img/CookWithSoumi-logo.png"
            alt="Cook With Soumi Logo">

        <h1 class="auth-title">Bienvenue !</h1>

        <p class="auth-subtitle">
            Connectez-vous à votre compte Cook With Soumi
        </p>

        <?php if ($error): ?>
            <div class="alert alert-error">
                ⚠ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form
            class="auth-form"
            method="POST"
            action="login.php">

            <div class="form-group">

                <label for="email">E-mail</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo $oldEmail; ?>"
                    placeholder="vous@email.com"
                    required
                    autocomplete="email">

            </div>

            <div class="form-group">

                <label for="password">Mot de passe</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Votre mot de passe"
                    required
                    autocomplete="current-password">

            </div>

            <button type="submit" class="btn-auth">
                Se connecter 🍽️
            </button>

        </form>

        <p class="auth-link">
            Pas encore de compte ?
            <a href="register.php">Créer un compte</a>
        </p>

    </div>

</main>

<?php
closeDB();
include 'footer.php';
?>
</body>
</html>




