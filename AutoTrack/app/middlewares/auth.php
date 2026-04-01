<?php
return function($method, $params) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['user'])) {
        header('Location: ' . url('login'));
        exit;
    }

    return true;
};
