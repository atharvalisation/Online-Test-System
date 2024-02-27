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

$testCode = $_GET['code'] ?? '';
if (!$testCode) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tests WHERE test_code = ?");
$stmt->execute([$testCode]);
$test = $stmt->fetch();

if (!$test) {
    echo "Invalid test code!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $elementNumber = $_POST['element_number'];
    $rollNumber = $_POST['roll_number'];
    foreach ($_POST['answers'] as $questionId => $answer) {
        $stmt = $pdo->prepare("INSERT INTO student_responses (test_id, question_id, student_name, element_number, roll_number, answer) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$test['id'], $questionId, $name, $elementNumber, $rollNumber, $answer]);
    }
    echo "Test submitted successfully!";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM questions WHERE test_id = ?");
$stmt->execute([$test['id']]);
$questions = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Test</title>
</head>
<body>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <label for="element_number">Element Number:</label>
        <input type="text" name="element_number" id="element_number" required><br>
        <label for="roll_number">Roll Number:</label>
        <input type="text" name="roll_number" id="roll_number" required><br>
        <?php foreach ($questions as $question): ?>
            <p><?php echo $question['question_text']; ?></p>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM options WHERE question_id = ?");
            $stmt->execute([$question['id']]);
            $options = $stmt->fetchAll();
            foreach ($options as $option): ?>
                <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="<?php echo $option['id']; ?>"> <?php echo $option['option_text']; ?><br>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <button type="submit">Submit Test</button>
    </form>
</body>
</html>
