<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to encrypt data for secure cookie storage
if (!function_exists('encryptData')) {
    function encryptData($data)
    {
        $config = include __DIR__ . '/../config/config.php';
        return base64_encode(openssl_encrypt(json_encode($data), 'AES-128-ECB', $config['encryption_key']));
    }
}

// Function to decrypt data from secure cookies
if (!function_exists('decryptData')) {
    function decryptData($data)
    {
        $config = include __DIR__ . '/../config/config.php';
        return json_decode(openssl_decrypt(base64_decode($data), 'AES-128-ECB', $config['encryption_key']), true);
    }
}

// Function to get available table names from JSON file
if (!function_exists('getTableList')) {
    function getTableList()
    {
        $file_path = __DIR__ . '/../config/tables.json';
        if (!file_exists($file_path)) {
            file_put_contents($file_path, json_encode(["Address", "Alternativeltem", "Alternativeltems", "Application"]));
        }
        return json_decode(file_get_contents($file_path), true);
    }
}

// Function to check if the user is authenticated
if (!function_exists('isAuthenticated')) {
    function isAuthenticated()
    {
        return isset($_SESSION['auth']);
    }
}

// Function to log out the user by clearing session and cookies
if (!function_exists('logout')) {
    function logout()
    {
        session_destroy();
        setcookie('auth', '', time() - 3600, '/');
        header("Location: /views/login.php");
        exit;
    }
}

// Function to get environment variables from .env file
if (!function_exists('getEnv')) {
    function getEnv($key)
    {
        $file = file_get_contents(__DIR__ . '/../.env');
        $lines = explode("\n", $file);
        foreach ($lines as $line) {
            $parts = explode("=", $line);
            if ($parts[0] === $key) {
                return $parts[1];
            }
        }
        return null;
    }
}
