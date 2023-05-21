<?php

use Guynoolla\App\Repository\UserRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode($_POST['params']);

    $userRepo = new UserRepository($this->db);
    $user = $userRepo->findByUsername($data->username);

    if (!$user || !password_verify($data->password, $user->password_hash)) {
        exit(json_encode([
            'success' => 0,
            'error' => 'Неверное имя пользователя или пароль.'
        ], JSON_UNESCAPED_UNICODE));

    } else {
        $this->authenticate($user->id);
        flash('success', "Добро пожаловать, {$user->username}!");
        exit(json_encode([
            'success' => 1,
            'redirectUrl' => $this->urlManager->action('/')
        ], JSON_UNESCAPED_UNICODE));
    }
}
