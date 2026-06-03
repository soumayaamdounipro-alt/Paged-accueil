<?php
// ══════════════════════════════════════════
// COOK WITH SOUMI — includes/header.php
// Shared HTML <head> + navbar
// ══════════════════════════════════════════
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Cook With Soumi
        <?php echo isset($pageTitle) ? ' — ' . htmlspecialchars($pageTitle) : ''; ?>
    </title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/auth.css">
</head>
<body>

<nav id="navbar" class="scrolled">

    <a href="index.php">
        <img
            class="logo"
            src="./img/CookWithSoumi-logo.png"
            alt="Cook With Soumi Logo"
            onerror="this.style.display='none';">
    </a>

    <ul class="nav-links">

        <li><a href="index.php">Home</a></li>

        <?php if (!empty($_SESSION['user_id'])): ?>

            <li><a href="profile.php">My Profile</a></li>
            <li><a href="logout.php" class="nav-cta">Log out</a></li>

        <?php else: ?>

            <li><a href="login.php">Log in</a></li>
            <li><a href="register.php" class="nav-cta">Sign up</a></li>

        <?php endif; ?>

    </ul>

</nav>