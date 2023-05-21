<?php

namespace Guynoolla\App\Core;

use Guynoolla\App\Core\Database;
use Guynoolla\App\Core\UrlManager;
use Guynoolla\App\Models\User;
use Guynoolla\App\Repository\UserRepository;

class Controller
{
    protected $config;
    protected $viewsPath;
    protected $db;
    protected $urlManager;
    protected $path;

    public function __construct(array $config, Database $db)
    {
        $this->config = $config;
        $this->viewsPath = $config['app_root'] . DIRECTORY_SEPARATOR . $config['views_path'];
        $this->db = $db;
    }

    public function run(string $file, $path)
    {
        $this->path = implode("/", $path);
        $this->urlManager = new UrlManager($this->config['url_base'], $this->config['assets']);

        require $file;
    }

    protected function view($template, $data=[])
    {
        $templatePath = $this->viewsPath . DIRECTORY_SEPARATOR . $template . '.php';

        $data = array_merge($data, [
            'urlManager' => $this->urlManager,
            'user'       => $this->getUser(),
            'path'       => $this->path,
        ]);

        $data = ['data' => $data];

        if (file_exists($templatePath)) {
            if (!empty($data)) {
                extract($data);
            }
            require $templatePath;
            exit;
        } else {
            trigger_error("Темплейт '{$templatePath}' не найден.");
        }
    }

    function getTemplateFunctions()
    {
        include $this->viewsPath . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'template-functions.php';
    }

    public function redirect($action)
    {
        header("Location: " . $this->urlManager->action($action));
        exit;
    }

    public function checkAccess()
    {
        if (!$this->isLoggedIn()) {
            flash('warning', 'Пожалуйста, авторизуйтесь!');
            $this->redirect('/');
        }
    }

    public function authenticate(int $userId)
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
    }

    public function isLoggedIn()
    {
        return (isset($_SESSION['user_id']));
    }

    public function getUser()
    {
        if ($this->isLoggedIn()) {
            $userRepo = new UserRepository($this->db);
            $user = $userRepo->find($_SESSION['user_id']);
            return $user;
        }

        return null;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
		$_SESSION = array();

		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}

		session_destroy();
    }
}
