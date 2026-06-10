<?php
require_once __DIR__ . '/../Model/UserModel.php';

class LoginController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $error    = '';
        $oldEmail = '';

        if (!empty($_SESSION['user_id'])) {
            header('Location: ' . URL . '?page=accueil');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email    = trim($_POST['email']    ?? '');
            $password =      $_POST['password'] ?? '';
            $oldEmail = htmlspecialchars($email);

            if (empty($email) || empty($password)) {
                $error = 'Veuillez remplir tous les champs.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse e-mail invalide.';
            } else {
                $user = $this->userModel->getUserByEmail($email);

                if (!$user || !password_verify($password, $user['password'])) {
                    $error = 'E-mail ou mot de passe incorrect.';
                } else {
                    session_regenerate_id(true);
                    $_SESSION['user_id']  = $user['id'];
                    $_SESSION['username'] = $user['last_name'];
                    $_SESSION['prenom']   = $user['first_name'];
                    $_SESSION['email']    = $user['email'];

                    header('Location: ' . URL . '?page=accueil');
                    exit;
                }
            }
        }

        require_once __DIR__ . '/../Vue/login.php';
    }
}

$controller = new LoginController();
$controller->login();
