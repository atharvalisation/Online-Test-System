<?php
$host = 'localhost';
$db   = 'online_test_system';
$user = 'root';  // Replace with your MySQL username
$pass = '';      // Replace with your MySQL password
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

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testCode = $_POST['testCode'];
    $numQuestions = $_POST['numQuestions'];
    
    // Insert test details
    $stmt = $pdo->prepare("INSERT INTO tests (test_code) VALUES (?)");
    $stmt->execute([$testCode]);
    $testId = $pdo->lastInsertId();
    
    for ($i = 0; $i < $numQuestions; $i++) {
        $questionText = $_POST['questions'][$i];
        $correctOption = $_POST['correct'][$i];
        
        // Insert question
        $stmt = $pdo->prepare("INSERT INTO questions (test_id, question_text, correct_option) VALUES (?, ?, ?)");
        $stmt->execute([$testId, $questionText, $correctOption]);
        $questionId = $pdo->lastInsertId();
        
        // Insert options
        foreach ($_POST['options'][$i] as $option) {
            $stmt = $pdo->prepare("INSERT INTO options (question_id, option_text) VALUES (?, ?)");
            $stmt->execute([$questionId, $option]);
        }
    }
    
    $message = "Test created successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Test Creation</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1e5799 0%, #7db9e8 100%);
            color: #fff;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 5% 10%;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            margin: 5% auto;
            backdrop-filter: blur(15px);
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 5%;
            text-align: center;
            text-transform: uppercase;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 20px;
            font-size: 1.2em;
        }

        input[type="text"],
        input[type="number"] {
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            font-size: 1.2em;
            color: #fff;
            transition: background 0.3s;
            width: 100%;
            
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            background: rgba(255, 255, 255, 0.3);
            outline: none;
        }

        button {
            padding: 12px 24px;
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            background: #4CAF50;
            color: #fff;
            font-size: 1.2em;
            cursor: pointer;
            transition: background 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
        }

        button:hover {
            background: #45a049;
        }

        .question-section {
            background: rgba(255, 255, 255, 0.2);
            padding: 25px;
            margin-top: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            padding: 12px 0;
            font-size: 1.1em;
            margin-right: 20px;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .container {
                padding: 10% 5%;
                margin: 10% auto;
            }
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <div class="container" name="container">
        
        <h2>Create a New Test</h2>
        <form action="" method="post">
            <label for="testCode">Enter Test Code:</label>
            <input type="text" id="testCode" name="testCode" required>
            
            <label for="numQuestions">Number of Questions:</label>
            <input type="number" id="numQuestions" name="numQuestions" min="1" required>
            
            <div id="questionContainer"></div>
            
            <button type="button" onclick="addQuestions()">Add Questions</button>
            <button type="submit">Create Test</button>
        </form>
    </div>

    <!-- Popup HTML -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
    <?php if ($message): ?>
        <p><span style="color: green;"><?php echo $message; ?></span></p>
                <script>
                    // Automatically show the popup when the test is created
                    window.onload = function() {
                        showPopup();
                    };
                </script>
            <?php endif; ?>
        <button onclick="hidePopup()">OK</button>
    </div>

    <script>
    
        function addQuestions() {
            const numQuestions = document.getElementById('numQuestions').value;
            let html = '';
            for (let i = 0; i < numQuestions; i++) {
                html += `
                <div class="question-section">
                    <label for="question${i+1}">Question ${i+1}:</label>
                    <input type="text" id="question${i+1}" name="questions[]" required>
                    
                    <ul>
                        <li><input type="radio" name="correct[${i}]" value="a"> <input type="text" name="options[${i}][a]" placeholder="Option A" required></li>
                        <li><input type="radio" name="correct[${i}]" value="b"> <input type="text" name="options[${i}][b]" placeholder="Option B" required></li>
                        <li><input type="radio" name="correct[${i}]" value="c"> <input type="text" name="options[${i}][c]" placeholder="Option C" required></li>
                        <li><input type="radio" name="correct[${i}]" value="d"> <input type="text" name="options[${i}][d]" placeholder="Option D" required></li>
                    </ul>
                </div>`;
            }
            document.getElementById('questionContainer').innerHTML = html;
        }
        function showPopup() {
            // Show the overlay and popup
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }

        function hidePopup() {
            // Hide the overlay and popup
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }
    </script>
</body>

</html>
