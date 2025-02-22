<?php
session_start();
include __DIR__ . '/../core/functions.php';

$config = include __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if (in_array($password, $config['passwords'])) {
        $_SESSION['auth'] = encryptData($password);
        header("Location: /views/setup_db.php");
        exit;
    } else {
        $error = "Invalid password!";
    }
}

if (isAuthenticated()) {
    header("Location: /views/setup_db.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="../assets/tailwind-4.js"></script>
    <meta name="author" content="MisterBR"/>

    <?php echo getEnv('ANALYTICS_TRACKING_SCRIPT'); ?>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h1>
    <form method="POST" class="space-y-4">
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password => <span>H16?3{xAec&p</span></label>
            <input type="password" name="password" value="H16?3{xAec&p" required autofocus
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg font-bold hover:bg-blue-600">
            Login
        </button>
    </form>
    <?php if (!empty($error)) echo "<p class='mt-4 text-red-500 text-center'>$error</p>"; ?>
</div>
</body>
</html>
