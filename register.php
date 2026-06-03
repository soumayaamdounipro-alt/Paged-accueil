<?php
session_start();

// Si l'utilisateur est déjà connecté
if (!empty($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}

require_once 'db.php';

$errors = [];
$success = '';

$old = [
    'username' => '',
    'prenom' => '',
    'email' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération des données
    $username = trim($_POST['username'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    $old = [
        'username' => htmlspecialchars($username),
        'prenom' => htmlspecialchars($prenom),
        'email' => htmlspecialchars($email)
    ];

    // Validation nom
    if (empty($username)) {
        $errors[] = 'Le nom est obligatoire.';
    }

    // Validation prénom
    if (empty($prenom)) {
        $errors[] = 'Le prénom est obligatoire.';
    }

    // Validation email
    if (empty($email)) {
        $errors[] = 'L\'adresse e-mail est obligatoire.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse e-mail invalide.';
    }

    // Validation mot de passe
    if (strlen($password) < 8) {
        $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }

    if ($password !== $confirm) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }

    if (empty($errors)) {

        $db = getDB();

        // Vérifier si l'email existe déjà
        $stmt = $db->prepare(
            "SELECT id FROM utilisateurs WHERE email = ? LIMIT 1"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = 'Cette adresse e-mail est déjà utilisée.';
        }

        $stmt->close();
    }

    // Création du compte
    if (empty($errors)) {

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $db->prepare(
            "INSERT INTO utilisateurs (nom, prenom, email, password)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssss",
            $username,
            $prenom,
            $email,
            $hash
        );

        if ($stmt->execute()) {

            $success = 'Compte créé avec succès !';

            $old = [
                'username' => '',
                'prenom' => '',
                'email' => ''
            ];

        } else {
            $errors[] = 'Erreur lors de la création du compte.';
        }

        $stmt->close();
    }
}

$pageTitle = 'Inscription';
include 'header.php';
?>

<main class="auth-page">
    <div class="auth-card">

        <img
            class="auth-logo"
            src="./img/CookWithSoumi-logo.png"
            alt="Cook With Soumi Logo">

        <h1 class="auth-title">Créer un compte</h1>

        <p class="auth-subtitle">
            Rejoignez la communauté Cook With Soumi
        </p>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <div>
                        ⚠ <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form
            class="auth-form"
            method="POST"
            action="register.php">

            <div class="form-group">
                <label for="username">Nom</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?php echo $old['username']; ?>"
                    placeholder="Votre nom"
                    required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>

                <input
                    type="text"
                    id="prenom"
                    name="prenom"
                    value="<?php echo $old['prenom']; ?>"
                    placeholder="Votre prénom"
                    required>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo $old['email']; ?>"
                    placeholder="vous@email.com"
                    required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimum 8 caractères"
                    required>
            </div>

            <div class="form-group">
                <label for="confirm">Confirmer le mot de passe</label>

                <input
                    type="password"
                    id="confirm"
                    name="confirm"
                    placeholder="Répétez le mot de passe"
                    required>
            </div>

            <button type="submit" class="btn-auth">
                Créer mon compte ✨
            </button>

        </form>

        <p class="auth-link">
            Vous avez déjà un compte ?
            <a href="login.php">Se connecter</a>
        </p>

    </div>
</main>

<?php
closeDB();
include 'footer.php';
?>