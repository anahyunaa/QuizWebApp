<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $nim = $_POST['nim'] ?? '';

    if (empty($name) || empty($nim)) {
        die("Name or NIM cannot be empty!");
    }

    $_SESSION['name'] = $name;
    $_SESSION['nim'] = $nim;
    $_SESSION['score'] = 0; // Belum diset
}

if (isset($_POST['score'])) {
    $_SESSION['score'] = $_POST['score'];
    header('Location: result.php');
    exit();
}

$questions = [
    ["type" => "choice", "question" => "Berapakah hasil dari 8 + 5?", "choices" => ["11", "12", "13", "14"], "answer" => "13", "points" => 10],
    ["type" => "choice", "question" => "Berapakah hasil dari 9 - 4?", "choices" => ["3", "4", "5", "6"], "answer" => "5", "points" => 10],
    ["type" => "choice", "question" => "Berapakah hasil dari 3 x 4?", "choices" => ["11", "12", "13", "14"], "answer" => "12", "points" => 10],
    ["type" => "choice", "question" => "Berapakah hasil dari 15 ÷ 3?", "choices" => ["3", "4", "5", "6"], "answer" => "5", "points" => 10],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="quiz-container">
        <div id="question-navigation">
        </div>
        <p id="question-number"></p>
        <p id="question"></p>
        <div id="choices"></div>
        <input type="text" id="answer" placeholder="Your answer" style="display: none;">
        <button id="next">Next</button>
        <p id="timer">Time remaining: <span id="time-left">30</span>s</p>
        <p id="status"></p>
    </div>

    <script>
        const questions = <?php echo json_encode($questions); ?>;

        let currentQuestionIndex = 0;
        let score = 0;
        let timer;
        let timeLeft = 30;
        let answeredQuestions = Array(questions.length).fill(false);

        function startQuiz() {
            createNavigation();
            showQuestion();
            startTimer();
        }

        function createNavigation() {
            let navContainer = document.getElementById('question-navigation');
            navContainer.innerHTML = ''; 
            questions.forEach((_, index) => {
                let button = document.createElement('button');
                button.innerText = index + 1;
                button.onclick = () => navigateToQuestion(index);
                button.classList.toggle('completed', answeredQuestions[index]); 
                navContainer.appendChild(button);
            });
        }

        function showQuestion() {
            if (currentQuestionIndex >= questions.length) {
                endQuiz();
                return;
            }

            let questionData = questions[currentQuestionIndex];
            document.getElementById('question-number').innerText = `Question ${currentQuestionIndex + 1}`;
            document.getElementById('question').innerText = questionData.question;
            let choicesDiv = document.getElementById('choices');
            choicesDiv.innerHTML = '';
            let answerInput = document.getElementById('answer');
            
            answerInput.style.display = questionData.type === 'text' ? 'block' : 'none';
            answerInput.value = ''; 

            if (questionData.type === 'choice') {
                questionData.choices.forEach((choice) => {
                    let button = document.createElement('button');
                    button.innerText = choice;
                    button.onclick = () => answerQuestion(choice);
                    choicesDiv.appendChild(button);
                });
            }

            updateNavigation();
            startTimer();
        }

        function answerQuestion(answer = null) {
            let questionData = questions[currentQuestionIndex];
            
            if (questionData.type === 'text') {
                answer = document.getElementById('answer').value.trim();
            }

            if (answer === questionData.answer) {
                score += questionData.points;
                answeredQuestions[currentQuestionIndex] = true; 
            } else {
                answeredQuestions[currentQuestionIndex] = false;
            }

            updateNavigation();
            currentQuestionIndex++;
            clearInterval(timer);
            showQuestion();
            startTimer();
        }

        function startTimer() {
            clearInterval(timer); 
            timeLeft = 30;
            document.getElementById('time-left').innerText = timeLeft;
            timer = setInterval(() => {
                timeLeft--;
                document.getElementById('time-left').innerText = timeLeft;
                if (timeLeft === 0) {
                    clearInterval(timer);
                    nextQuestion();
                }
            }, 1000);
        }

        function nextQuestion() {
            clearInterval(timer);
            currentQuestionIndex++;
            showQuestion();
        }

        function navigateToQuestion(index) {
            clearInterval(timer);
            currentQuestionIndex = index;
            showQuestion();
        }

        function updateNavigation() {
            let navButtons = document.querySelectorAll('#question-navigation button');
            navButtons.forEach((button, index) => {
                button.classList.toggle('active', index === currentQuestionIndex); 
                button.classList.toggle('completed', answeredQuestions[index]);
            });
        }

        function endQuiz() {
            // Save score and redirect to results page
            let playerData = { score: score };
            localStorage.setItem('playerData', JSON.stringify(playerData));
            location.href = 'result.php'; // Change to PHP file for result
        }

        startQuiz();
    </script>
</body>
</html>
