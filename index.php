<?php
// Mengecek status halaman yang akan ditampilkan berdasarkan query string
$page = isset($_GET['page']) ? $_GET['page'] : 'landing';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if ($page == 'landing'): ?>
        <!-- Halaman Landing Page -->
        <div class="landing-page">
            <button onclick="window.location.href='index.php?page=player_data'">Start Quiz</button>
        </div>

    <?php elseif ($page == 'player_data'): ?>
        <!-- Halaman Form Data Pemain -->
        <div class="form-container">
            <h2>Enter Your Details</h2>
            <form id="player-form" action="latihan.php" method="post">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>

                <label for="nim">NIM:</label>
                <input type="text" name="nim" id="nim" required>

                <button type="submit">Start Quiz</button>
            </form>
        </div>

    <?php elseif ($page == 'quiz'): ?>
        <!-- Halaman Quiz -->
        <div id="quiz-container">
            <div id="question-navigation"></div>
            <p id="question-number"></p>
            <p id="question"></p>
            <div id="choices"></div>
            <input type="text" id="answer" placeholder="Your answer">
            <button onclick="nextQuestion()" id="next">Next</button>
            <p id="timer">Time remaining: <span id="time-left">30</span>s</p>
            <p id="status"></p>
        </div>
        
        <script src="script.js"></script>

    <?php elseif ($page == 'result'): ?>
        <!-- Halaman Hasil Quiz -->
        <h2>Quiz Result</h2>
        <p id="player-name"><?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'Player Name'; ?></p>
        <p id="player-nim"><?php echo isset($_POST['nim']) ? htmlspecialchars($_POST['nim']) : 'Player NIM'; ?></p>
        <p id="total-score">Your Score: 85/100</p>
        <button onclick="window.location.href='index.php?page=landing'">Retake Quiz</button>

    <?php endif; ?>
    
    <script src="script.js"></script>
</body>
</html>
