<?php

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
