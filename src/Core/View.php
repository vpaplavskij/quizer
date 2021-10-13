<?php

namespace quiz\Core;

class View
{
    public static function showHome(string $path, array $variables = [])
    {
        if (!empty($variables)) {
            extract($variables);
            if (!empty($variables[0])) {
                $tests = $variables[0];
            }
            if (!empty($variables[1])) {
                $errors = $variables[1];
            }
        }

        require 'src/Views/' . $path;
    }

    public static function showQuiz(string $path, array $variables = [])
    {
        if (!empty($variables)) {
            extract($variables);
            if (!empty($variables[0])) {
                $answers = $variables[0];
            }
            if (!empty($variables[1])) {
                $question = $variables[1];
            }
            if (!empty($variables[2])) {
                $userId = $variables[2];
            }
            if (!empty($variables[3])) {
                $progressBar = $variables[3];
            }
        }
        require 'src/Views/' . $path;
    }

    public static function showFinishedQuiz(string $path, array $variables = [])
    {
        if (!empty($variables)) {
            extract($variables);
            if (!empty($variables[0])) {
                $username = $variables[0];
            }
            if (!empty($variables[1])) {
                $correctAns = $variables[1];
            }
            if (!empty($variables[2])) {
                $totalAns = $variables[2];
            }
        }
        require 'src/Views/' . $path;
    }
}

