<?php

namespace quiz\Controllers;

use PDO;
use quiz\Core\Database;
use quiz\Core\Validation;
use quiz\Core\View;

class QuizController
{
    public function showHome(): void
    {
        //get test names, test id & render homepage
        $tests = Database::getInstance()->getAllTests();
        View::showHome('home.php', [
            $tests,
        ]);
    }

    public function checkQuiz(): void
    {
        $tests = Database::getInstance()->getAllTests();

        $validation = new Validation([
            'name' => 'required',
            'quiz' => 'required',
        ]);

        // if no errors then start new quiz
        $errors = $validation->getErrors();
        if (empty($errors)) {
            $this->initQuiz();
        } // if errors occurred rendering homepage with message
        else {
            View::showHome('home.php', [
                $tests,
                $errors,
            ]);
        }
    }

    public function initQuiz(): void
    {
        $pdo = Database::getInstance()->connection();

        // new user with assigned test id
        $stmt = $pdo->prepare('INSERT INTO users (name, test_id) VALUES (:uName, :tId)');
        $stmt->bindParam(':uName', $_POST['name']);
        $stmt->bindParam(':tId', $_POST['quiz']);
        $stmt->execute();
        $userId = $pdo->lastInsertId();

        // getting quiz questions ids & form new progress columns
        $stmt = $pdo->prepare('SELECT question_id FROM test_question WHERE test_id = :id');
        $stmt->bindParam(':id', $_POST['quiz']);
        $stmt->execute();
        $quizQuestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($quizQuestions as $question) {
            $sql1 = "INSERT INTO progress (user_id, test_id, question_id) VALUES (:uId, :tId, :qId)";
            $stmt = $pdo->prepare($sql1);
            $stmt->bindParam(':uId', $userId);
            $stmt->bindParam(':tId', $_POST['quiz']);
            $stmt->bindParam(':qId', $question['question_id']);
            $stmt->execute();
        }

        $this->showNextQuestion($userId);
    }

    public function showNextQuestion(int $userId): void
    {
        $pdo = Database::getInstance()->connection();
        $stmt = $pdo->prepare('SELECT * FROM progress WHERE user_id = :uId AND answer_id IS NULL');
        $stmt->bindParam(':uId', $userId);
        $stmt->execute();
        $progress = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $aCount = $stmt->rowCount();

        if (!empty($progress)) {
            // select question & answers
            $stmt = $pdo->prepare('SELECT * FROM questions WHERE id = :id LIMIT 1');
            $stmt->bindParam(':id', $progress[0]['question_id']);
            $stmt->execute();
            $question = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $pdo->prepare('SELECT * FROM question_answer as QA INNER JOIN answers as A 
                                        ON QA.answer_id = A.id WHERE question_id = :id');
            $stmt->bindParam(':id', $progress[0]['question_id']);
            $stmt->execute();
            $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // progress bar percent calculation
            $stmt = $pdo->prepare('SELECT * FROM progress WHERE user_id = :id');
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $qCount = $stmt->rowCount();

            $progressBar = (float)abs((($aCount / $qCount) * 100) - 100);

            View::showQuiz('quiz.php', [
                $answers,
                $question,
                $userId,
                $progressBar,
            ]);
        } else {
            $this->showFinishedTest($userId);
        }
    }

    public function saveAnswer(): void
    {
        $pdo = Database::getInstance()->connection();

        // updating progress table with new answer
        $stmt = $pdo->prepare('UPDATE progress SET answer_id=:answer_id, finished_at=:datetime
                                WHERE user_id = :uId AND question_id=:qId');
        $stmt->bindParam(':answer_id', $_POST['uInput']);
        $stmt->bindValue(':datetime', date("Y-m-d H:i:s"));
        $stmt->bindParam(':uId', $_POST['user_id']);
        $stmt->bindParam(':qId', $_POST['question_id']);
        $stmt->execute();

        $this->showNextQuestion($_POST['user_id']);
    }

    public function showFinishedTest(int $userId): void
    {
        // fetch answers and compare with correct ones
        $pdo = Database::getInstance()->connection();

        $stmt = $pdo->prepare('SELECT * FROM progress as PG LEFT JOIN questions as QT 
                                    ON PG.question_id = QT.id WHERE user_id = :uId');
        $stmt->bindParam(':uId', $userId);
        $stmt->execute();
        $progress = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $correctAns = 0;
        foreach ($progress as $row) {
            if ($row['answer_id'] == $row['correct_answer_id']) {
                $testId = $row['test_id'];
                $correctAns++;
            }
        }
        // Saving new results on finished quiz
        $stmt = $pdo->prepare('INSERT INTO results (user_id, test_id, correct_answers, total_answers, finished_at)
                                     VALUES (:uId, :tId, :cAnswers, :tAnswers, :datetime)');
        $stmt->bindParam(':uId', $userId);
        $stmt->bindParam(':tId', $testId);
        $stmt->bindParam(':cAnswers', $correctAns);
        $stmt->bindValue(':tAnswers', sizeof($progress));
        $stmt->bindValue(':datetime', date("Y-m-d H:i:s"));
        $stmt->execute();
        $resultsId = $pdo->lastInsertId();

        header("Location:/finish/$resultsId");
    }

    public function showQuizResults(array $params): void
    {
        $resultsId = (int)$params['results'];
        $pdo = Database::getInstance()->connection();
        $stmt = $pdo->prepare('SELECT * FROM results WHERE id = :id');
        $stmt->bindParam(':id', $resultsId);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $pdo = Database::getInstance()->connection();
        $stmt = $pdo->prepare('SELECT name FROM users WHERE id = :id');
        $stmt->bindParam(':id', $results['user_id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        View::showFinishedQuiz('quiz-finish.php', [
            $user['name'],
            $results['correct_answers'],
            $results['total_answers']
        ]);
    }


}