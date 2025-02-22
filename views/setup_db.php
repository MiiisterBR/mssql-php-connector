<?php
session_start();
include __DIR__ . '/../core/functions.php';

if (!isAuthenticated()) {
    header("Location: /views/login.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_credentials = [
        'server' => $_POST['server'] ?? '',
        'port' => $_POST['port'] ?? '1433',
        'database' => $_POST['database'] ?? '',
        'user' => $_POST['user'] ?? '',
        'password' => $_POST['password'] ?? ''
    ];

    // Set cookie and ensure it is stored before redirecting
    setcookie('db_credentials', encryptData($db_credentials), time() + ((intval(getenv('COOKIE_EXPIRE')) ?: 1) * 24 * 60 * 60), '/');
    $_COOKIE['db_credentials'] = encryptData($db_credentials); // Ensure it is available immediately

    // Verify that the cookie is successfully set before redirecting
    if (!isset($_COOKIE['db_credentials']) || empty($_COOKIE['db_credentials'])) {
        $error = "Failed to save database settings. Please enable cookies.";
    } else {
        header("Location: /views/index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Database</title>
    <script src="../assets/tailwind-4.js"></script>
    <meta name="author" content="MisterBR"/>

    <?php echo getEnv('ANALYTICS_TRACKING_SCRIPT'); ?>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Setup Database</h1>

    <?php if (!empty($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
                    onclick="this.parentElement.style.display='none';">
                <span class="text-red-500 font-bold">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label for="server" class="block text-sm font-medium text-gray-700">Server</label>
            <input type="text" name="server" required autofocus
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="port" class="block text-sm font-medium text-gray-700">Port</label>
            <input type="text" name="port" value="1433" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="database" class="block text-sm font-medium text-gray-700">Database Name</label>
            <input type="text" name="database" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="user" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="user" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg font-bold hover:bg-blue-600">
            Save Database Info
        </button>
        <button id="logoutBtn" type="button" class="w-full bg-red-500 text-white py-2 px-4 rounded-lg font-bold hover:bg-red-600 mt-2">
            Logout
        </button>
    </form>
</div>
<script>
    document.getElementById('logoutBtn').addEventListener('click', function () {
        window.location.href = '/views/logout.php';
    });
</script>
</body>
</html>
