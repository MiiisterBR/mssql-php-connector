<?php
session_start();
include __DIR__ . '/functions.php';

if (!isAuthenticated()) {
    die(json_encode(['status' => 'ERR', 'msg' => 'Unauthorized']));
}

if (!isset($_COOKIE['db_credentials'])) {
    die(json_encode(['status' => 'ERR', 'msg' => 'No database credentials found. Please enter database details.']));
}

$credentials = decryptData($_COOKIE['db_credentials']);

try {
    $conn = new PDO(
        "sqlsrv:server={$credentials['server']},{$credentials['port']};Database={$credentials['database']};TrustServerCertificate=true",
        $credentials['user'],
        $credentials['password']
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    die(json_encode(['status' => 'ERR', 'msg' => 'Database connection failed', 'details' => $exception->getMessage()]));
}
