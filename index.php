<?php
// Database connection
$host = 'localhost';
$db   = 'online_test_system';
$user = 'root';  
$pass = '';      
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $testCode = $_POST['test_code'];
    header("Location: test.php?code=$testCode");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Test Code</title>
</head>
<body>
    <form action="" method="post">
        <label for="test_code">Enter Test Code:</label>
        <input type="text" name="test_code" id="test_code" required>
        <button type="submit">Start Test</button>
    </form>
</body>
</html>
