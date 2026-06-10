<?php
// ══════════════════════════════════════════
// COOK WITH SOUMI — Router principal
// URL: http://localhost//
// ══════════════════════════════════════════

session_start();

require_once __DIR__ . '/config.php';

// Récupère la page demandée (ex: ?page=login)
$page = $_GET['page'] ?? 'accueil';

switch ($page) {

    case 'accueil':
        require_once __DIR__ . '/Vue/Accueil.php';
        break;

    case 'login':
        require_once __DIR__ . '/Controleur/LoginController.php';
        break;

    case 'register':
        require_once __DIR__ . '/Controleur/RegisterController.php';
        break;

    case 'profile':
        require_once __DIR__ . '/Controleur/ProfileController.php';
        break;

    case 'logout':
        require_once __DIR__ . '/Controleur/logout.php';
        break;

    default:
        http_response_code(404);
        echo "<h1>Page introuvable (404)</h1>";
        break;
}
