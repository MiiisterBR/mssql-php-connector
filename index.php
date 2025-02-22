<?php
session_start();
include __DIR__ . '/core/functions.php';

if (!isAuthenticated()) {
    header("Location: /views/login.php");
    exit;
} else {
    header("Location: /views/setup_db.php");
    exit;
}
