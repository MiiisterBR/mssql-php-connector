<?php
session_start();
include __DIR__ . '/../core/functions.php';

if (!isAuthenticated()) {
    header("Location: /views/login.php");
    exit;
}

$tableList = getTableList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="../assets/tailwind-4.js"></script>
    <script src="../assets/jquery-3.js"></script>
    <meta name="author" content="MisterBR" />

    <?php echo getEnv('ANALYTICS_TRACKING_SCRIPT'); ?>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<div class="w-full bg-white shadow-md p-4 flex justify-between">
    <a href="/views/setup_db.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-600">Edit
        Database Info</a>
    <button id="logoutBtn" class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-600">Logout</button>
</div>

<div class="w-full mx-auto mt-6 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-xl font-bold text-gray-800 text-center mb-6">Database Query</h1>

    <!-- Error Alert -->
    <div id="errorAlert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
         role="alert">
        <span class="block sm:inline" id="errorMessage">Database connection failed.</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="$('#errorAlert').fadeOut();">
            <span class="text-red-500 font-bold">&times;</span>
        </button>
    </div>

    <form id="queryForm" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div>
            <label for="table_name" class="block text-sm font-medium text-gray-700">Table Name</label>
            <input type="text" name="table_name" id="table_name" list="tableList" required autofocus
                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <datalist id="tableList">
                <?php foreach ($tableList as $table) echo "<option value='$table'></option>"; ?>
            </datalist>
        </div>
        <div>
            <label for="where_clause" class="block text-sm font-medium text-gray-700">WHERE Clause</label>
            <input type="text" name="where_clause" id="where_clause"
                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="limit" class="block text-sm font-medium text-gray-700">Limit</label>
            <input type="number" name="limit" id="limit" value="100" min="0"
                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit" class="col-span-1 md:col-span-3 bg-blue-500 text-white py-2 rounded-lg font-bold hover:bg-blue-600">
            Run Query
        </button>
    </form>

    <!-- Loading Indicator -->
    <div id="loading" class="hidden flex justify-center mt-4">
        <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
    </div>

    <div id="dataContainer" class="w-full overflow-x-auto"></div>
</div>

<script src="../assets/script.js"></script>

</body>
</html>
