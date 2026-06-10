<?php $pageTitle = "Connexion"; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cook With Soumi — <?php echo htmlspecialchars($pageTitle); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Vue/css/auth.css">
</head>

<body>

    <main class="auth-page">
        <div class="auth-card">

            <img class="auth-logo"
                src="/Vue/img/CookWithSoumi-logo.png"
                alt="Cook With Soumi Logo">

            <h1 class="auth-title">Bienvenue !</h1>
            <p class="auth-subtitle">Connectez-vous à votre compte Cook With Soumi</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    ⚠ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST" action="/titre/?page=login">

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email"
                        value="<?php echo htmlspecialchars($oldEmail ?? ''); ?>"
                        placeholder="vous@email.com" required autocomplete="email">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password"
                        placeholder="Votre mot de passe" required autocomplete="current-password">
                </div>

                <button type="submit" class="btn-auth">Se connecter 🍽️</button>

            </form>

            <p class="auth-link">
                Pas encore de compte ?
                <a href="/titre/?page=register">Créer un compte</a>
            </p>

        </div>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>