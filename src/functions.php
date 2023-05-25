<?php

function pr($a, $b="") {
    if ($a && $b) {
        echo "<pre>$a " . print_r($b, 1) . '</pre>';
    } else {
        echo '<pre>' . print_r($a, 1) . '</pre>';
    }
}

function flash(string $type="", string $message="")
{
    if (isset($_SESSION['flash'])) {
        $flash = unserialize($_SESSION['flash']);
        unset($_SESSION['flash']);
        return [
            'type' => $flash['type'],
            'message' => $flash['message']
        ];
    } else {
        if ($type && $message) {
            $_SESSION['flash'] = serialize([
                'type' => $type,
                'message' => $message
            ]);
        }
    }
}

function classLoader($className)
{
    $fileName = get_include_path() . '/' . $className . '.php';
    $fileName = str_replace("\\", '/', $fileName);
    if (file_exists($fileName)) {
        require_once($fileName);
    } else {
        trigger_error("Файл не найден.");
    }
}
