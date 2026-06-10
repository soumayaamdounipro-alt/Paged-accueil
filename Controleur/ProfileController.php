<?php
require_once __DIR__ . '/../Model/ProfileModel.php';

class ProfileController
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ' . URL . '?page=login');
            exit;
        }

        $model = new ProfileModel();
        $user  = $model->getUserById($_SESSION['user_id']);

        if (!$user) {
            session_destroy();
            header('Location: ' . URL . '?page=login');
            exit;
        }

        $pageTitle = 'Mon Profil';
        require_once __DIR__ . '/../Vue/profile.php';
    }
}

$controller = new ProfileController();
$controller->index();
