<?php

class Flash
{
    public function set($type, $message)
    {
        if (isset($_SESSION[$type])) {
            $messag = $_SESSION[$type];
            unset($_SESSION[$type]);
        }
    }
}