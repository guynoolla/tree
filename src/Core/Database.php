<?php

namespace Guynoolla\App\Core;

use PDO;

final class Database extends PDO
{
	private static $instance = NULL;

	private function __construct(array $settings)
	{
		$host = $settings['host'];
        $name = $settings['name'];
        $user = $settings['user'];
        $pass = $settings['password'];
        $char = $settings['charset'];

		$dsn = "mysql:host={$host};dbname={$name};charset={$char}";

		parent::__construct($dsn, $user, $pass);

		$this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    	$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public static function getInstance(array $settings)
	{
		if (self::$instance === NULL) {
			self::$instance = new Database($settings);
		}

		return self::$instance;
	}
}
