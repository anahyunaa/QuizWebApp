<?php
session_start(); 
if (!isset($_SESSION['name'], $_SESSION['nim'], $_SESSION['score'])) {
    header("Location: index.html"); 
    exit();
}

$name = $_SESSION['name'];
$nim = $_SESSION['nim'];
$score = $_SESSION['score'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Quiz Result</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
    <p><strong>NIM:</strong> <?php echo htmlspecialchars($nim); ?></p>
    <p><strong>Total Score:</strong> <?php echo htmlspecialchars($score); ?></p>
    <button onclick="location.href='index.html'">Retake Quiz</button>
</body>
</html>
