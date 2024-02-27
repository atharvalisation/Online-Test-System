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

// ... [Database connection code remains the same]

// ... [Database connection code remains the same]

if (isset($_POST['test_code'])) {
    $testCode = $_POST['test_code'];

    // Fetch results from database
    $stmt = $pdo->prepare("SELECT student_name, element_number, roll_number,  FROM student_responses WHERE test_id = (SELECT id FROM tests WHERE test_code = ?);");
$stmt->execute([$testCode]);
$results = $stmt->fetchAll();

    // Display results
    if ($results) {
        echo "<table border='1'>
                <tr>
                    <th>Student Name</th>
                    <th>Element Number</th>
                    <th>Roll Number</th>
                    <th>Score1</th>
                    <th>Score2</th>
                    <th>Score3</th>
                    <th>Score4</th>
                </tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . $row['student_name'] . "</td>
                    <td>" . $row['element_number'] . "</td>
                    <td>" . $row['roll_number'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No results found for the entered test code.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results</title>
</head>
<body>
    <form action="" method="POST">
        <label for="test_code">Enter Test Code:</label>
        <input type="text" id="test_code" name="test_code" required>
        <input type="submit" value="Get Results">
    </form>
</body>
</html>
